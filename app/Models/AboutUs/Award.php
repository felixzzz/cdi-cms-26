<?php

namespace App\Models\AboutUs;

use App\Traits\HasDatatable;
use App\Traits\HasLocalizedAttributes;
use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    use HasUlid, HasDatatable, HasLocalizedAttributes;

    protected $table = 'awards';

    protected $guarded = [];

    protected $localizedAttributes = ['name', 'content', 'awarder'];
}
