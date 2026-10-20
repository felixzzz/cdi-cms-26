<?php

namespace App\Models\Governance;

use App\Traits\HasDatatable;
use App\Traits\HasLocalizedAttributes;
use App\Traits\HasSortable;
use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Model;

class GovernanceCommitte extends Model
{
    use HasUlid, HasLocalizedAttributes, HasDatatable, HasSortable;

    protected $table = 'governance_committes';

    protected $guarded = [];

    protected $localizedAttributes = [
        'tab_title', 'title', 'content',
    ];

    /**
    * Get the attributes that should be cast.
    *
    * @return array<string, string>
    */
    protected function casts(): array
    {
        return [
            'file' => 'array'
        ];
    }
}
