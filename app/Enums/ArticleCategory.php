<?php

namespace App\Enums;

enum ArticleCategory: string
{
    case News = 'news';
    case Blog = 'blog';

    public function word()
    {
        return match ($this->value) {
            'news' => 'News',
            'blog' => 'Blog'
        };
    }
}
