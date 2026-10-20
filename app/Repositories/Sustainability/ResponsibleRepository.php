<?php

namespace App\Repositories\Sustainability;

use Illuminate\Support\Facades\App;
use App\Models\Sustainability\Responsible;

class ResponsibleRepository
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
        return Responsible::query()
        ->orderBy("sort", "asc")
        ->get();
    }

    public function list()
    {
        $locale = App::currentLocale();
        return Responsible::query()
        ->orderBy("sort", "asc")
        ->get()->map(function ($row) use ($locale) {
            $row->title = $row->title;
            $row->description = $row->description;
            $row->points = $locale == 'en' ? $row->list_en : $row->list_id;
            return $row;
        });;
    }
}
