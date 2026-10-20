<?php

namespace App\Actions\Article;

use App\Enums\ArticleCategory;
use App\Enums\PreferenceKey;
use App\Helpers\StorageFile;
use App\Http\Requests\Article\BlogRequest;
use App\Models\Article\Article;
use App\Models\Utility\Preference;
use Illuminate\Support\Str;

class BlogAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
    }

    public function store(BlogRequest $request)
    {
        $category = ArticleCategory::Blog;
        
        $slug = $this->generateUniqueSlug(
            // Str::slug($request->slug_en ?: $request->title_en),
            Str::slug($request->slug_en),
            'slug',
            $category
        );

        $slugId = $this->generateUniqueSlug(
            // Str::slug($request->slug_id ?: $request->title_id),
            Str::slug($request->slug_id),
            'slug_id',
            $category
        );

        $data = [
            ...$request->only([
                'datetime',
                'title_en',
                'title_id',
                'article_category_id',
                'content_en',
                'content_id',
                'status',
                'thumbnail_alt_en',
                'thumbnail_alt_id',
                'thumbnail_caption_en',
                'thumbnail_caption_id',
            ]),
            'meta_tag' => [
                'description' => $request->meta_description,
                'keyword' => $request->meta_keyword,
            ],
            'meta_tag_id' => [
                'description' => $request->meta_description_id,
                'keyword' => $request->meta_keyword_id,
            ],
            'json_ld' => $request->json_ld,
            'json_ld_id' => $request->json_ld_id,
            'references' => is_array($request->references) 
                ? array_values(array_filter($request->references, fn($item) => !empty($item['title']) || !empty($item['url'])))
                : (is_string($request->references) ? json_decode($request->references, true) : null),
            'tags' => explode(',', $request->tags),
            'category' => $category,
            'slug' => $slug,
            'slug_id' => $slugId,
        ];

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = StorageFile::upload($request->file('thumbnail'), 'article/blog');
        }

        return Article::create($data);
    }

    public function update(BlogRequest $request, $ulid)
    {
        $article = Article::whereUlid($ulid)->firstOrFail();

        $category = ArticleCategory::Blog;

        $slug = $this->generateUniqueSlug(
            // Str::slug($request->slug_en ?: $request->title_en),
            Str::slug($request->slug),
            'slug',
            $category,
            $article->id
        );

        $slugId = $this->generateUniqueSlug(
            Str::slug($request->slug_id ?: $request->title_id),
            // Str::slug($request->slug_id),
            'slug_id',
            $category,
            $article->id
        );

        $data = [
            ...$request->only(['datetime', 'title_en', 'title_id', 'article_category_id', 'content_en', 'content_id', 'status', 'thumbnail_alt_en', 'thumbnail_alt_id', 'thumbnail_caption_en', 'thumbnail_caption_id']),
            'tags' => explode(',', $request->tags),
            'meta_tag' => [
                'description' => $request->meta_description,
                'keyword' => $request->meta_keyword,
            ],
            'meta_tag_id' => [
                'description' => $request->meta_description_id,
                'keyword' => $request->meta_keyword_id,
            ],
            'json_ld' => $request->json_ld,
            'json_ld_id' => $request->json_ld_id,
            'references' => is_array($request->references) 
                ? array_values(array_filter($request->references, fn($item) => !empty($item['title']) || !empty($item['url'])))
                : (is_string($request->references) ? json_decode($request->references, true) : null),
            'slug' => $slug,
            'slug_id' => $slugId,
        ];

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = StorageFile::upload($request->file('thumbnail'), 'article/blog');
        }

        $article->fill($data);
        $article->save();

        return $article;
    }

    public function delete($ulid)
    {
        return Article::where('ulid', $ulid)->delete();
    }

    public function toggleStatus()
    {
        $currentStatus = request()->input('current_status'); // "show" or "hide"
        $newStatus = $currentStatus === 'show' ? 'hide' : 'show';
        Preference::updateOrCreate(
            ['key' => PreferenceKey::media_blog_status->value], [
                'content_en' => $newStatus,
            ]);
    }

    protected function generateUniqueSlug(string $baseSlug, string $column, $category, $exceptId = null): string
    {
        $slug = $baseSlug;
        $counter = 1;

        while (
            Article::where($column, $slug)
                ->where('category', $category)
                ->when($exceptId, fn ($q) => $q->where('id', '!=', $exceptId))
                ->exists()
        ) {
            $slug = $baseSlug.'-'.$counter;
            ++$counter;
        }

        return $slug;
    }
}
