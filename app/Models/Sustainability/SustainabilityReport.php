<?php

namespace App\Models\Sustainability;

use App\Enums\SustainabilityReportType;
use App\Traits\HasDatatable;
use App\Traits\HasLocalizedAttributes;
use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Model;

class SustainabilityReport extends Model
{
    use HasUlid, HasLocalizedAttributes, HasDatatable;

    protected $table = 'sustainability_reports';

    protected $guarded = [];

    protected $localizedAttributes = [
        'title',
        'description'
    ];

    /**
    * Get the attributes that should be cast.
    *
    * @return array<string, string>
    */
    protected function casts(): array
    {
        return [
            'type' => SustainabilityReportType::class,
            'file' => 'array'
        ];
    }
}
