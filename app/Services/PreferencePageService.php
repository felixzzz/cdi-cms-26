<?php

namespace App\Services;

use App\Enums\PreferenceKey;
use App\Enums\PreferenceType;
use App\Helpers\Helper;
use App\Helpers\Optimize;
use App\Helpers\StorageFile;
use App\Models\Utility\Preference;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class PreferencePageService
{
    /**
     * Load state array for the given preference keys.
     */
    public static function loadKeys(array $keys): array
    {
        // Query preferences by key (converting enum instances to string values)
        $rawKeys = array_map(fn ($k) => $k instanceof PreferenceKey ? $k->value : (string) $k, $keys);
        $preferences = Preference::whereIn('key', $rawKeys)->get()->keyBy(fn ($item) => $item->key instanceof PreferenceKey ? $item->key->value : $item->key);

        $state = [];

        foreach ($rawKeys as $key) {
            $pref = $preferences->get($key);

            $state["{$key}_title_en"] = $pref?->title_en ?? '';
            $state["{$key}_title_id"] = $pref?->title_id ?? '';
            $state["{$key}_content_en"] = $pref?->content_en ?? '';
            $state["{$key}_content_id"] = $pref?->content_id ?? '';
            $state["{$key}_current_file"] = $pref?->file ? previewFile($pref->file) : null;
            $state["{$key}_file"] = null;

            if ($pref && $pref->type === PreferenceType::Table) {
                $state["{$key}_content_table"] = $pref->content_table ?? [];
                $state["{$key}_table_json"] = $pref->content_table ? json_encode($pref->content_table, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '';
            } else {
                $state["{$key}_table_json"] = $pref?->content_table ? json_encode($pref->content_table, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) : '';
            }
        }

        return $state;
    }

    /**
     * Save state array for the given preference keys.
     */
    public static function saveKeys(array $state, array $keys, string $location = 'page-contents'): void
    {
        $rawKeys = array_map(fn ($k) => $k instanceof PreferenceKey ? $k->value : (string) $k, $keys);

        foreach ($rawKeys as $key) {
            $data = [
                'title_en' => $state["{$key}_title_en"] ?? null,
                'title_id' => $state["{$key}_title_id"] ?? null,
                'content_en' => $state["{$key}_content_en"] ?? null,
                'content_id' => $state["{$key}_content_id"] ?? null,
            ];

            // Handle file upload if provided
            if (isset($state["{$key}_file"]) && $state["{$key}_file"]) {
                $file = $state["{$key}_file"];

                if ($file instanceof TemporaryUploadedFile || $file instanceof \Illuminate\Http\UploadedFile) {
                    $encryptedFile = StorageFile::upload($file, $location);
                    if ($encryptedFile) {
                        $data['file'] = $encryptedFile;
                    }
                } elseif (is_string($file) && !empty($file)) {
                    // Stored relative path
                    $data['file'] = Helper::shortEncrypt($file);
                }
            }

            if (isset($state["{$key}_content_table"])) {
                $data['content_table'] = $state["{$key}_content_table"];
            }

            if (!empty($state["{$key}_table_json"])) {
                $decoded = json_decode($state["{$key}_table_json"], true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $data['content_table'] = $decoded;
                }
            }

            // Clean nulls but keep empty strings for titles/contents if user cleared them
            $data = array_filter($data, fn ($val, $k) => !is_null($val) || in_array($k, ['title_en', 'title_id', 'content_en', 'content_id']), ARRAY_FILTER_USE_BOTH);

            Preference::updateOrCreate(['key' => $key], $data);

            // Invalidate Optimize caches
            $cacheKeyEn = Helper::getPreferenceCacheKey($rawKeys, 'en');
            Optimize::delete($cacheKeyEn);
            $cacheKeyId = Helper::getPreferenceCacheKey($rawKeys, 'id');
            Optimize::delete($cacheKeyId);
        }

        // Trigger frontend ISR revalidation
        RevalidationService::revalidateAll();
    }

    /**
     * Create a reactive preview field for currently active assets in the database.
     */
    public static function makeFilePreviewField(string $key, string $label = 'Current Live Asset'): \Filament\Forms\Components\Placeholder
    {
        return \Filament\Forms\Components\Placeholder::make("{$key}_preview")
            ->label($label)
            ->content(function ($get) use ($key) {
                $file = $get("{$key}_current_file");
                if (!$file) {
                    return new \Illuminate\Support\HtmlString('<span class="text-xs text-gray-400 italic">No asset currently set in database</span>');
                }
                $isImage = preg_match('/\.(webp|png|jpg|jpeg|svg|gif)$/i', (string) $file);
                if ($isImage) {
                    return new \Illuminate\Support\HtmlString('
                        <div class="flex items-center gap-3 p-2 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700">
                            <img src="' . e($file) . '" alt="Preview" class="h-12 w-20 object-cover rounded border border-gray-300 dark:border-gray-600 shadow-sm" onerror="this.style.display=\'none\'">
                            <div class="text-xs">
                                <span class="font-medium text-gray-700 dark:text-gray-300">Live active asset</span><br>
                                <a href="' . e($file) . '" target="_blank" class="text-primary-600 hover:underline inline-flex items-center gap-1 font-semibold">Open full size &rarr;</a>
                            </div>
                        </div>
                    ');
                }
                return new \Illuminate\Support\HtmlString('
                    <div class="flex items-center gap-2 p-2 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 text-xs">
                        <span class="text-primary-600 font-semibold">📄 Active media file</span>
                        <a href="' . e($file) . '" target="_blank" class="text-primary-600 hover:underline">Download/View &rarr;</a>
                    </div>
                ');
            });
    }
}
