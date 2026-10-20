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

class SustainabilityPageContent extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationGroup = 'Page Management';

    protected static ?string $navigationLabel = 'Sustainability Content';

    protected static ?string $title = 'Sustainability Page Components';

    protected static ?int $navigationSort = 4;

    public static function canAccess(): bool
    {
        return itcan('page_management');
    }

    protected static string $view = 'filament.pages.page-management.sustainability-page-content';

    public ?array $data = [];

    public function mount(): void
    {
        $keys = PreferenceKey::getAllSustainabilityKey();
        $this->form->fill(PreferencePageService::loadKeys($keys));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // 1. Overview Page (Component 1)
                Forms\Components\Section::make('Component 1: Sustainability Overview (/sustainability)')
                    ->description('Renders on the main Sustainability landing page.')
                    ->icon('heroicon-o-globe-alt')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Fieldset::make('Hero Banner')
                            ->schema([
                                Forms\Components\TextInput::make('sustainability_overview_banner_title_en')->label('Title (EN)'),
                                Forms\Components\TextInput::make('sustainability_overview_banner_title_id')->label('Title (ID)'),
                                Forms\Components\Textarea::make('sustainability_overview_banner_content_en')->label('Subtitle (EN)')->rows(2),
                                Forms\Components\Textarea::make('sustainability_overview_banner_content_id')->label('Subtitle (ID)')->rows(2),
                                Forms\Components\FileUpload::make('sustainability_overview_banner_file')->label('Banner Media')->image()->directory('page-management/sustainability')->columnSpanFull(),
                            ])
                            ->columns(2),

                        Forms\Components\Fieldset::make('Overview Narrative')
                            ->schema([
                                Forms\Components\TextInput::make('sustainability_overview_content_title_en')->label('Headline (EN)'),
                                Forms\Components\TextInput::make('sustainability_overview_content_title_id')->label('Headline (ID)'),
                                Forms\Components\RichEditor::make('sustainability_overview_content_content_en')->label('Content (EN)')->columnSpanFull(),
                                Forms\Components\RichEditor::make('sustainability_overview_content_content_id')->label('Content (ID)')->columnSpanFull(),
                            ])
                            ->columns(2),

                        Forms\Components\Fieldset::make('Policy Framework & Ratings')
                            ->schema([
                                Forms\Components\TextInput::make('sustainability_overview_policy_framework_title_en')->label('Policy Framework Title (EN)'),
                                Forms\Components\TextInput::make('sustainability_overview_policy_framework_title_id')->label('Policy Framework Title (ID)'),
                                Forms\Components\FileUpload::make('sustainability_overview_policy_framework_file')->label('Policy Framework PDF Document')->directory('page-management/sustainability/documents')->columnSpanFull(),
                                Forms\Components\TextInput::make('sustainability_overview_rating_title_en')->label('Rating Framework Title (EN)'),
                                Forms\Components\TextInput::make('sustainability_overview_rating_title_id')->label('Rating Framework Title (ID)'),
                            ])
                            ->columns(2),
                    ]),

                // 2. ESG Pillar Sub-Pages (Components 2, 3 & 4)
                Forms\Components\Section::make('Components 2–4: ESG Pillar Pages (Environment, Social, Governance)')
                    ->description('Renders banners and overviews for the 3 individual ESG sub-pages.')
                    ->icon('heroicon-o-shield-check')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Tabs::make('ESG Sub-Pages')
                            ->tabs([
                                Forms\Components\Tabs\Tab::make('Environment (/sustainability/environment)')
                                    ->schema([
                                        Forms\Components\TextInput::make('sustainability_environment_banner_title_en')->label('Banner Title (EN)'),
                                        Forms\Components\TextInput::make('sustainability_environment_banner_title_id')->label('Banner Title (ID)'),
                                        Forms\Components\FileUpload::make('sustainability_environment_banner_file')->label('Banner Image')->image()->directory('page-management/sustainability')->columnSpanFull(),
                                        Forms\Components\RichEditor::make('sustainability_environment_overview_content_en')->label('Overview Body (EN)')->columnSpanFull(),
                                        Forms\Components\RichEditor::make('sustainability_environment_overview_content_id')->label('Overview Body (ID)')->columnSpanFull(),
                                    ])
                                    ->columns(2),

                                Forms\Components\Tabs\Tab::make('Social (/sustainability/social)')
                                    ->schema([
                                        Forms\Components\TextInput::make('sustainability_social_banner_title_en')->label('Banner Title (EN)'),
                                        Forms\Components\TextInput::make('sustainability_social_banner_title_id')->label('Banner Title (ID)'),
                                        Forms\Components\FileUpload::make('sustainability_social_banner_file')->label('Banner Image')->image()->directory('page-management/sustainability')->columnSpanFull(),
                                        Forms\Components\RichEditor::make('sustainability_social_overview_content_en')->label('Overview Body (EN)')->columnSpanFull(),
                                        Forms\Components\RichEditor::make('sustainability_social_overview_content_id')->label('Overview Body (ID)')->columnSpanFull(),
                                    ])
                                    ->columns(2),

                                Forms\Components\Tabs\Tab::make('Governance (/sustainability/governance)')
                                    ->schema([
                                        Forms\Components\TextInput::make('sustainability_governance_banner_title_en')->label('Banner Title (EN)'),
                                        Forms\Components\TextInput::make('sustainability_governance_banner_title_id')->label('Banner Title (ID)'),
                                        Forms\Components\FileUpload::make('sustainability_governance_banner_file')->label('Banner Image')->image()->directory('page-management/sustainability')->columnSpanFull(),
                                        Forms\Components\RichEditor::make('sustainability_governance_overview_content_en')->label('Overview Body (EN)')->columnSpanFull(),
                                        Forms\Components\RichEditor::make('sustainability_governance_overview_content_id')->label('Overview Body (ID)')->columnSpanFull(),
                                    ])
                                    ->columns(2),
                            ])
                            ->columnSpanFull(),
                    ]),

                // 3. Reports & Action Banners (Components 5 & 6)
                Forms\Components\Section::make('Components 5 & 6: Reports & In Action Banners')
                    ->description('Renders hero banners for /sustainability/report and /sustainability/action.')
                    ->icon('heroicon-o-document-chart-bar')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('sustainability_report_banner_title_en')->label('Reports Banner Title (EN)'),
                        Forms\Components\TextInput::make('sustainability_report_banner_title_id')->label('Reports Banner Title (ID)'),
                        Forms\Components\FileUpload::make('sustainability_report_banner_file')->label('Reports Banner Image')->image()->directory('page-management/sustainability')->columnSpanFull(),

                        Forms\Components\TextInput::make('sustainability_action_banner_title_en')->label('In Action Banner Title (EN)'),
                        Forms\Components\TextInput::make('sustainability_action_banner_title_id')->label('In Action Banner Title (ID)'),
                        Forms\Components\FileUpload::make('sustainability_action_banner_file')->label('In Action Banner Image')->image()->directory('page-management/sustainability')->columnSpanFull(),
                    ])
                    ->columns(2),

                // 4. Feeds Reference
                Forms\Components\Section::make('Dedicated Sustainability Content Resources')
                    ->description('Individual initiative pillars and downloadable sustainability PDF reports are managed in their dedicated resources:')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Forms\Components\Placeholder::make('sustainability_links')
                            ->label('')
                            ->content(new \Illuminate\Support\HtmlString('
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 py-2">
                                    <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 flex flex-col justify-between">
                                        <div>
                                            <h4 class="font-bold text-sm text-gray-900 dark:text-gray-100 flex items-center gap-1.5">
                                                🌱 Sustainability Pillars
                                            </h4>
                                            <p class="text-xs text-gray-500 mt-1">Manage individual ESG initiative cards and programs.</p>
                                        </div>
                                        <a href="/admin/sustainability/sustainability-contents" class="mt-4 inline-flex items-center text-xs font-semibold text-primary-600 hover:text-primary-500">
                                            Manage Sustainability Pillars &rarr;
                                        </a>
                                    </div>

                                    <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 flex flex-col justify-between">
                                        <div>
                                            <h4 class="font-bold text-sm text-gray-900 dark:text-gray-100 flex items-center gap-1.5">
                                                📊 Sustainability PDF Reports
                                            </h4>
                                            <p class="text-xs text-gray-500 mt-1">Upload annual ESG and sustainability compliance reports.</p>
                                        </div>
                                        <a href="/admin/sustainability/sustainability-reports" class="mt-4 inline-flex items-center text-xs font-semibold text-primary-600 hover:text-primary-500">
                                            Manage Sustainability Reports &rarr;
                                        </a>
                                    </div>
                                </div>
                            ')),
                    ]),
            ])
            ->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('view_live')
                ->label('View Live Sustainability')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->color('gray')
                ->url(env('FRONTEND_URL', 'http://localhost:3000') . '/en/sustainability')
                ->openUrlInNewTab(),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Sustainability Content')
                ->submit('save')
                ->color('primary')
                ->icon('heroicon-o-check'),
        ];
    }

    public function save(): void
    {
        $keys = PreferenceKey::getAllSustainabilityKey();
        $state = $this->form->getState();

        PreferencePageService::saveKeys($state, $keys, 'page-contents');

        Notification::make()
            ->title('Sustainability Content Updated')
            ->body('Sustainability page components have been saved and frontend cache has been purged.')
            ->success()
            ->send();
    }
}
