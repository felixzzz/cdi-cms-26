<?php

namespace App\Repositories\Utility;

use App\Models\Utility\Topic;
use Illuminate\Support\Facades\App;

class TopicRepository
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
        return Topic::query()
        ->where(function ($q) use ($search) {
            $q->where("name_en", "LIKE", "%$search%");
            $q->orWhere("name_id", "LIKE", "%$search%");
        })
        ->datatable($perPage, "created_at");
    }

    public function list($type)
    {
        $sort = 'name_en';
        $locale = App::currentLocale();
        if ($locale == 'id') $sort = 'name_id';
        return Topic::query()
        ->select('id', "{$sort} as name")
        ->where("type", $type)
        ->orderBy($sort, "asc")->get();
    }
}
