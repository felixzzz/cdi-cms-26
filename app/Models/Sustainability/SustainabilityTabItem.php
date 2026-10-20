<?php

namespace App\Models\Sustainability;

use App\Traits\HasDatatable;
use App\Traits\HasLocalizedAttributes;
use App\Traits\HasSortable;
use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Model;

class SustainabilityTabItem extends Model
{
    use HasUlid, HasLocalizedAttributes, HasDatatable, HasSortable;

    protected $table = 'sustainability_tab_items';

    protected $guarded = [];

    protected $localizedAttributes = [
        'title',
        'content',
        'heading',
        'tagline'
    ];

    const SORTABLE_GROUP = 'sustainability_tab_id';
}
