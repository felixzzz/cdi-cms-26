<?php

namespace App\Traits;

use Illuminate\Support\Facades\App;

trait HasLocalizedAttributes
{
    public function __get($key)
    {
        // Cek apakah atribut memiliki format _en atau _id
        if (property_exists($this, 'localizedAttributes') && in_array($key, $this->localizedAttributes)) {
            $locale = App::getLocale(); // Mendapatkan bahasa yang sedang aktif
            $localizedKey = "{$key}_{$locale}"; // Contoh: content_en atau content_id

            if (array_key_exists($localizedKey, $this->attributes)) {
                return $this->attributes[$localizedKey];
            }
        }

        // Jika tidak ada, kembalikan atribut asli
        return parent::__get($key);
    }
}
