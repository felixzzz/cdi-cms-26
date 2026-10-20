<?php

namespace App\Models\Utility;

use App\Enums\AdditionalFileType;
use App\Traits\HasDatatable;
use App\Traits\HasLocalizedAttributes;
use App\Traits\HasSortable;
use App\Traits\HasUlid;
use Illuminate\Database\Eloquent\Model;

class AdditionalFile extends Model
{
    use HasUlid, HasLocalizedAttributes, HasDatatable, HasSortable;

    protected $table = 'additional_files';

    protected $guarded = [];

    protected $localizedAttributes = ['name', 'file'];

    const SORTABLE_GROUP = 'type';

    /**
    * Get the attributes that should be cast.
    *
    * @return array<string, string>
    */
    protected function casts(): array
    {
        return [
            'type' => AdditionalFileType::class,
            'file' => 'array',
            'file_en' => 'array',
            'file_id' => 'array'
        ];
    }

    protected static function booted(): void
    {
        static::creating(function ($model) {
            if (empty($model->unique_key)) {
                $model->unique_key = $model->generateUniqueKey($model->type->value);
            }
        });

        static::updating(function ($model) {
            if (empty($model->unique_key)) {
                $model->unique_key = $model->generateUniqueKey($model->type->value);
            }
        });
    }


    private function generateKey(string $type): string
    {
        $formattedType = collect(explode('_', $type))
            ->map(fn($word) => ucfirst($word))
            ->implode('_');

        $randomInt = random_int(1000, 9999);

        return "{$formattedType}_{$randomInt}";
    }

    private function generateUniqueKey(string $type): string
    {
        do {
            $key = $this->generateKey($type);
        } while (
            self::where('unique_key', $key)
                ->where('type', $type)
                ->exists()
        );

        return $key;
    }
}
