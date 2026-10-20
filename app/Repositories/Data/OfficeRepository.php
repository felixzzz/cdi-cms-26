<?php

namespace App\Repositories\Data;

use App\Models\Data\Office;

class OfficeRepository
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
        return Office::query()
        ->where(function ($q) use ($search) {
            $q->where("name", "LIKE", "%$search%");
            $q->orWhere("sub_title_en", "LIKE", "%$search%");
            $q->orWhere("sub_title_id", "LIKE", "%$search%");
        })
        ->datatable($perPage, "created_at");
    }

    public function getMain()
    {
        $office = Office::query()->where("is_main", 1)->first();
        if ($office) {
            $office->sub_title = $office->sub_title;
            $office->localized_main = $office->localized_main;
            $office->localized_branches = $office->localized_branches;
        }
        return $office;
    }

    public function getOthers()
    {
        return Office::query()->where("is_main", 0)
        ->orderBy("created_at", "asc")
        ->get()->map(function ($row) {
            $row->sub_title = $row->sub_title;
            $row->localized_main = $row->localized_main;
            $row->localized_branches = $row->localized_branches;

            return $row;
        });
    }
}
