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

class AboutUsPageContent extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';

    protected static ?string $navigationGroup = 'Page Management';

    protected static ?string $navigationLabel = 'About Us Content';

    protected static ?string $title = 'About Us Page Components';

    protected static ?int $navigationSort = 2;

    protected static string $view = 'filament.pages.page-management.about-us-page-content';

    public ?array $data = [];

    protected function getCombinedKeys(): array
    {
        return array_merge(
            PreferenceKey::getAllAboutUsKey('who-we-are'),
            PreferenceKey::getAllAboutUsKey('management'),
            PreferenceKey::getAllAboutUsKey('award')
        );
    }

    public function mount(): void
    {
        $keys = $this->getCombinedKeys();
        $this->form->fill(PreferencePageService::loadKeys($keys));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // 1. Hero Banner
                Forms\Components\Section::make('Component 1: Hero Banner')
                    ->description('Renders at the very top of the About Us page (/about-us).')
                    ->icon('heroicon-o-photo')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('about_us_banner_title_en')->label('Title (EN)'),
                        Forms\Components\TextInput::make('about_us_banner_title_id')->label('Title (ID)'),
                        Forms\Components\Textarea::make('about_us_banner_content_en')->label('Subtitle (EN)')->rows(2),
                        Forms\Components\Textarea::make('about_us_banner_content_id')->label('Subtitle (ID)')->rows(2),
                        Forms\Components\FileUpload::make('about_us_banner_file')->label('Banner Image')->image()->directory('page-management/about-us')->columnSpanFull(),
                    ])
                    ->columns(2),

                // 2. Company Overview & Video
                Forms\Components\Section::make('Component 2: Company Overview & Video')
                    ->description('Corporate narrative, brand tagline, showcase image, and profile video.')
                    ->icon('heroicon-o-building-office')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('about_us_company_overview_tagline_title_en')->label('Tagline Eyebrow (EN)')->placeholder('#Your Growth Partner'),
                        Forms\Components\TextInput::make('about_us_company_overview_tagline_title_id')->label('Tagline Eyebrow (ID)')->placeholder('#Mitra Pertumbuhan Anda'),
                        Forms\Components\FileUpload::make('about_us_company_overview_tagline_file')->label('Overview Logo (Optional)')->image()->directory('page-management/about-us'),
                        Forms\Components\FileUpload::make('about_us_company_overview_background_file')->label('Background Pattern (Optional)')->image()->directory('page-management/about-us'),
                        Forms\Components\FileUpload::make('about_us_company_overview_file')->label('Main Showcase Image')->image()->directory('page-management/about-us')->columnSpanFull(),
                        Forms\Components\RichEditor::make('about_us_company_overview_content_en')->label('Narrative Content (EN)')->columnSpanFull(),
                        Forms\Components\RichEditor::make('about_us_company_overview_content_id')->label('Narrative Content (ID)')->columnSpanFull(),
                        Forms\Components\TextInput::make('about_us_youtube_content_en')
                            ->label('YouTube Profile Video URL or Video ID')
                            ->placeholder('https://www.youtube.com/watch?v=... or 6fE_VqEsqDk')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                // 3. Vision & Mission
                Forms\Components\Section::make('Component 3: Vision & Mission')
                    ->description('Core corporate vision, mission statements, and accompanying iconography.')
                    ->icon('heroicon-o-light-bulb')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('about_us_vision_mission_tagline_title_en')->label('Section Title (EN)')->placeholder('Vision & Mission'),
                        Forms\Components\TextInput::make('about_us_vision_mission_tagline_title_id')->label('Section Title (ID)')->placeholder('Visi & Misi'),
                        Forms\Components\Fieldset::make('Vision Statement')
                            ->schema([
                                Forms\Components\TextInput::make('about_us_vision_title_en')->label('Vision Title (EN)'),
                                Forms\Components\TextInput::make('about_us_vision_title_id')->label('Vision Title (ID)'),
                                Forms\Components\FileUpload::make('about_us_vision_file')->label('Vision Icon / Image')->image()->directory('page-management/about-us')->columnSpanFull(),
                                Forms\Components\RichEditor::make('about_us_vision_content_en')->label('Vision Statement (EN)')->columnSpanFull(),
                                Forms\Components\RichEditor::make('about_us_vision_content_id')->label('Vision Statement (ID)')->columnSpanFull(),
                            ])
                            ->columns(2),
                        Forms\Components\Fieldset::make('Mission Statement')
                            ->schema([
                                Forms\Components\TextInput::make('about_us_mission_title_en')->label('Mission Title (EN)'),
                                Forms\Components\TextInput::make('about_us_mission_title_id')->label('Mission Title (ID)'),
                                Forms\Components\FileUpload::make('about_us_mission_file')->label('Mission Icon / Image')->image()->directory('page-management/about-us')->columnSpanFull(),
                                Forms\Components\RichEditor::make('about_us_mission_content_en')->label('Mission Statement (EN)')->columnSpanFull(),
                                Forms\Components\RichEditor::make('about_us_mission_content_id')->label('Mission Statement (ID)')->columnSpanFull(),
                            ])
                            ->columns(2),
                    ])
                    ->columns(2),

                // 4. Milestones & Company Profile Download
                Forms\Components\Section::make('Component 4: Milestones & Company Profile Download')
                    ->description('Introductory banners for the timeline and downloadable corporate profiles.')
                    ->icon('heroicon-o-clock')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Fieldset::make('Milestones Timeline Header')
                            ->schema([
                                Forms\Components\TextInput::make('about_us_milestone_title_en')->label('Milestone Title (EN)')->placeholder('From Then to Now'),
                                Forms\Components\TextInput::make('about_us_milestone_title_id')->label('Milestone Title (ID)')->placeholder('Dari Dulu Hingga Sekarang'),
                                Forms\Components\Textarea::make('about_us_milestone_content_en')->label('Milestone Subtitle (EN)')->rows(2),
                                Forms\Components\Textarea::make('about_us_milestone_content_id')->label('Milestone Subtitle (ID)')->rows(2),
                                Forms\Components\FileUpload::make('about_us_milestone_file')->label('Timeline Background Image')->image()->directory('page-management/about-us')->columnSpanFull(),
                            ])
                            ->columns(2),

                        Forms\Components\Fieldset::make('Company Profile Download Section')
                            ->schema([
                                Forms\Components\TextInput::make('about_us_company_profile_title_en')->label('Headline (EN)'),
                                Forms\Components\TextInput::make('about_us_company_profile_title_id')->label('Headline (ID)'),
                                Forms\Components\Textarea::make('about_us_company_profile_content_en')->label('Subtitle (EN)')->rows(2),
                                Forms\Components\Textarea::make('about_us_company_profile_content_id')->label('Subtitle (ID)')->rows(2),
                            ])
                            ->columns(2),
                    ]),

                // 5. Board & Management Sub-Page
                Forms\Components\Section::make('Component 5: Board & Management Page (/about-us/management)')
                    ->description('Header and structural charts for the Board of Commissioners and Directors.')
                    ->icon('heroicon-o-users')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('about_us_management_banner_title_en')->label('Banner Title (EN)'),
                        Forms\Components\TextInput::make('about_us_management_banner_title_id')->label('Banner Title (ID)'),
                        Forms\Components\FileUpload::make('about_us_management_banner_file')->label('Banner Image')->image()->directory('page-management/about-us')->columnSpanFull(),
                        Forms\Components\RichEditor::make('about_us_management_overview_content_en')->label('Overview Narrative (EN)')->columnSpanFull(),
                        Forms\Components\RichEditor::make('about_us_management_overview_content_id')->label('Overview Narrative (ID)')->columnSpanFull(),
                        Forms\Components\Fieldset::make('Organization & Shareholding Charts')
                            ->schema([
                                Forms\Components\FileUpload::make('about_us_organization_structure_file')->label('Organization Structure Chart (Image/PDF)')->directory('page-management/about-us'),
                                Forms\Components\FileUpload::make('about_us_corporate_structure_file')->label('Corporate Shareholding Structure Chart (Image/PDF)')->directory('page-management/about-us'),
                                Forms\Components\Toggle::make('about_us_corporate_structure_table_show')->label('Display Structure Table')->default(true)->columnSpanFull(),
                            ])
                            ->columns(2),
                    ])
                    ->columns(2),

                // 6. Awards & Recognition Sub-Page
                Forms\Components\Section::make('Component 6: Awards & Recognition Page (/about-us/awards-and-accreditations)')
                    ->description('Banner and overview intro for the Awards & Accreditations page.')
                    ->icon('heroicon-o-trophy')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('about_us_award_banner_title_en')->label('Banner Title (EN)'),
                        Forms\Components\TextInput::make('about_us_award_banner_title_id')->label('Banner Title (ID)'),
                        Forms\Components\FileUpload::make('about_us_award_banner_file')->label('Banner Image')->image()->directory('page-management/about-us')->columnSpanFull(),
                        Forms\Components\RichEditor::make('about_us_award_overview_content_en')->label('Awards Overview (EN)')->columnSpanFull(),
                        Forms\Components\RichEditor::make('about_us_award_overview_content_id')->label('Awards Overview (ID)')->columnSpanFull(),
                    ])
                    ->columns(2),

                // 7. Dedicated Feeds Reference
                Forms\Components\Section::make('Dedicated About Us Data Resources')
                    ->description('Historical timeline items, team members, and award catalogs are managed in their dedicated resources:')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Forms\Components\Placeholder::make('about_links')
                            ->label('')
                            ->content(new \Illuminate\Support\HtmlString('
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 py-2">
                                    <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 flex flex-col justify-between">
                                        <div>
                                            <h4 class="font-bold text-sm text-gray-900 dark:text-gray-100 flex items-center gap-1.5">
                                                👥 Leadership & Teams
                                            </h4>
                                            <p class="text-xs text-gray-500 mt-1">Commissioners, Board of Directors, and committee profiles.</p>
                                        </div>
                                        <a href="/admin/about-us/teams" class="mt-4 inline-flex items-center text-xs font-semibold text-primary-600 hover:text-primary-500">
                                            Manage Leadership &rarr;
                                        </a>
                                    </div>

                                    <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 flex flex-col justify-between">
                                        <div>
                                            <h4 class="font-bold text-sm text-gray-900 dark:text-gray-100 flex items-center gap-1.5">
                                                ⏳ History & Milestones
                                            </h4>
                                            <p class="text-xs text-gray-500 mt-1">Chronological company journey and key milestone points.</p>
                                        </div>
                                        <a href="/admin/about-us/our-histories" class="mt-4 inline-flex items-center text-xs font-semibold text-primary-600 hover:text-primary-500">
                                            Manage History &rarr;
                                        </a>
                                    </div>

                                    <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 flex flex-col justify-between">
                                        <div>
                                            <h4 class="font-bold text-sm text-gray-900 dark:text-gray-100 flex items-center gap-1.5">
                                                🏆 Awards & Certificates
                                            </h4>
                                            <p class="text-xs text-gray-500 mt-1">Industry recognitions, ISO certifications, and credentials.</p>
                                        </div>
                                        <a href="/admin/about-us/awards" class="mt-4 inline-flex items-center text-xs font-semibold text-primary-600 hover:text-primary-500">
                                            Manage Awards &rarr;
                                        </a>
                                    </div>
                                </div>
                            ')),
                    ]),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save About Us Content')
                ->submit('save')
                ->color('primary')
                ->icon('heroicon-o-check'),
        ];
    }

    public function save(): void
    {
        $keys = $this->getCombinedKeys();
        $state = $this->form->getState();

        PreferencePageService::saveKeys($state, $keys, 'page-management/about-us');

        Notification::make()
            ->title('About Us Content Updated')
            ->body('About Us components have been saved successfully.')
            ->success()
            ->send();
    }
}
