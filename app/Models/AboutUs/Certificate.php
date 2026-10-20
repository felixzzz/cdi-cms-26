<?php

namespace App\Models\AboutUs;

use App\Traits\HasUlid;
use App\Traits\HasDatatable;
use Illuminate\Support\Facades\App;
use App\Traits\HasLocalizedAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Certificate extends Model
{
    use HasUlid, HasDatatable, HasLocalizedAttributes;

    protected $table = 'certificates';

    protected $guarded = [];

    protected $localizedAttributes = ['name', 'content', 'awarder'];
    protected $appends = ['short_content'];


    /**
    * Get the attributes that should be cast.
    *
    * @return array<string, string>
    */
    protected function casts(): array
    {
        return [
            'files' => 'array'
        ];
    }

    public function category(): HasOne
    {
        return $this->hasOne(CertificateCategory::class, 'id', 'certificate_category_id');
    }

    protected function shortContent(): Attribute
    {
        return Attribute::make(
            get: function () {
                return html_entity_decode(strip_tags($this->content));
            }

        );
    }
}
