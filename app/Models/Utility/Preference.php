<?php

namespace App\Models\Utility;

use App\Enums\PreferenceKey;
use App\Enums\PreferenceType;
use App\Traits\HasLocalizedAttributes;
use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Preference extends Model
{
    use HasUlid, HasLocalizedAttributes;

    protected $table = 'preferences';

    protected $guarded = [];

    protected $localizedAttributes = ['title', 'content'];

    /**
    * Get the attributes that should be cast.
    *
    * @return array<string, string>
    */
    protected function casts(): array
    {
        return [
            'type' => PreferenceType::class,
            'key' => PreferenceKey::class,
            'content_table' => 'array'
        ];
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['content_table_trans'];

    /**
     * Get the translated content_table based on the current app language.
     *
     * @return array|null
     */
    public function getContentTableTransAttribute()
    {
        if (!$this->content_table) {
            return null;
        }

        $locale = App::getLocale();
        $isIndonesian = $locale === 'id';

        $headers = @$this->content_table['headers'] ?? [];
        $tableData = @$this->content_table['tableData'] ?? [];

        // Translasi header sesuai bahasa saat ini
        $translatedHeaders = array_map(function ($header) use ($isIndonesian) {
            return [
                'text' => $isIndonesian
                        ? (!empty($header['lang_id']) ? $header['lang_id'] : $header['lang_en'])
                        : (!empty($header['lang_en']) ? $header['lang_en'] : $header['lang_id'])
            ];
        }, $headers);

        // Translasi tableData sesuai bahasa saat ini
        $translatedTableData = array_map(function ($row) use ($isIndonesian) {
            return array_map(function ($column) use ($isIndonesian) {
                $isGroup = @$column['is_group'] || false;
                return [
                    'text' => $isIndonesian
                                ? (!empty($column['lang_id']) ? @$column['lang_id'] : @$column['lang_en'])
                                : (!empty($column['lang_en']) ? @$column['lang_en'] : @$column['lang_id']),
                    'sub_text' => $isIndonesian
                                ? (!empty($column['sub_lang_id']) ? @$column['sub_lang_id'] : @$column['sub_lang_en'])
                                : (!empty($column['sub_lang_en']) ? @$column['sub_lang_en'] : @$column['sub_lang_id']),
                    'is_group' => $isGroup,
                    'label' => [
                        'text' => $isGroup
                                ? ($isIndonesian
                                    ? (!empty($column['label']['lang_id']) ? @$column['label']['lang_id'] : @$column['label']['lang_en'])
                                    : (!empty($column['label']['lang_en']) ? @$column['label']['lang_en'] : @$column['label']['lang_id'])
                                )
                                : '',
                    ]
                ];
            }, $row);
        }, $tableData);

        return [
            'headers' => $translatedHeaders,
            'tableData' => $translatedTableData
        ];
    }

}
