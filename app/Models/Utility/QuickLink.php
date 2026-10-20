<?php

namespace App\Models\Utility;

use App\Enums\QuickLinkCategory;
use App\Traits\HasDatatable;
use App\Traits\HasLocalizedAttributes;
use App\Traits\HasSortable;
use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Model;

class QuickLink extends Model
{
    use HasUlid, HasSortable, HasLocalizedAttributes, HasDatatable;

    protected $table = 'quick_links';

    protected $guarded = [];

    protected $localizedAttributes = ['name'];

    const SORTABLE_GROUP = 'category';

    /**
 * Get the attributes that should be cast.
    *
    * @return array<string, string>
    */
    protected function casts(): array
    {
        return [
            'category' => QuickLinkCategory::class,
        ];
    }
}
