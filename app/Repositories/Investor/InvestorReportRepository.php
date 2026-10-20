<?php

namespace App\Repositories\Investor;

use App\Enums\InvestorReportType;
use App\Helpers\Helper;
use App\Models\Investor\InvestorReport;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ZipArchive;

class InvestorReportRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function datatable($perPage = 10)
    {
        $search = request('search');
        return InvestorReport::query()
        ->where(function ($q) use ($search) {
            $q->where("name_en", "LIKE", "%$search%");
            $q->orWhere("name_id", "LIKE", "%$search%");
            $q->orWhere("type", "LIKE", "%$search%");
        })
        ->datatable($perPage, "created_at");
    }

    public function latestReport($limit = 2)
    {
        return InvestorReport::query()
        ->where("type", InvestorReportType::FinancialReport)
        ->orderBy("datetime", "DESC")
        ->limit($limit)->get()->map(function ($row) {
            $row->file = json_decode($row->file);
            $row->name = $row->name;
            $row->name_slug = preg_replace('/[^A-Za-z0-9]+/', '_', $row->name);
            $row->name_slug_id = preg_replace('/[^A-Za-z0-9]+/', '_', $row->name_id);
            $row->name_slug_en = preg_replace('/[^A-Za-z0-9]+/', '_', $row->name_en);
            $row->date = Carbon::parse($row->datetime)->translatedFormat("d F Y");
            return $row;
        });
    }

    public function findPaginated(Request $request, $type)
    {
        $maxLimit = 15;
        $limit = $request->get('limit', $maxLimit);
        $search = $request->search;
        $locale = App::currentLocale();

        $data = InvestorReport::query()
            ->where("type", $type)
            ->when($search, fn ($q) => $q->where("name_{$locale}", "LIKE", "%$search%"))
            ->orderBy('datetime','desc')
            ->orderBy('id','desc')
            ->paginate($limit);
        return [
            'links' => Helper::makePagination($data),
            'meta' => Helper::metaPagination($data),
            'items' => collect($data->items())
                ->reverse()
                ->take($maxLimit)
                ->reverse()
                ->map(function ($row) {
                        $row->name = $row->name;
                        $row->name_slug = preg_replace('/[^A-Za-z0-9]+/', '_', $row->name);
                        $row->name_slug_id = preg_replace('/[^A-Za-z0-9]+/', '_', $row->name_id);
                        $row->name_slug_en = preg_replace('/[^A-Za-z0-9]+/', '_', $row->name_en);
                        $row->file = json_decode($row->file);
                        $row->date = Carbon::parse($row->datetime)->translatedFormat("d F Y");
                        return $row;
                })->values()
        ];

    }

    public function findPaginatedCalendar(Request $request)
    {
        $maxLimit = 15;
        $limit = $request->get('limit', $maxLimit);
        $search = $request->search;
        $locale = App::currentLocale();
        $year = request('year');
        $type = request('type');

        $data = InvestorReport::query()
            ->where(function ($q) use ($type) {
                if ($type) {
                    $q->where("type", $type);
                } else {
                    $q->whereIn("type", [
                        InvestorReportType::AnnualReport,
                        InvestorReportType::FinancialReport
                    ]);
                }
            })
            ->when($year, fn ($q) => $q->whereYear("datetime", $year))
            ->when($search, fn ($q) => $q->where("name_{$locale}", "LIKE", "%$search%"))
            ->orderBy('datetime','desc')
            ->orderBy('id','desc')
            ->paginate($limit);

        $items = collect($data->items())
            ->reverse()
            ->take($maxLimit)
            ->reverse()
            ->map(function ($row) {
                $row->name = $row->name;
                $row->name_slug = preg_replace('/[^A-Za-z0-9]+/', '_', $row->name);
                $row->name_slug_id = preg_replace('/[^A-Za-z0-9]+/', '_', $row->name_id);
                $row->name_slug_en = preg_replace('/[^A-Za-z0-9]+/', '_', $row->name_en);
                $row->file = json_decode($row->file);
                $row->date = Carbon::parse($row->datetime)->translatedFormat("d F Y");
                $row->year = Carbon::parse($row->datetime)->year;
                return $row;
            });

        // Grouping by year
        $grouped = $items->groupBy('year')->map(function ($group, $year) {
            return [
                'year' => $year,
                'items' => $group->values()
            ];
        })->values();

        return [
            'links' => Helper::makePagination($data),
            'meta' => Helper::metaPagination($data),
            'items' => $grouped
        ];
    }

    public function years()
    {
        $yearExpr = DB::connection()->getDriverName() === 'sqlite'
            ? "strftime('%Y', datetime) as year"
            : "YEAR(datetime) as year";

        return InvestorReport::query()
            ->selectRaw($yearExpr)
            ->whereIn("type", [
                InvestorReportType::AnnualReport,
                InvestorReportType::FinancialReport
            ])
            ->groupBy("year")
            ->orderBy("year", "desc")
            ->pluck("year")
            ->toArray();
    }

    public function downloadAllNewestReport()
    {
        $files = $this->latestReport();
        $zip = new ZipArchive;
        $zipFileName = 'latest-report-'.Str::random().'.zip';
        $zipPath = storage_path('app/temp/'.$zipFileName);

        if (!File::exists(storage_path('app/temp'))) {
            File::makeDirectory(storage_path('app/temp'), 0755, true);
        }

        if ($zip->open($zipPath, ZipArchive::CREATE) === TRUE) {
            foreach ($files as $row) {
                $fileData = is_object($row->file) ? $row->file : json_decode($row->file);
                if (!$fileData || empty($fileData->path)) {
                    continue;
                }
                $decryptedPath = Helper::shortDecrypt($fileData->path);
                $fullPath = Storage::disk('local')->path($decryptedPath);
                $fileName = $row->name . '.' . pathinfo($decryptedPath, PATHINFO_EXTENSION);

                if (file_exists($fullPath)) {
                    $zip->addFile($fullPath, $fileName);
                }
            }
            $zip->close();

            return response()->download($zipPath)->deleteFileAfterSend(true);
        } else {
            Log::error('Failed to create ZIP file in downloadAllNewestReport', [
                'user_id' => auth()->id(),
                'timestamp' => now()
            ]);

            throw new Exception('Failed to create ZIP file.');
        }
    }

}
