<?php

namespace App\Filament\Widgets;

use App\Services\RevalidationService;
use Filament\Notifications\Notification;
use Filament\Widgets\Widget;

class QuickActionsWidget extends Widget
{
    protected static ?int $sort = 2;

    protected static string $view = 'filament.widgets.quick-actions-widget';

    protected int | string | array $columnSpan = 'full';

    public function purgeCache(): void
    {
        $success = RevalidationService::revalidateAll();

        if ($success) {
            Notification::make()
                ->title('Next.js ISR Cache Purged')
                ->body('All static pages on the frontend were refreshed successfully.')
                ->success()
                ->send();
        } else {
            Notification::make()
                ->title('Cache Purged Locally')
                ->body('Backend cache flushed. Next.js revalidation endpoint not reachable or skipped.')
                ->info()
                ->send();
        }
    }
}
