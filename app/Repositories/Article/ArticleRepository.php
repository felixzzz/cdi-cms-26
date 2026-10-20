<?php

namespace App\Repositories\Article;

use App\Enums\ArticleCategory;
use App\Helpers\Helper;
use App\Models\Article\Article;
use App\Models\Article\ArticleCategory as ArticleArticleCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ArticleRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
    }

    public function newsDatatable($perPage = 10)
    {
        $search = request('search');

        return Article::query()
        ->join('article_categories', 'article_categories.id', 'articles.article_category_id')
        ->where(function ($q) use ($search) {
            $q->where('articles.title_en', 'LIKE', "%$search%");
            $q->orWhere('articles.title_id', 'LIKE', "%$search%");
            $q->orWhere('article_categories.name_en', 'LIKE', "%$search%");
        })
        ->where('articles.category', ArticleCategory::News)
        ->select([
            'articles.*',
            'article_categories.name_en as category_name',
        ])
        ->datatable($perPage, 'articles.created_at');
    }

    public function blogDatatable($perPage = 10)
    {
        $search = request('search');

        return Article::query()
        ->where(function ($q) use ($search) {
            $q->where('articles.title_en', 'LIKE', "%$search%");
            $q->orWhere('articles.title_id', 'LIKE', "%$search%");
        })
        ->where('articles.category', ArticleCategory::Blog)
        ->select([
            'articles.*',
        ])
        ->datatable($perPage, 'articles.created_at');
    }

    public function findDetail($ulid, $category)
    {
        return Article::query()
        ->where('ulid', $ulid)
        ->where('category', $category)
        ->firstOrFail();
    }

    public function latestArticle($categoryId = null, $type = 'news', $limit = 8)
    {
        if ($categoryId == 'all') {
            $categoryId = null;
        }

        $locale = App::getLocale();

        return Article::query()
        ->with([
            'articleCategory',
        ])
        ->where('articles.status', 1)
        ->where('articles.category', $type)
        ->when($categoryId, fn ($q) => $q->whereRelation('articleCategory', fn ($r) => $r->where('ulid', $categoryId)))
        ->orderBy('datetime', 'desc')
        ->limit($limit)
        ->get()->map(function ($row) use ($type, $locale) {
            $row->category_name = $row->articleCategory?->name;
            $row->title = $row->title;
            $row->short_content = $row->short_content;
            $row->image = previewFile($row->thumbnail);
            $row->date = Carbon::parse($row->datetime)->translatedFormat('d-m-Y');
            $row->slug_en = $row->getOriginal('slug') ?: $row->slug;
            if ($locale === 'id') {
                $row->slug = $row->slug_id ?: $row->slug;
                $row->meta_tag = $row->meta_tag_id ?: $row->meta_tag;
            }
            $row->thumbnail_alt = $row->thumbnail_alt;
            $row->thumbnail_caption = $row->thumbnail_caption;

            $row->route = route('media.detail', ['type' => $type, 'id' => $row->slug]);

            return $row;
        });
    }

    public function findBySlug($slug, $type = null)
    {
        $data = Article::query()
        ->with(['articleCategory'])
        ->where(function ($q) use ($slug) {
            $q->where('slug', $slug)
              ->orWhere('slug_id', $slug);
        })
        ->where('status', 1)
        ->when($type, fn ($q) => $q->where('category', $type))
        ->first();

        if ($data) {
            $data->category_name = $data->articleCategory?->name;
            $data->title = $data->title;
            $data->content = $data->content;
            $data->short_content = $data->short_content;
            $data->date = Carbon::parse($data->datetime)->translatedFormat('d-m-Y');
            $data->image = previewFile($data->thumbnail);
            $data->slug_en = $data->getOriginal('slug') ?: $data->slug;
            $locale = App::getLocale();
            if ($locale === 'id') {
                $data->slug = $data->slug_id ?: $data->slug;
                $data->meta_tag = $data->meta_tag_id ?: $data->meta_tag;
            }
            $data->thumbnail_alt = $data->thumbnail_alt;
            $data->thumbnail_caption = $data->thumbnail_caption;
        }

        return $data;
    }

    public function relates($ulid)
    {
        $locale = App::getLocale();

        return Article::query()
        ->with([
            'articleCategory',
        ])
        ->where('articles.status', 1)
        ->where('ulid', '!=', $ulid)
        ->orderBy('datetime', 'desc')
        ->limit(3)
        ->get()->map(function ($row) use ($locale) {
            $row->category_name = $row->articleCategory?->name;
            $row->title = $row->title;
            $row->image = previewFile($row->thumbnail);
            $row->date = Carbon::parse($row->datetime)->translatedFormat('d-m-Y');
            $row->slug_en = $row->getOriginal('slug') ?: $row->slug;
            if ($locale === 'id') {
                $row->slug = $row->slug_id ?: $row->slug;
                $row->meta_tag = $row->meta_tag_id ?: $row->meta_tag;
            }
            $row->thumbnail_alt = $row->thumbnail_alt;
            $row->thumbnail_caption = $row->thumbnail_caption;

            return $row;
        });
    }

    public function latestMedia()
    {
        $locale = App::currentLocale();
        $news = $this->latestArticle(null, 'news', 1);
        $blog = $this->latestArticle(null, 'blog', 1);

        $data = [];

        if (count($news) > 0) {
            $data[] = (object) [
                'title' => $locale == 'en' ? 'Latest <span class="text-blue-lighter">News</span>' : '<span class="text-blue-lighter">Berita</span> Terbaru',
                'data' => $news[0],
            ];
        }

        if (count($blog) > 0) {
            $data[] = (object) [
                'title' => $locale == 'en' ? 'Latest <span class="text-blue-lighter">Blog</span>' : '<span class="text-blue-lighter">Blog</span> Terbaru',
                'data' => $blog[0],
            ];
        }

        return $data;
    }

    public function findPaginated(Request $request, $type)
    {
        $maxLimit = 15;
        $limit = $request->get('limit', $maxLimit);
        $categoryId = $request->category_id;
        if ($categoryId == 'null' || $categoryId == 'all') {
            $categoryId = '';
        }
        $locale = App::getLocale();

        $data = Article::query()
            ->with([
                'articleCategory',
            ])
            ->where('category', $type)
            ->when($categoryId, fn ($q) => $q->whereRelation('articleCategory', fn ($r) => $r->where('ulid', $categoryId)))
            ->where('status', 1)
            ->orderBy('datetime', 'desc')
            ->orderBy('id', 'desc')
            ->paginate($limit);

        return [
            'links' => Helper::makePagination($data),
            'meta' => Helper::metaPagination($data),
            'items' => collect($data->items())
                ->reverse()
                ->take($maxLimit)
                ->reverse()
                ->map(function ($row) use ($locale) {
                    $row->category_name = $row->articleCategory?->name;
                    $row->title = $row->title;
                    $row->image = previewFile($row->thumbnail);
                    $row->date = Carbon::parse($row->datetime)->translatedFormat('d-m-Y');
                    $row->slug_en = $row->getOriginal('slug') ?: $row->slug;
                    if ($locale === 'id') {
                        $row->slug = $row->slug_id ?: $row->slug;
                        $row->meta_tag = $row->meta_tag_id ?: $row->meta_tag;
                    }
                    $row->thumbnail_alt = $row->thumbnail_alt;
                    $row->thumbnail_caption = $row->thumbnail_caption;

                    return $row;
                })->values(),
        ];
    }

    public function findPaginatedSustainability(Request $request)
    {
        $categories = ArticleArticleCategory::where('is_sustainability', 1)->pluck('id')->toArray();
        $maxLimit = 15;
        $limit = $request->get('limit', $maxLimit);
        $categoryId = $request->category_id;
        if ($categoryId == 'null' || $categoryId == 'all') {
            $categoryId = '';
        }
        $locale = App::getLocale();

        $data = Article::query()
            ->with([
                'articleCategory',
            ])
            ->where('category', 'news')
            ->whereIn('articles.article_category_id', $categories)
            ->when($categoryId, fn ($q) => $q->whereRelation('articleCategory', fn ($r) => $r->where('ulid', $categoryId)))
            ->where('status', 1)
            ->orderBy('datetime', 'desc')
            ->orderBy('id', 'desc')
            ->paginate($limit);

        return [
            'links' => Helper::makePagination($data),
            'meta' => Helper::metaPagination($data),
            'items' => collect($data->items())
                ->reverse()
                ->take($maxLimit)
                ->reverse()
                ->map(function ($row) use ($locale) {
                    $row->category_name = $row->articleCategory?->name;
                    $row->title = $row->title;
                    $row->image = previewFile($row->thumbnail);
                    $row->date = Carbon::parse($row->datetime)->translatedFormat('d-m-Y');
                    $row->slug_en = $row->getOriginal('slug') ?: $row->slug;

                    if ($locale === 'id') {
                        $row->slug = $row->slug_id ?: $row->slug;
                        $row->meta_tag = $row->meta_tag_id ?: $row->meta_tag;
                    }
                    $row->thumbnail_alt = $row->thumbnail_alt;
                    $row->thumbnail_caption = $row->thumbnail_caption;

                    return $row;
                })->values(),
        ];
    }

    public function latestSustainability()
    {
        $locale = App::currentLocale();
        $news = $this->findLatestSustainability();

        $data = [];

        if (count($news) > 0) {
            $data[] = (object) [
                'title' => $locale == 'en' ? 'Sustainability <span class="text-blue-lighter">In Action</span>' : 'Keberlanjutan <span class="text-blue-lighter">Dalam Aksi</span>',
                'data' => $news[0],
            ];
        }

        return $data;
    }

    public function findLatestSustainability()
    {
        $categories = ArticleArticleCategory::where('is_sustainability', 1)->pluck('id')->toArray();
        $locale = App::getLocale();

        return Article::query()
        ->with([
            'articleCategory',
        ])
        ->where('articles.status', 1)
        ->where('articles.category', 'news')
        ->whereIn('articles.article_category_id', $categories)
        ->orderBy('datetime', 'desc')
        ->limit(1)
        ->get()->map(function ($row) use ($locale) {
            $row->category_name = $row->articleCategory?->name;
            $row->title = $row->title;
            $row->short_content = $row->short_content;
            $row->image = previewFile($row->thumbnail);
            $row->date = Carbon::parse($row->datetime)->translatedFormat('d-m-Y');
            $row->slug_en = $row->getOriginal('slug') ?: $row->slug;
            if ($locale === 'id') {
                $row->slug = $row->slug_id ?: $row->slug;
                $row->meta_tag = $row->meta_tag_id ?: $row->meta_tag;
            }

            $row->route = route('media.detail', ['type' => 'news', 'id' => $row->slug]);

            return $row;
        });
    }
}
