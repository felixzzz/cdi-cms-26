<?php

namespace App\Models\OurBusiness;

use App\Traits\HasUlid;
use App\Traits\HasSortable;
use App\Traits\HasDatatable;
use App\Traits\HasLocalizedAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OurBusinessTab extends Model
{
    use HasUlid, HasLocalizedAttributes, HasDatatable, HasSortable;

    protected $table = 'our_business_tabs';

    protected $guarded = [];

    protected $localizedAttributes = [
        'title', 'description',
        'sub_title'
    ];

    const SORTABLE_GROUP = 'our_business_id';

    public function contents(): HasMany
    {
        return $this->hasMany(OurBusinessContent::class, 'our_business_tab_id', 'id')
        ->orderBy("sort", "asc");
    }
}
