<?php

namespace App\Models\Data;

use App\Enums\TeamType;
use App\Traits\HasDatatable;
use App\Traits\HasLocalizedAttributes;
use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasUlid, HasDatatable, HasLocalizedAttributes;

    protected $table = 'teams';

    protected $guarded = [];

    protected $localizedAttributes = ['description'];

    /**
    * Get the attributes that should be cast.
    *
    * @return array<string, string>
    */
    protected function casts(): array
    {
        return [
            'type' => TeamType::class,
            'cv_file' => 'array',
            'resume_file' => 'array',
        ];
    }
}
