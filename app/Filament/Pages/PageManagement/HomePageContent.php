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

class HomePageContent extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $navigationGroup = 'Page Management';

    protected static ?string $navigationLabel = 'Home Page Content';

    protected static ?string $title = 'Home Page Components';

    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.page-management.home-page-content';

    public ?array $data = [];

    public function mount(): void
    {
        $keys = PreferenceKey::getAllHomeKey();
        $this->form->fill(PreferencePageService::loadKeys($keys));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // 1. Hero Video Banner & Tagline (Component 1)
                Forms\Components\Section::make('Component 1: Hero Video Banner & Welcome Tagline')
                    ->description('Renders at the very top of the homepage. Includes background video/poster media, animated tagline, and headline.')
                    ->icon('heroicon-o-video-camera')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Fieldset::make('Welcome Tagline')
                            ->schema([
                                Forms\Components\TextInput::make('home_banner_tagline_title_en')
                                    ->label('Tagline (🇬🇧 English)')
                                    ->required(),
                                Forms\Components\TextInput::make('home_banner_tagline_title_id')
                                    ->label('Tagline (🇮🇩 Bahasa Indonesia)')
                                    ->required(),
                            ])
                            ->columns(2),

                        Forms\Components\Fieldset::make('Main Headline & Description')
                            ->schema([
                                Forms\Components\TextInput::make('home_banner_title_en')
                                    ->label('Headline (🇬🇧 English)')
                                    ->required(),
                                Forms\Components\TextInput::make('home_banner_title_id')
                                    ->label('Headline (🇮🇩 Bahasa Indonesia)')
                                    ->required(),
                                Forms\Components\RichEditor::make('home_banner_content_en')
                                    ->label('Sub-headline / Paragraph (🇬🇧 English)'),
                                Forms\Components\RichEditor::make('home_banner_content_id')
                                    ->label('Sub-headline / Paragraph (🇮🇩 Bahasa Indonesia)'),
                            ])
                            ->columns(2),

                        PreferencePageService::makeFilePreviewField('home_banner', 'Currently Active Hero Media'),
                        Forms\Components\FileUpload::make('home_banner_file')
                            ->label('Replace Hero Video / Poster Media')
                            ->maxSize(25600)
                            ->directory('page-contents')
                            ->helperText('Upload MP4/WebM video or high-res image')
                            ->columnSpanFull(),
                    ]),

                // 2. About CDI Section (Component 2)
                Forms\Components\Section::make('Component 2: About CDI Section')
                    ->description('Renders immediately below the hero banner. Displays the corporate vision, narrative body, and background photo.')
                    ->icon('heroicon-o-building-office')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('home_about_section_title_en')
                            ->label('Section Title (🇬🇧 English)')
                            ->required(),
                        Forms\Components\TextInput::make('home_about_section_title_id')
                            ->label('Section Title (🇮🇩 Bahasa Indonesia)')
                            ->required(),
                        Forms\Components\RichEditor::make('home_about_section_content_en')
                            ->label('Narrative Body (🇬🇧 English)')
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('home_about_section_content_id')
                            ->label('Narrative Body (🇮🇩 Bahasa Indonesia)')
                            ->columnSpanFull(),
                        PreferencePageService::makeFilePreviewField('home_about_section', 'Currently Active About Background Image'),
                        Forms\Components\FileUpload::make('home_about_section_file')
                            ->label('Replace Background Section Image')
                            ->image()
                            ->directory('page-contents')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                // 3. Infrastructure Solutions (Component 3)
                Forms\Components\Section::make('Component 3: Infrastructure Solutions (4 Business Pillars)')
                    ->description('Renders the four interactive industrial pillars: Energy, Water, Ports & Storage, and Logistics.')
                    ->icon('heroicon-o-bolt')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('home_infrastructure_title_title_en')
                            ->label('Section Main Heading (🇬🇧 English)')
                            ->required(),
                        Forms\Components\TextInput::make('home_infrastructure_title_title_id')
                            ->label('Section Main Heading (🇮🇩 Bahasa Indonesia)')
                            ->required(),

                        Forms\Components\Tabs::make('Infrastructure Pillar Cards')
                            ->tabs([
                                Forms\Components\Tabs\Tab::make('Energy')
                                    ->schema([
                                        Forms\Components\TextInput::make('home_infrastructure_energy_title_en')->label('Title (EN)'),
                                        Forms\Components\TextInput::make('home_infrastructure_energy_title_id')->label('Title (ID)'),
                                        Forms\Components\RichEditor::make('home_infrastructure_energy_content_en')->label('Blurb (EN)'),
                                        Forms\Components\RichEditor::make('home_infrastructure_energy_content_id')->label('Blurb (ID)'),
                                        Forms\Components\FileUpload::make('home_infrastructure_energy_file')->label('Card Image')->image()->directory('page-management/home')->columnSpanFull(),
                                    ])
                                    ->columns(2),

                                Forms\Components\Tabs\Tab::make('Water')
                                    ->schema([
                                        Forms\Components\TextInput::make('home_infrastructure_water_title_en')->label('Title (EN)'),
                                        Forms\Components\TextInput::make('home_infrastructure_water_title_id')->label('Title (ID)'),
                                        Forms\Components\RichEditor::make('home_infrastructure_water_content_en')->label('Blurb (EN)'),
                                        Forms\Components\RichEditor::make('home_infrastructure_water_content_id')->label('Blurb (ID)'),
                                        Forms\Components\FileUpload::make('home_infrastructure_water_file')->label('Card Image')->image()->directory('page-management/home')->columnSpanFull(),
                                    ])
                                    ->columns(2),

                                Forms\Components\Tabs\Tab::make('Ports & Storage')
                                    ->schema([
                                        Forms\Components\TextInput::make('home_infrastructure_port_storage_title_en')->label('Title (EN)'),
                                        Forms\Components\TextInput::make('home_infrastructure_port_storage_title_id')->label('Title (ID)'),
                                        Forms\Components\RichEditor::make('home_infrastructure_port_storage_content_en')->label('Blurb (EN)'),
                                        Forms\Components\RichEditor::make('home_infrastructure_port_storage_content_id')->label('Blurb (ID)'),
                                        Forms\Components\FileUpload::make('home_infrastructure_port_storage_file')->label('Card Image')->image()->directory('page-management/home')->columnSpanFull(),
                                    ])
                                    ->columns(2),

                                Forms\Components\Tabs\Tab::make('Logistics')
                                    ->schema([
                                        Forms\Components\TextInput::make('home_infrastructure_logistic_title_en')->label('Title (EN)'),
                                        Forms\Components\TextInput::make('home_infrastructure_logistic_title_id')->label('Title (ID)'),
                                        Forms\Components\RichEditor::make('home_infrastructure_logistic_content_en')->label('Blurb (EN)'),
                                        Forms\Components\RichEditor::make('home_infrastructure_logistic_content_id')->label('Blurb (ID)'),
                                        Forms\Components\FileUpload::make('home_infrastructure_logistic_file')->label('Card Image')->image()->directory('page-management/home')->columnSpanFull(),
                                    ])
                                    ->columns(2),
                            ])
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                // 4. Discover CDI Cards (Component 4)
                Forms\Components\Section::make('Component 4: Discover CDI Cards')
                    ->description('Renders the four discovery feature cards: Sustainability, Our Business, Investor Relations, and Career opportunities.')
                    ->icon('heroicon-o-sparkles')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('home_discover_title_title_en')
                            ->label('Section Main Heading (🇬🇧 English)')
                            ->required(),
                        Forms\Components\TextInput::make('home_discover_title_title_id')
                            ->label('Section Main Heading (🇮🇩 Bahasa Indonesia)')
                            ->required(),

                        Forms\Components\Tabs::make('Discover Feature Cards')
                            ->tabs([
                                Forms\Components\Tabs\Tab::make('Sustainability')
                                    ->schema([
                                        Forms\Components\TextInput::make('home_discover_sustainability_title_en')->label('Title (EN)'),
                                        Forms\Components\TextInput::make('home_discover_sustainability_title_id')->label('Title (ID)'),
                                        Forms\Components\RichEditor::make('home_discover_sustainability_content_en')->label('Blurb (EN)'),
                                        Forms\Components\RichEditor::make('home_discover_sustainability_content_id')->label('Blurb (ID)'),
                                        Forms\Components\FileUpload::make('home_discover_sustainability_file')->label('Card Image')->image()->directory('page-management/home')->columnSpanFull(),
                                    ])
                                    ->columns(2),

                                Forms\Components\Tabs\Tab::make('Our Business')
                                    ->schema([
                                        Forms\Components\TextInput::make('home_discover_our_business_title_en')->label('Title (EN)'),
                                        Forms\Components\TextInput::make('home_discover_our_business_title_id')->label('Title (ID)'),
                                        Forms\Components\RichEditor::make('home_discover_our_business_content_en')->label('Blurb (EN)'),
                                        Forms\Components\RichEditor::make('home_discover_our_business_content_id')->label('Blurb (ID)'),
                                        Forms\Components\FileUpload::make('home_discover_our_business_file')->label('Card Image')->image()->directory('page-management/home')->columnSpanFull(),
                                    ])
                                    ->columns(2),

                                Forms\Components\Tabs\Tab::make('Investor')
                                    ->schema([
                                        Forms\Components\TextInput::make('home_discover_investor_title_en')->label('Title (EN)'),
                                        Forms\Components\TextInput::make('home_discover_investor_title_id')->label('Title (ID)'),
                                        Forms\Components\RichEditor::make('home_discover_investor_content_en')->label('Blurb (EN)'),
                                        Forms\Components\RichEditor::make('home_discover_investor_content_id')->label('Blurb (ID)'),
                                        Forms\Components\FileUpload::make('home_discover_investor_file')->label('Card Image')->image()->directory('page-management/home')->columnSpanFull(),
                                    ])
                                    ->columns(2),

                                Forms\Components\Tabs\Tab::make('Career')
                                    ->schema([
                                        Forms\Components\TextInput::make('home_discover_career_title_en')->label('Title (EN)'),
                                        Forms\Components\TextInput::make('home_discover_career_title_id')->label('Title (ID)'),
                                        Forms\Components\RichEditor::make('home_discover_career_content_en')->label('Blurb (EN)'),
                                        Forms\Components\RichEditor::make('home_discover_career_content_id')->label('Blurb (ID)'),
                                        Forms\Components\FileUpload::make('home_discover_career_file')->label('Card Image')->image()->directory('page-management/home')->columnSpanFull(),
                                    ])
                                    ->columns(2),
                            ])
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                // 5. Journey & Metrics (Component 5)
                Forms\Components\Section::make('Component 5: Journey & Impact Metrics')
                    ->description('Renders the corporate milestones narrative and the 3 live metric counter stats (e.g. 15+ Years, Projects, etc.).')
                    ->icon('heroicon-o-chart-bar')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Fieldset::make('Journey Header & Narrative')
                            ->schema([
                                Forms\Components\TextInput::make('home_journey_tagline_title_en')->label('Eyebrow (EN)')->required(),
                                Forms\Components\TextInput::make('home_journey_tagline_title_id')->label('Eyebrow (ID)')->required(),
                                Forms\Components\TextInput::make('home_journey_content_title_en')->label('Main Title (EN)')->required(),
                                Forms\Components\TextInput::make('home_journey_content_title_id')->label('Main Title (ID)')->required(),
                                Forms\Components\RichEditor::make('home_journey_content_content_en')->label('Journey Narrative (EN)'),
                                Forms\Components\RichEditor::make('home_journey_content_content_id')->label('Journey Narrative (ID)'),
                                Forms\Components\FileUpload::make('home_journey_content_file')->label('Background Image')->image()->directory('page-management/home')->columnSpanFull(),
                            ])
                            ->columns(2),

                        Forms\Components\Fieldset::make('Impact Metrics / Counters')
                            ->schema([
                                Forms\Components\TextInput::make('home_journey_info_1_title_en')->label('Metric 1 Number (EN)')->placeholder('e.g. 15+'),
                                Forms\Components\TextInput::make('home_journey_info_1_title_id')->label('Metric 1 Number (ID)'),
                                Forms\Components\Textarea::make('home_journey_info_1_content_en')->label('Metric 1 Label (EN)')->rows(2),
                                Forms\Components\Textarea::make('home_journey_info_1_content_id')->label('Metric 1 Label (ID)')->rows(2),

                                Forms\Components\TextInput::make('home_journey_info_2_title_en')->label('Metric 2 Number (EN)')->placeholder('e.g. 4'),
                                Forms\Components\TextInput::make('home_journey_info_2_title_id')->label('Metric 2 Number (ID)'),
                                Forms\Components\Textarea::make('home_journey_info_2_content_en')->label('Metric 2 Label (EN)')->rows(2),
                                Forms\Components\Textarea::make('home_journey_info_2_content_id')->label('Metric 2 Label (ID)')->rows(2),

                                Forms\Components\TextInput::make('home_journey_info_3_title_en')->label('Metric 3 Number (EN)')->placeholder('e.g. 100%'),
                                Forms\Components\TextInput::make('home_journey_info_3_title_id')->label('Metric 3 Number (ID)'),
                                Forms\Components\Textarea::make('home_journey_info_3_content_en')->label('Metric 3 Label (EN)')->rows(2),
                                Forms\Components\Textarea::make('home_journey_info_3_content_id')->label('Metric 3 Label (ID)')->rows(2),
                            ])
                            ->columns(4),
                    ]),

                // 6. Dynamic Feed Sections Reference (Components 6, 7 & 8)
                Forms\Components\Section::make('Components 6–8: Dynamic Content Feeds')
                    ->description('These sections pull directly from your database resources. Click below to manage their items:')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Forms\Components\Placeholder::make('feed_links')
                            ->label('')
                            ->content(new \Illuminate\Support\HtmlString('
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 py-2">
                                    <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 flex flex-col justify-between">
                                        <div>
                                            <h4 class="font-bold text-sm text-gray-900 dark:text-gray-100 flex items-center gap-1.5">
                                                📊 Component 6: Financial Reports Feed
                                            </h4>
                                            <p class="text-xs text-gray-500 mt-1">Displays latest financial and annual investor reports on homepage.</p>
                                        </div>
                                        <a href="/admin/investor/investor-reports" class="mt-4 inline-flex items-center text-xs font-semibold text-primary-600 hover:text-primary-500">
                                            Manage Investor Reports &rarr;
                                        </a>
                                    </div>

                                    <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 flex flex-col justify-between">
                                        <div>
                                            <h4 class="font-bold text-sm text-gray-900 dark:text-gray-100 flex items-center gap-1.5">
                                                📰 Component 7: News & Insights Feed
                                            </h4>
                                            <p class="text-xs text-gray-500 mt-1">Displays the latest articles, blog posts, and press releases.</p>
                                        </div>
                                        <a href="/admin/article/articles" class="mt-4 inline-flex items-center text-xs font-semibold text-primary-600 hover:text-primary-500">
                                            Manage Articles & News &rarr;
                                        </a>
                                    </div>

                                    <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 flex flex-col justify-between">
                                        <div>
                                            <h4 class="font-bold text-sm text-gray-900 dark:text-gray-100 flex items-center gap-1.5">
                                                🔗 Component 8: Partner & Quick Links
                                            </h4>
                                            <p class="text-xs text-gray-500 mt-1">Displays quick navigation and subsidiary link cards at the bottom.</p>
                                        </div>
                                        <a href="/admin/utility/quick-links" class="mt-4 inline-flex items-center text-xs font-semibold text-primary-600 hover:text-primary-500">
                                            Manage Quick Links &rarr;
                                        </a>
                                    </div>
                                </div>
                            ')),
                    ]),

                // 7. Schema Structured Data (Component 9)
                Forms\Components\Section::make('Component 9: Search Engine Schema (JSON-LD)')
                    ->description('JSON-LD structured data for Google Search and SEO richness.')
                    ->icon('heroicon-o-code-bracket')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Forms\Components\Textarea::make('json_ld_homepage_content_en')
                            ->label('Homepage JSON-LD Schema Markup')
                            ->rows(8)
                            ->helperText('Valid JSON-LD schema snippet for homepage SEO indexation.')
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('view_live')
                ->label('View Live Homepage')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->color('gray')
                ->url(env('FRONTEND_URL', 'http://localhost:3000') . '/en')
                ->openUrlInNewTab(),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save All Components & Revalidate')
                ->submit('save')
                ->color('primary')
                ->icon('heroicon-o-check'),
        ];
    }

    public function save(): void
    {
        $keys = PreferenceKey::getAllHomeKey();
        $state = $this->form->getState();

        PreferencePageService::saveKeys($state, $keys, 'page-contents');

        Notification::make()
            ->title('Home Page Content Updated')
            ->body('All homepage component sections updated successfully. Frontend cache has been purged.')
            ->success()
            ->send();
    }
}
