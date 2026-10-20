<?php

namespace App\Repositories\Utility;

use Carbon\Carbon;
use App\Helpers\Helper;
use Illuminate\Support\Facades\App;
use App\Models\Utility\AdditionalFile;

class FileRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function getByType($type)
    {
        $type = str_replace("-", "_", $type);
        return AdditionalFile::query()
        ->where("type", $type)
        ->where(function ($q) use ($type) {
            if (!in_array($type, ['company_profile', 'guideline'])) {
                $q->where("show_on_governance", 1);
            }
        })
        ->orderBy("sort", "asc")
        ->get()->map(function ($row) {
            $row->file = json_decode($row->file);
            $row->name = $row->name;
            return $row;
        });
    }

    public function findPaginated($type)
    {
        $type = str_replace("-", "_", $type);
        $maxLimit = 15;
        $limit = request()->get('limit', $maxLimit);
        $search = request('search');
        $locale = App::currentLocale();

        $data = AdditionalFile::query()
        ->where("type", $type)
        ->when($search, fn ($q) => $q->where("name_{$locale}", "LIKE", "%$search%"))
        ->orderBy("created_at", "desc")
        ->orderBy("id", "desc")
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
                        $row->file = json_decode($row->file);
                        $row->date = Carbon::parse($row->created_at)->translatedFormat("d F Y");
                        return $row;
                })->values()
        ];
    }
}
