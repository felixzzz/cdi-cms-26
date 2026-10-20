<?php

namespace App\Models\AboutUs;

use App\Traits\HasDatatable;
use App\Traits\HasLocalizedAttributes;
use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Model;

class CertificateCategory extends Model
{
    use HasUlid, HasDatatable, HasLocalizedAttributes;

    protected $table = 'certificate_categories';

    protected $guarded = [];

    protected $localizedAttributes = ['name'];
}
