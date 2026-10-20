<?php

namespace App\Models\Sustainability;

use App\Enums\Sustainability\ContentType;
use App\Enums\Sustainability\GridType;
use App\Traits\HasUlid;
use App\Traits\HasSortable;
use Illuminate\Support\Str;
use App\Traits\HasDatatable;
use Illuminate\Support\Facades\App;
use App\Traits\HasLocalizedAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class SustainabilityContent extends Model
{
    use HasUlid, HasLocalizedAttributes, HasDatatable, HasSortable;

    protected $table = 'sustainability_contents';

    protected $guarded = [];

    protected $localizedAttributes = [
        'title',
        'content',
        'file_information'
    ];

    const SORTABLE_GROUP = 'category';

    /**
    * Get the attributes that should be cast.
    *
    * @return array<string, string>
    */
    protected function casts(): array
    {
        return [
            'type' => ContentType::class,
            'grid_type' => GridType::class,
            'content_json_en' => 'array',
            'content_json_id' => 'array',
            'file_information' => 'array',
            'file_information_en' => 'array',
            'file_information_id' => 'array'
        ];
    }
}
