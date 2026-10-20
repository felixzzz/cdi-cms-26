<?php

namespace App\Actions\PageManagement;

use App\Enums\PreferenceKey;
use App\Enums\PreferenceType;
use App\Helpers\Helper;
use App\Helpers\Optimize;
use App\Helpers\StorageFile;
use Illuminate\Http\Request;
use App\Models\Utility\Preference;

class PageManagementAction
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function store(Request $request, $keys = [], $path = 'page-management')
    {
        foreach ($keys as $key) {
            $requestFile = $request->file("{$key}_file");
            $file = $requestFile && $requestFile->isValid()
            ? StorageFile::upload($request->file("{$key}_file"), $path)
            : null;

            $type = constant(PreferenceKey::class . "::$key")?->type();

            $data = [
                'type' => $type,
                'title_en' => $request->input("{$key}_title_en"),
                'title_id' => $request->input("{$key}_title_id"),
                'content_en' => $request->input("{$key}_content_en"),
                'content_id' => $request->input("{$key}_content_id"),
                'file' => $file
            ];

            if ($type === PreferenceType::Table) {
                $headersJson = $request->input("{$key}_headers");
                $rowsJson = $request->input("{$key}_rows");

                // Decode JSON ke array
                $headers = json_decode($headersJson, true);
                $rows = json_decode($rowsJson, true);

                $tableData = [
                    'headers' => $headers,
                    'tableData' => $rows
                ];

                $data['content_table'] = $tableData;

                if ($request->input("delete_table_{$key}") == 'yes') {
                    $data['content_table'] = [];
                }
            }

            $data = array_filter($data, function ($value, $key) {
                return $key === 'content_table'
                    || $key === 'content_en'
                    || $key === 'content_id'
                    || $key === 'title_en'
                    || $key === 'title_id'
                    || filled($value);
            }, ARRAY_FILTER_USE_BOTH);

            Preference::updateOrCreate(['key' => $key], $data);

            $cacheKeyEn = Helper::getPreferenceCacheKey($keys, 'en');
            Optimize::delete($cacheKeyEn);

            $cacheKeyId = Helper::getPreferenceCacheKey($keys, 'id');
            Optimize::delete($cacheKeyId);
        }

    }
}
