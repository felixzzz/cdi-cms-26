<?php

namespace App\Filament\Pages\PageManagement;

use App\Enums\PreferenceKey;
use App\Services\PreferencePageService;
use Filament\Actions\Action;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class SeoMetadataPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass';

    protected static ?string $navigationGroup = 'Page Management';

    protected static ?string $navigationLabel = 'SEO & Meta Tags';

    protected static ?string $title = 'SEO & Meta Tags Manager';

    protected static ?int $navigationSort = 9;

    protected static string $view = 'filament.pages.page-management.seo-metadata-page';

    public ?array $data = [];

    public function mount(): void
    {
        $keys = PreferenceKey::getSeoMetaKeys();
        $this->form->fill(PreferencePageService::loadKeys($keys));
    }

    protected function buildMetaSection(string $key, string $label): Forms\Components\Section
    {
        return Forms\Components\Section::make($label)
            ->collapsible()
            ->compact()
            ->schema([
                Forms\Components\Tabs::make("{$key}_tabs")
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('🇬🇧 English')
                            ->schema([
                                Forms\Components\TextInput::make("{$key}_title_en")
                                    ->label('Meta Title')
                                    ->maxLength(255)
                                    ->helperText('Recommended: 50–60 characters for search engine previews'),
                                Forms\Components\Textarea::make("{$key}_content_en")
                                    ->label('Meta Description')
                                    ->rows(3)
                                    ->maxLength(500)
                                    ->helperText('Recommended: 120–160 characters snippet'),
                            ]),
                        Forms\Components\Tabs\Tab::make('🇮🇩 Bahasa Indonesia')
                            ->schema([
                                Forms\Components\TextInput::make("{$key}_title_id")
                                    ->label('Meta Title')
                                    ->maxLength(255),
                                Forms\Components\Textarea::make("{$key}_content_id")
                                    ->label('Meta Description')
                                    ->rows(3)
                                    ->maxLength(500),
                            ]),
                    ]),
                Forms\Components\FileUpload::make("{$key}_file")
                    ->label('Social Share (OpenGraph / Twitter) Image')
                    ->image()
                    ->directory('page-management/seo')
                    ->helperText('Recommended size: 1200 x 630 px'),
            ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('SEO Groups')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Main Pages')
                            ->schema([
                                $this->buildMetaSection(PreferenceKey::meta_home->value, 'Homepage (/)'),
                                $this->buildMetaSection(PreferenceKey::meta_contact_us->value, 'Contact Us (/contact-us)'),
                                $this->buildMetaSection(PreferenceKey::meta_media_news->value, 'Media & News (/media/news)'),
                            ]),

                        Forms\Components\Tabs\Tab::make('About Us')
                            ->schema([
                                $this->buildMetaSection(PreferenceKey::meta_about_us->value, 'Who We Are (/about-us)'),
                                $this->buildMetaSection(PreferenceKey::meta_about_us_management->value, 'Board & Management (/about-us/management)'),
                                $this->buildMetaSection(PreferenceKey::meta_about_us_awards->value, 'Awards & Accreditations (/about-us/awards)'),
                            ]),

                        Forms\Components\Tabs\Tab::make('Our Business')
                            ->schema([
                                $this->buildMetaSection(PreferenceKey::meta_our_business->value, 'Business Overview (/our-business)'),
                                $this->buildMetaSection(PreferenceKey::meta_our_business_energy->value, 'Power & Energy (/our-business/power)'),
                                $this->buildMetaSection(PreferenceKey::meta_our_business_water->value, 'Water Infrastructure (/our-business/water)'),
                                $this->buildMetaSection(PreferenceKey::meta_our_business_ports->value, 'Ports & Storage (/our-business/ports-and-storage)'),
                                $this->buildMetaSection(PreferenceKey::meta_our_business_logistics->value, 'Logistics & Fleet (/our-business/logistics)'),
                            ]),

                        Forms\Components\Tabs\Tab::make('Governance')
                            ->schema([
                                $this->buildMetaSection(PreferenceKey::meta_governance->value, 'Governance Overview (/governance)'),
                                $this->buildMetaSection(PreferenceKey::meta_governance_policy->value, 'Corporate Policies (/governance/policy)'),
                                $this->buildMetaSection(PreferenceKey::meta_governance_whistleblowing->value, 'Whistleblowing Portal (/governance/whistleblowing)'),
                            ]),

                        Forms\Components\Tabs\Tab::make('Sustainability')
                            ->schema([
                                $this->buildMetaSection(PreferenceKey::meta_sustainability->value, 'Sustainability Overview (/sustainability)'),
                                $this->buildMetaSection(PreferenceKey::meta_sustainability_environment->value, 'Environment Pillar (/sustainability/environment)'),
                                $this->buildMetaSection(PreferenceKey::meta_sustainability_social->value, 'Social Pillar (/sustainability/social)'),
                                $this->buildMetaSection(PreferenceKey::meta_sustainability_governance->value, 'Governance Pillar (/sustainability/governance)'),
                            ]),

                        Forms\Components\Tabs\Tab::make('Investor Relations')
                            ->schema([
                                $this->buildMetaSection(PreferenceKey::meta_investor_report->value, 'Reports & Publications (/investor/report)'),
                                $this->buildMetaSection(PreferenceKey::meta_investor_financial->value, 'Financial Information (/investor/financial-information)'),
                                $this->buildMetaSection(PreferenceKey::meta_investor_shares->value, 'Shares & Bonds (/investor/shares-information)'),
                                $this->buildMetaSection(PreferenceKey::meta_investor_publications->value, 'Investor Publications (/investor/publications)'),
                            ]),

                        Forms\Components\Tabs\Tab::make('Legal & Policies')
                            ->schema([
                                $this->buildMetaSection(PreferenceKey::meta_privacy->value, 'Privacy Policy (/privacy-policy)'),
                                $this->buildMetaSection(PreferenceKey::meta_terms->value, 'Terms & Conditions (/terms-and-conditions)'),
                                $this->buildMetaSection(PreferenceKey::meta_cookies->value, 'Cookies Consent (/cookies-notice)'),
                                $this->buildMetaSection(PreferenceKey::meta_disclaimer->value, 'Disclaimer (/disclaimer)'),
                            ]),
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save SEO Metadata')
                ->submit('save')
                ->color('primary')
                ->icon('heroicon-o-check'),
        ];
    }

    public function save(): void
    {
        $keys = PreferenceKey::getSeoMetaKeys();
        $state = $this->form->getState();

        PreferencePageService::saveKeys($state, $keys, 'page-management/seo');

        Notification::make()
            ->title('SEO Metadata Updated')
            ->body('All meta tags and search descriptions were saved and Next.js tags revalidated.')
            ->success()
            ->send();
    }
}
