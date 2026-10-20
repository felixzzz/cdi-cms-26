<?php

namespace App\Actions\Article;

use App\Http\Requests\Article\ArticleCategoryRequest;
use App\Models\Article\ArticleCategory;

class ArticleCategoryAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store(ArticleCategoryRequest $request){
        $data = [
            ...$request->only(['name_en', 'name_id', 'is_sustainability'])
        ];
        return ArticleCategory::create($data);
    }

    public function update(ArticleCategoryRequest $request, $ulid){
        $data = [
            ...$request->only(['name_en', 'name_id', 'is_sustainability'])
        ];
        return ArticleCategory::whereUlid($ulid)->update($data);
    }

    public function delete($ulid){
        return ArticleCategory::where('ulid', $ulid)->delete();
    }
}
