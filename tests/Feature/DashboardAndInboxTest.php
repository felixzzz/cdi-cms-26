<?php

namespace Tests\Feature;

use App\Filament\Resources\Utility\InboxResource\Pages\ListInboxes;
use App\Filament\Widgets\CdiStatsOverviewWidget;
use App\Filament\Widgets\QuickActionsWidget;
use App\Filament\Widgets\RecentSubmissionsWidget;
use App\Models\User;
use App\Models\Utility\Inbox;
use Livewire\Livewire;
use Tests\TestCase;

class DashboardAndInboxTest extends TestCase
{
    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::where('email', 'management@chandradaya-investasi.com')->firstOrFail();
    }

    public function test_cdi_stats_overview_widget_mounts(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(CdiStatsOverviewWidget::class)
            ->assertSuccessful();
    }

    public function test_quick_actions_widget_mounts_and_purges_cache(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(QuickActionsWidget::class)
            ->assertSuccessful()
            ->call('purgeCache')
            ->assertNotified();
    }

    public function test_recent_submissions_widget_mounts(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(RecentSubmissionsWidget::class)
            ->assertSuccessful();
    }

    public function test_inbox_list_mounts_and_exports_csv(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(ListInboxes::class)
            ->assertSuccessful()
            ->callAction('export_csv')
            ->assertFileDownloaded();
    }
}
