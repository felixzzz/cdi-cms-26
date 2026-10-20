<?php

namespace App\Models\OurBusiness;

use App\Traits\HasDatatable;
use App\Traits\HasLocalizedAttributes;
use App\Traits\HasSortable;
use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Model;

class OurBusinessContent extends Model
{
    use HasUlid, HasLocalizedAttributes, HasDatatable, HasSortable;

    protected $table = 'our_business_contents';

    protected $guarded = [];

    protected $localizedAttributes = [
        'title',
        'description',
        'heading',
        'tagline'
    ];

    const SORTABLE_GROUP = 'our_business_tab_id';
}
