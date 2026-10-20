<?php

namespace App\Models\Utility;

use App\Traits\HasDatatable;
use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasUlid, HasDatatable;

    protected $table = 'countries';

    protected $guarded = [];
}
