<?php

namespace App\Repositories\AboutUs;

use Carbon\Carbon;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Models\AboutUs\Certificate;

class CertificateRepository
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
        return Certificate::query()
        ->where(function ($q) use ($search) {
            $q->where("name_en", "LIKE", "%$search%");
            $q->orWhere("name_id", "LIKE", "%$search%");
        })
        ->datatable($perPage, "created_at");
    }

    public function findPaginated(Request $request)
    {
        $maxLimit = 15;
        $limit = $request->get('limit', $maxLimit);

        $data = Certificate::query()
            ->with(['category'])
            ->orderBy('date','desc')
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
                        $files = [];
                        foreach ($row->files as $file) {
                            $files[] = previewFile($file);
                        }

                        $row->category_name = $row->category?->name;
                        $row->name = $row->name;
                        $row->content = $row->content;
                        $row->short_content = $row->short_content;
                        $row->awarder = $row->awarder;
                        $row->files = $files;
                        $row->thumbnail = @$files[0];
                        $row->date = Carbon::parse($row->date)->translatedFormat("d M Y");
                        return $row;
                })->values()
        ];
    }
}
