<?php

namespace App\Models\Utility;

use App\Enums\TopicType;
use App\Traits\HasDatatable;
use App\Traits\HasLocalizedAttributes;
use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasUlid, HasDatatable, HasLocalizedAttributes;

    protected $table = 'topics';

    protected $guarded = [];

    protected $localizedAttributes = ['name'];

    /**
    * Get the attributes that should be cast.
    *
    * @return array<string, string>
    */
    protected function casts(): array
    {
        return [
            'type' => TopicType::class,
        ];
    }
}
