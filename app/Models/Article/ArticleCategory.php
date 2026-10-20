<?php

namespace App\Models\Article;

use App\Traits\HasDatatable;
use App\Traits\HasLocalizedAttributes;
use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Model;

class ArticleCategory extends Model
{
    use HasUlid, HasLocalizedAttributes, HasDatatable;

    protected $table = 'article_categories';

    protected $guarded = [];

    protected $localizedAttributes = ['name'];
}
