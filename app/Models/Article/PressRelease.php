<?php

namespace App\Models\Article;

use App\Traits\HasDatatable;
use App\Traits\HasLocalizedAttributes;
use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Model;

class PressRelease extends Model
{
    use HasUlid, HasLocalizedAttributes, HasDatatable;

    protected $table = 'press_releases';

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
            'file' => 'array',
            'file_en' => 'array',
            'file_id' => 'array'
        ];
    }
}
