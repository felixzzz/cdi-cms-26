<?php

namespace App\Models\AboutUs;

use App\Traits\HasDatatable;
use App\Traits\HasLocalizedAttributes;
use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    use HasUlid, HasDatatable, HasLocalizedAttributes;

    protected $table = 'milestones';

    protected $guarded = [];

    protected $localizedAttributes = ['content'];
}
