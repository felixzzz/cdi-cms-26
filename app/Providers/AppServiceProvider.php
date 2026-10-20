<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $observedModels = [
            \App\Models\Article\Article::class,
            \App\Models\Investor\InvestorReport::class,
            \App\Models\Article\PressRelease::class,
            \App\Models\OurBusiness\OurBusiness::class,
            \App\Models\Sustainability\SustainabilityReport::class,
            \App\Models\Sustainability\SustainabilityContent::class,
            \App\Models\AboutUs\Award::class,
            \App\Models\AboutUs\Certificate::class,
            \App\Models\Data\Team::class,
            \App\Models\Data\Office::class,
            \App\Models\Utility\Preference::class,
            \App\Models\Utility\QuickLink::class,
        ];

        foreach ($observedModels as $model) {
            if (class_exists($model)) {
                $model::observe(\App\Observers\ContentRevalidationObserver::class);
            }
        }
    }
}
