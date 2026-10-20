<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    /**
     * Boot the trait for the model.
     */
    public static function bootHasSlug()
    {
        static::creating(function ($model) {
            $model->generateSlug();
        });

        static::updating(function ($model) {
            if ($model->isDirty($model->getSlugSourceField())) {
                $model->generateSlug();
            }
        });
    }

    /**
     * Generate a unique slug for the model.
     */
    protected function generateSlug()
    {
        $baseSlug = Str::slug($this->{$this->getSlugSourceField()});
        $slug = $baseSlug;
        $counter = 1;

        // Query untuk mencari slug yang sama
        $query = static::where('slug', $slug);

        // Tambahkan kondisi berdasarkan grouping field jika ada
        foreach ($this->getSlugGroupFields() as $field) {
            if (!empty($this->{$field})) {
                $query->where($field, $this->{$field});
            }
        }

        while ($query->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
            $query = static::where('slug', $slug);

            foreach ($this->getSlugGroupFields() as $field) {
                if (!empty($this->{$field})) {
                    $query->where($field, $this->{$field});
                }
            }
        }

        $this->slug = $slug;
    }

    /**
     * Field yang digunakan untuk slug (default: 'title')
     */
    protected function getSlugSourceField(): string
    {
        return property_exists($this, 'slugSourceField') ? $this->slugSourceField : 'title';
    }

    /**
     * Field yang digunakan untuk grouping slug (default: kosong)
     */
    protected function getSlugGroupFields(): array
    {
        return property_exists($this, 'slugGroupFields') ? $this->slugGroupFields : [];
    }
}
