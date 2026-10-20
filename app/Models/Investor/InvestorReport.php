<?php

namespace App\Models\Investor;

use App\Enums\InvestorReportType;
use App\Traits\HasDatatable;
use App\Traits\HasLocalizedAttributes;
use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Model;

class InvestorReport extends Model
{
    use HasUlid, HasLocalizedAttributes, HasDatatable;

    protected $table = 'investor_reports';

    protected $guarded = [];

    protected $localizedAttributes = ['name', 'file'];

    /**
    * Get the attributes that should be cast.
    *
    * @return array<string, string>
    */
    protected function casts(): array
    {
        return [
            'type' => InvestorReportType::class,
            'file' => 'array',
            'file_en' => 'array',
            'file_id' => 'array'
        ];
    }
}
