<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasSortable
{
    /**
     * Boot the trait.
     */
    public static function bootHasSortable()
    {
        static::creating(function (Model $model) {
            $groupColumn = static::getSortableGroupColumn();
            $query = static::query();

            if ($groupColumn && $model->{$groupColumn}) {
                $query->where($groupColumn, $model->{$groupColumn});
            }

            // Jika sort tidak diisi, set sort ke urutan terakhir dalam grup + 1
            if (!$model->sort) {
                $model->sort = $query->max('sort') + 1;
            }
        });

        static::updating(function (Model $model) {
            if ($model->isDirty('sort')) {
                static::reorderSort($model);
            }
        });

        static::deleting(function (Model $model) {
            $groupColumn = static::getSortableGroupColumn();
            $query = static::where('sort', '>', $model->sort);

            if ($groupColumn && $model->{$groupColumn}) {
                $query->where($groupColumn, $model->{$groupColumn});
            }

            $query->decrement('sort');
        });
    }

    /**
     * Reorder sorting when updating sort field.
     *
     * @param Model $model
     * @return void
     */
    protected static function reorderSort(Model $model)
    {
        $oldSort = $model->getOriginal('sort');
        $newSort = $model->sort;
        $groupColumn = static::getSortableGroupColumn();

        $query = static::query();
        if ($groupColumn && $model->{$groupColumn}) {
            $query->where($groupColumn, $model->{$groupColumn});
        }

        if ($newSort > $oldSort) {
            $query->whereBetween('sort', [$oldSort + 1, $newSort])
                ->decrement('sort');
        } else {
            $query->whereBetween('sort', [$newSort, $oldSort - 1])
                ->increment('sort');
        }
    }

    /**
     * Get sortable group column if defined.
     *
     * @return string|null
     */
    protected static function getSortableGroupColumn()
    {
        return defined(static::class . '::SORTABLE_GROUP') ? static::SORTABLE_GROUP : null;
    }
}
