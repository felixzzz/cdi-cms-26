<?php

namespace App\Repositories\Utility;

use App\Models\Sustainability\RatingRecognition;

class RatingRecognitionRepository
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
        return RatingRecognition::query()
        ->groupBy("type")
        ->get()->map(function (RatingRecognition $row) {
            $row->items = $this->getByCategory($row->type);
            return $row;
        });
    }

    public function getByCategory($type)
    {
        return RatingRecognition::query()->orderBy("sort", "asc")
        ->where("type", $type)
        ->orderBy("sort", "asc")
        ->get()->map(function ($row) {
            $row->name = $row->name;
            $row->content = $row->content;
            $row->image = previewFile($row->image);
            return $row;
        });
    }
}
