<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;

class Optimize
{
    public static function cache($key, $callback, $ttl = 300) // ttl in second
    {
        return Cache::remember($key, $ttl, $callback);
    }

    public static function cacheForever($key, $callback): mixed
    {
        return Cache::rememberForever($key, $callback);
    }


    public static function delete($key)
    {
        return Cache::forget($key);
    }

    public static function uniqueCacheKey($name, $value, $ttl = 300)
    {
        $optimizeKey = Cache::get($name) ?: [];
        $optimizeKey[] = $value;
        return Cache::put($name, array_unique($optimizeKey));
    }

    public static function deleteUniqueKeyCache($name, $slug)
    {
        foreach (Cache::get($name) ?: [] as $value) {
            Cache::forget($slug . $value);
        }
    }
}
