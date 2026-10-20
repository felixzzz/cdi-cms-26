<?php

namespace App\Models\Sustainability;

use App\Traits\HasUlid;
use Illuminate\Support\Str;
use App\Traits\HasDatatable;
use Illuminate\Support\Facades\App;
use App\Traits\HasLocalizedAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Responsible extends Model
{
    use HasUlid, HasLocalizedAttributes, HasDatatable;

    protected $table = 'sustainability_responsibles';

    protected $guarded = [];

    protected $localizedAttributes = [
        'title', 'description',
    ];

    protected $appends = ['list'];

    /**
    * Get the attributes that should be cast.
    *
    * @return array<string, string>
    */
    protected function casts(): array
    {
        return [
            'list_en' => 'array',
            'list_id' => 'array',
        ];
    }

    protected function list(): Attribute
    {
        return Attribute::make(
            get: function () {
                $locale = App::getLocale();
                return $locale === 'id' ? ($this->list_id ?: $this->list_en) : ($this->list_en ?: $this->list_id);
            }
        );
    }
}
