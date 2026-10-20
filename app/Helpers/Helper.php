<?php

namespace App\Helpers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Helper
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function menuAdmin()
    {
        $menuItems = config('menu');

        foreach ($menuItems as $key => $value) {
            $menuItems[$key] = self::menuToObjects($value); // Simpan hasil konversi
        }

        return $menuItems;
    }

    private static function menuToObjects(array $items)
    {
        return array_map(function ($item) {
            // Convert sub items if they exist
            if (isset($item['sub']) && is_array($item['sub'])) {
                $sub = self::menuToObjects($item['sub']);
                $item['sub'] = $sub;
            } else {
                $item['sub'] = [];
            }
            // Convert route name to URL if route is specified
            if (!empty($item['route'])) {
                if (!empty($item['route_params'])) {
                    $item['route'] = route($item['route'], @$item['route_params']);
                } else {
                    $item['route'] = route($item['route']);
                }
            }
            return (object) $item;
        }, $items);
    }

    public static function getTitleTypeGovernance($type)
    {
        switch ($type) {
            case 'policy':
                return "head_title.governance_policy";
                break;
            case 'risk-management':
                return "head_title.governance_risk_management";
                break;
            case 'code-of-conduct':
                return "head_title.governance_code_of_conduct";
                break;
            case 'she-regulation':
                return "head_title.governance_she_regulation";
                break;

            default:
                return '';
                break;
        }
    }

    public static function shortEncrypt($value)
    {
        $key = substr(config('app.key'), 0, 16); // Ambil 16 karakter pertama dari APP_KEY
        $iv = '1234567890123456'; // IV tetap, pastikan 16 karakter
        $encrypted = openssl_encrypt($value, 'AES-128-CBC', $key, 0, $iv);

        return rtrim(strtr(base64_encode($encrypted), '+/', '-_'), '='); // Buat lebih pendek
    }

    public static function shortDecrypt($encryptedValue)
    {
        $key = substr(config('app.key'), 0, 16);
        $iv = '1234567890123456';
        $decoded = base64_decode(strtr($encryptedValue, '-_', '+/'));

        return openssl_decrypt($decoded, 'AES-128-CBC', $key, 0, $iv);
    }

    public static function handleMoveImage($value, $path)
    {
        if (!empty($value)) {

            // Ambil nama file asli
            $originalPath = parse_url($value, PHP_URL_PATH);
            $originalPath = str_replace("cdi-compro/public/", "", $originalPath);
            $filename = pathinfo($originalPath, PATHINFO_BASENAME);

            // Buat nama file baru yang dienkripsi
            $newFilename = Str::random(40) . '.' . pathinfo($filename, PATHINFO_EXTENSION);

            // Copy file ke storage lokal
            $storagePath = "{$path}/{$newFilename}";
            $localPath = public_path($originalPath); // Path asli dari public folder

            \Log::info($value);
            \Log::info($originalPath);
            \Log::info(public_path($originalPath));

            if (file_exists($localPath)) {
                Storage::disk('local')->put($storagePath, file_get_contents($localPath));
                return self::shortEncrypt($storagePath);
            }
        }
    }

    public static function getPreferenceCacheKey($keys = [], $lang = '')
    {
        $hashedKeys = hash('sha256', json_encode($keys));
        if (!$lang) $lang = App::getLocale();
        $cacheKey = "preference-keys-{$hashedKeys}-" . $lang;
        return $cacheKey;
    }

    public static function makePagination($data)
    {
        if(!$data->total()){
            return [];
        }
        $currentPage = intval($data->currentPage());
        $lastPage = intval($data->lastPage());
        $params = request()->query();
        $links = $data->onEachSide(1)
            ->appends($params)
            ->linkCollection()
            ->map(function ($row) {
                $row['params'] = getQueryParam($row['url']);
                return $row;
            });
        return [
            [
                'url' => $currentPage == 1 ? null : request()->url()."?page=1",
                'label' => 'First',
                'active' => false,
                'params' => [
                        ...$params,
                        'page' => '1'
                ]
            ],
            ...$links,
            [
                'url' => $currentPage == $lastPage ? null : request()->url()."?page=$lastPage",
                'label' => 'Last',
                'active' => false,
                'params' => [
                        ...$params,
                        'page' => "$lastPage"
                ]
            ],
        ];
    }

    public static function metaPagination($data)
    {
        if (!$data->total()) {
            return [];
        }

        return [
            'total' => intval($data->total()),
            'per_page' => intval($data->perPage()),
            'current_page' => intval($data->currentPage()),
            'last_page' => intval($data->lastPage()),
            'from' => $data->firstItem() ?? 0,
            'to' => $data->lastItem() ?? 0,
            'range' => ($data->firstItem() && $data->lastItem())
                ? __("from_of_to_items", ["from" => "{$data->firstItem()}-{$data->lastItem()}", "to" => $data->total()])
                : __("from_of_to_items", ["from" => "0", "to" => $data->total()])
        ];
    }

}
