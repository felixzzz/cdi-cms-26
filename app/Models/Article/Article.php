<?php

namespace App\Models\Article;

use App\Enums\ArticleCategory;
use App\Models\Article\ArticleCategory as ArticleArticleCategory;
use App\Traits\HasDatatable;
use App\Traits\HasLocalizedAttributes;
use App\Traits\HasSlug;
use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasUlid;
    use HasLocalizedAttributes;
    use HasDatatable;
    // use HasSlug;

    protected $table = 'articles';

    protected $guarded = [];

    protected $localizedAttributes = ['title', 'content', 'thumbnail_alt', 'thumbnail_caption'];

    protected $slugSourceField = 'title_en';
    protected $slugGroupFields = ['category'];
    protected $appends = ['short_content_en', 'short_content', 'json_ld', 'thumbnail_alt', 'thumbnail_caption'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'category' => ArticleCategory::class,
            'tags' => 'array',
            'meta_tag' => 'array',
            'meta_tag_id' => 'array',
            'references' => 'array',
            'sources' => 'array',
        ];
    }

    public function getJsonLdAttribute()
    {
        $locale = App::getLocale();
        return $locale === 'id' ? $this->json_ld_id : ($this->attributes['json_ld'] ?? null);
    }

    public function getThumbnailAltAttribute()
    {
        $locale = App::getLocale();
        $alt = $locale === 'id'
            ? ($this->attributes['thumbnail_alt_id'] ?? $this->attributes['thumbnail_alt_en'] ?? null)
            : ($this->attributes['thumbnail_alt_en'] ?? $this->attributes['thumbnail_alt_id'] ?? null);

        if (!empty($alt)) {
            return $alt;
        }

        return $locale === 'id'
            ? ($this->attributes['title_id'] ?? $this->attributes['title_en'] ?? '')
            : ($this->attributes['title_en'] ?? $this->attributes['title_id'] ?? '');
    }

    public function getThumbnailCaptionAttribute()
    {
        $locale = App::getLocale();
        return $locale === 'id'
            ? ($this->attributes['thumbnail_caption_id'] ?? $this->attributes['thumbnail_caption_en'] ?? null)
            : ($this->attributes['thumbnail_caption_en'] ?? $this->attributes['thumbnail_caption_id'] ?? null);
    }

    protected function shortContent(): Attribute
    {
        return Attribute::make(
            get: function () {
                $locale = App::getLocale();
                $content = $locale === 'id' ? ($this->content_id ?: $this->content_en) : ($this->content_en ?: $this->content_id);
                return Str::limit(html_entity_decode(strip_tags((string) $content)), 200);
            }
        );
    }

    protected function shortContentEn(): Attribute
    {
        return Attribute::make(
            get: function () {
                return Str::limit(html_entity_decode(strip_tags((string) $this->content_en)), 200);
            }
        );
    }

    public function articleCategory(): BelongsTo
    {
        return $this->belongsTo(ArticleArticleCategory::class, 'article_category_id', 'id');
    }
}
