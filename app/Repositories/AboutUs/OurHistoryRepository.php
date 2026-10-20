<?php

namespace App\Repositories\AboutUs;

use App\Models\AboutUs\OurHistory;

class OurHistoryRepository
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
        return OurHistory::query()
        ->where(function ($q) use ($search) {
            $q->where("title_en", "LIKE", "%$search%");
            $q->orWhere("title_id", "LIKE", "%$search%");
            $q->orWhere("tagline_en", "LIKE", "%$search%");
            $q->orWhere("tagline_id", "LIKE", "%$search%");
        })
        ->datatable($perPage, "sort", "asc");
    }

    public function get()
    {
        return OurHistory::query()
        ->orderBy("sort", "asc")->get()->map(function ($row) {
            $row->image = previewFile($row->image);
            $row->title = $row->title;
            $row->tagline = $row->tagline;
            $row->content = $row->content;
            return $row;
        });
    }
}
