<?php

namespace App\Repositories\Article;

use App\Models\Article\ArticleCategory;
use Illuminate\Support\Facades\App;

class ArticleCategoryRepository
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
        return ArticleCategory::query()
        ->where(function ($q) use ($search) {
            $q->where("name_en", "LIKE", "%$search%");
            $q->orWhere("name_id", "LIKE", "%$search%");
        })
        ->datatable($perPage, "created_at");
    }

    public function list($sort = "name_en")
    {
        return ArticleCategory::query()
        ->orderBy($sort, "asc")->get()->map(function ($row) {
            $row->name = $row->name;
            return $row;
        });
    }
}
