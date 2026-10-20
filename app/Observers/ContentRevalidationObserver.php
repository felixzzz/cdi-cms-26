<?php

namespace App\Observers;

use App\Services\RevalidationService;
use Illuminate\Database\Eloquent\Model;

class ContentRevalidationObserver
{
    /**
     * Handle the Model "saved" event (covers created and updated).
     */
    public function saved(Model $model): void
    {
        $this->handleRevalidation($model);
    }

    /**
     * Handle the Model "deleted" event.
     */
    public function deleted(Model $model): void
    {
        $this->handleRevalidation($model);
    }

    /**
     * Revalidate cache based on the model class.
     */
    protected function handleRevalidation(Model $model): void
    {
        // Global revalidation ensures all Next.js ISR pages and tag caches refresh immediately
        RevalidationService::revalidateAll();
    }
}
