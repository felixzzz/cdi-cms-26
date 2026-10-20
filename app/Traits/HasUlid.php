<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUlid
{
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->ulid)) {
                $model->ulid = strtolower((string) Str::ulid());
            }
        });
    }

    public function scopeFindByUlid($query, $ulid, $isAbort = false)
    {
        if ($isAbort) {
            return $query->whereUlid($ulid)->firstOrFail();
        } else {
            return $query->whereUlid($ulid)->first();
        }
    }

}
