<?php

use Carbon\Carbon;
use App\Helpers\Helper;

if (!function_exists('itcan')) {
    function itcan($action)
    {
        $user = auth()->user();
        if ($user->role && $user->role->is_superadmin) {
            return true;
        }

        $permission = $user->role->permissions;
        return in_array($action, $permission);
    }
}


if (!function_exists('previewFile')) {
    function previewFile($prefix)
    {
        if (empty($prefix)) {
            return '';
        }
        if (str_starts_with($prefix, 'http://') || str_starts_with($prefix, 'https://') || str_starts_with($prefix, '/assets/')) {
            return $prefix;
        }
        return route('preview.storage', $prefix);
    }
}

if (!function_exists('decryptBase64')) {
    function decryptBase64($str)
    {
        if (!$str) {
            return null;
        }
        try {
            return base64_decode(urldecode($str));
        } catch (\Exception $e) {
            return null;
        }
    }
}

if (!function_exists('urlFilterColumn')) {
    function urlFilterColumn($key, $value)
    {
        $params = request()->all();
        $mainPath = request()->url();

        if (@$params['filter_column']) {
            unset($params['filter_column']);
        }

        $params['filter_column'][$key] = $value;

        if (isset($params)) {
            return $mainPath . '?' . http_build_query($params);
        } else {
            return $mainPath . '?filter_column[' . $key . ']=' . $value;
        }
    }
}


if (!function_exists('getQueryParam')) {
    function getQueryParam($url)
    {
        $queryString = parse_url($url, PHP_URL_QUERY);
        $queryParams = [];
        parse_str($queryString, $queryParams);
        return $queryParams ? $queryParams : null;
    }
}


if (!function_exists('parseDate')) {
    function parseDate($date)
    {
        return Carbon::parse($date);
    }
}


if (!function_exists('getYears')) {
    function getYears($start = 2000, $end = null)
    {
        $end = $end ?? date('Y'); // Default sampai tahun sekarang
        return range($end, $start);
    }
}

if (!function_exists('getPageManagementVideo')) {
    function getPageManagementVideo($path)
    {
        $decryptedPath = Helper::shortDecrypt($path);

        return $decryptedPath;
    }
}
