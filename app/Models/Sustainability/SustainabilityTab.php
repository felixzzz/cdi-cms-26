<?php

namespace App\Models\Sustainability;

use App\Traits\HasUlid;
use App\Traits\HasSortable;
use App\Traits\HasDatatable;
use App\Traits\HasLocalizedAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SustainabilityTab extends Model
{
    use HasUlid, HasLocalizedAttributes, HasDatatable, HasSortable;

    protected $table = 'sustainability_tabs';

    protected $guarded = [];

    protected $localizedAttributes = [
        'title'
    ];

    const SORTABLE_GROUP = 'category';

    public function contents(): HasMany
    {
        return $this->hasMany(SustainabilityTabItem::class, 'sustainability_tab_id', 'id')
        ->orderBy("sort", "asc");
    }
}
