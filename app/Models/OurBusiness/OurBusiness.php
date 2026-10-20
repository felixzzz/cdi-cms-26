<?php

namespace App\Models\OurBusiness;

use App\Traits\HasDatatable;
use App\Traits\HasLocalizedAttributes;
use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OurBusiness extends Model
{
    use HasUlid, HasLocalizedAttributes, HasDatatable;

    protected $table = 'our_businesses';

    protected $guarded = [];

    protected $localizedAttributes = [
        'title', 'description',
        'banner_title', 'banner_description',
        'overview_title', 'overview_description',
        'heading_tab_title', 'link_title',
        'json_ld'
    ];

    public function tabs(): HasMany
    {
        return $this->hasMany(OurBusinessTab::class, 'our_business_id', 'id')
        ->orderBy("sort", "asc");
    }
}
