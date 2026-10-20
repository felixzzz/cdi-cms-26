<?php

namespace App\Models\Sustainability;

use App\Enums\RatingRecognitionType;
use App\Traits\HasDatatable;
use App\Traits\HasLocalizedAttributes;
use App\Traits\HasSortable;
use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Model;

class RatingRecognition extends Model
{
    use HasUlid, HasSortable, HasLocalizedAttributes, HasDatatable;

    protected $table = 'rating_recognitions';

    protected $guarded = [];

    protected $localizedAttributes = ['name', 'content'];

    const SORTABLE_GROUP = 'type';

    /**
 * Get the attributes that should be cast.
    *
    * @return array<string, string>
    */
    protected function casts(): array
    {
        return [
            'type' => RatingRecognitionType::class,
        ];
    }
}
