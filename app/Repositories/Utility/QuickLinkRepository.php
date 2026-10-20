<?php

namespace App\Repositories\Utility;

use App\Models\Utility\QuickLink;

class QuickLinkRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function datatable()
    {
        return QuickLink::query()
        ->groupBy("category")
        ->get()->map(function (QuickLink $row) {
            $row->items = $this->getByCategory($row->category);
            return $row;
        });
    }

    public function getByCategory($category)
    {
        return QuickLink::query()->orderBy("sort", "asc")
        ->where("category", $category)
        ->orderBy("sort", "asc")
        ->get()->map(function ($row) {
            $row->name = $row->name;
            return $row;
        });
    }
}
