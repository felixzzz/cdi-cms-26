<?php

namespace Tests\Feature;

use App\Filament\Pages\PageManagement\AboutUsPageContent;
use App\Filament\Pages\PageManagement\GlobalSettingsPage;
use App\Filament\Pages\PageManagement\GovernancePageContent;
use App\Filament\Pages\PageManagement\HomePageContent;
use App\Filament\Pages\PageManagement\InvestorPageContent;
use App\Filament\Pages\PageManagement\OurBusinessPageContent;
use App\Filament\Pages\PageManagement\SeoMetadataPage;
use App\Filament\Pages\PageManagement\SustainabilityPageContent;
use App\Filament\Resources\Utility\QuickLinkResource\Pages\ListQuickLinks;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class PageManagementTest extends TestCase
{
    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::where('email', 'management@chandradaya-investasi.com')->firstOrFail();
    }

    public function test_home_page_content_mounts_and_saves(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(HomePageContent::class)
            ->assertSuccessful()
            ->call('save')
            ->assertHasNoErrors()
            ->assertNotified('Home Page Content Updated');
    }

    public function test_about_us_page_content_mounts_and_saves(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(AboutUsPageContent::class)
            ->assertSuccessful()
            ->call('save')
            ->assertHasNoErrors()
            ->assertNotified('About Us Content Updated');
    }

    public function test_our_business_page_content_mounts_and_saves(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(OurBusinessPageContent::class)
            ->assertSuccessful()
            ->call('save')
            ->assertHasNoErrors()
            ->assertNotified('Our Business Content Updated');
    }

    public function test_sustainability_page_content_mounts_and_saves(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(SustainabilityPageContent::class)
            ->assertSuccessful()
            ->call('save')
            ->assertHasNoErrors()
            ->assertNotified('Sustainability Content Updated');
    }

    public function test_investor_page_content_mounts_and_saves(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(InvestorPageContent::class)
            ->assertSuccessful()
            ->call('save')
            ->assertHasNoErrors()
            ->assertNotified('Investor Relations Content Updated');
    }

    public function test_governance_page_content_mounts_and_saves(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(GovernancePageContent::class)
            ->assertSuccessful()
            ->call('save')
            ->assertHasNoErrors()
            ->assertNotified('Governance Content Updated');
    }

    public function test_global_settings_page_mounts_and_saves(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(GlobalSettingsPage::class)
            ->assertSuccessful()
            ->call('save')
            ->assertHasNoErrors()
            ->assertNotified('Global & Legal Settings Updated');
    }

    public function test_seo_metadata_page_mounts_and_saves(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(SeoMetadataPage::class)
            ->assertSuccessful()
            ->call('save')
            ->assertHasNoErrors()
            ->assertNotified('SEO Metadata Updated');
    }

    public function test_quick_links_resource_renders_without_error(): void
    {
        $this->actingAs($this->admin);

        Livewire::test(ListQuickLinks::class)
            ->assertSuccessful()
            ->assertCanSeeTableRecords(\App\Models\Utility\QuickLink::orderBy('sort', 'asc')->limit(3)->get());
    }
}
