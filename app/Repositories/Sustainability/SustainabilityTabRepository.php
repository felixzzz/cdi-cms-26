<?php

namespace App\Repositories\Sustainability;

use App\Models\Sustainability\SustainabilityTab;

class SustainabilityTabRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function datatable($category)
    {
        return SustainabilityTab::query()
        ->when($category, fn ($q) => $q->where("category", $category))
        ->orderBy("sort", "asc")
        ->get();
    }

    public function detail($type)
    {
        return SustainabilityTab::with(["contents"])
        ->where("category", $type)
        ->get()->map(function ($row) {
            $row->title = $row->title;
            $row->contents = $row->contents->map(function ($content) {
                $content->heading = $content->heading;
                $content->tagline = $content->tagline;
                $content->title = $content->title;
                $content->content = $content->content;
                $content->image = $content->image ? previewFile($content->image) : '';
                return $content;
            });
            return $row;
        });
    }
}
