<?php

namespace App\Models\Data;

use App\Traits\HasDatatable;
use App\Traits\HasLocalizedAttributes;
use App\Traits\HasUlid;
use Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Office extends Model
{
    use HasUlid, HasDatatable, HasLocalizedAttributes;

    protected $table = 'offices';

    protected $guarded = [];

    protected $localizedAttributes = ['sub_title'];

    /**
    * Get the attributes that should be cast.
    *
    * @return array<string, string>
    */
    protected function casts(): array
    {
        return [
            'main' => 'array',
            'branchs' => 'array'
        ];
    }

    /**
     * Get the main office address based on the current locale.
     */
    public function getMainAddressAttribute()
    {
        $locale = App::getLocale();
        return @$this->main['address_'.$locale] ?? null;
    }

    /**
     * Get the main office location based on the current locale.
     */
    public function getMainLocationNameAttribute()
    {
        $locale = App::getLocale();
        return @$this->main['location_name_'.$locale] ?? null;
    }

    /**
     * Get the branch offices with localized address and location.
     */
    public function getLocalizedBranchesAttribute()
    {
        $locale = App::getLocale();
        return array_map(function ($branch) use ($locale) {
            return [
                'phone' => $branch['phone'] ?? null,
                'fax' => $branch['fax'] ?? null,
                'location_name' => @$branch['location_name_'.$locale] ?? null,
                'address' => @$branch['address_'.$locale] ?? null,
            ];
        }, $this->branchs ?? []);
    }

    public function getLocalizedMainAttribute()
    {
        $locale = App::getLocale();
        $main = @$this->main;
        if ($main) {
            $main['location_name'] = @$this->main['location_name_'.$locale] ?? null;
            $main['address'] = @$this->main['address_'.$locale] ?? null;
        }

        return $main;
    }

}
