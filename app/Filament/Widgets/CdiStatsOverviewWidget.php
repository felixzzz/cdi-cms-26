<?php

namespace App\Filament\Widgets;

use App\Models\Article\Article;
use App\Models\Article\PressRelease;
use App\Models\Investor\InvestorReport;
use App\Models\Sustainability\SustainabilityReport;
use App\Models\Utility\Inbox;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CdiStatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $articlesCount = Article::count();
        $pressReleasesCount = PressRelease::count();
        $investorReportsCount = InvestorReport::count();
        $sustainabilityCount = SustainabilityReport::count();
        $inboxCount = Inbox::count();

        return [
            Stat::make('Articles & Stories', $articlesCount)
                ->description("{$pressReleasesCount} Press Releases")
                ->descriptionIcon('heroicon-m-newspaper')
                ->color('primary')
                ->url('/admin/article/articles'),

            Stat::make('Investor Reports', $investorReportsCount)
                ->description('Financial & IR Disclosures')
                ->descriptionIcon('heroicon-m-chart-bar-square')
                ->color('success')
                ->url('/admin/investor/investor-reports'),

            Stat::make('Sustainability Reports', $sustainabilityCount)
                ->description('ESG & CSR Documentation')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color('warning')
                ->url('/admin/sustainability/sustainability-reports'),

            Stat::make('Public Inquiries', $inboxCount)
                ->description($inboxCount > 0 ? "{$inboxCount} total received" : 'Zero pending inquiries')
                ->descriptionIcon('heroicon-m-inbox-arrow-down')
                ->color($inboxCount > 0 ? 'danger' : 'gray')
                ->url('/admin/utility/inboxes'),
        ];
    }
}
