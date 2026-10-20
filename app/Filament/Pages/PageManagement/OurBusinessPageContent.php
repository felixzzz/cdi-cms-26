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

class OurBusinessPageContent extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'Page Management';

    protected static ?string $navigationLabel = 'Our Business Content';

    protected static ?string $title = 'Our Business Page Components';

    protected static ?int $navigationSort = 3;

    protected static string $view = 'filament.pages.page-management.our-business-page-content';

    public ?array $data = [];

    public function mount(): void
    {
        $keys = PreferenceKey::getAllOurBusinessKey();
        $this->form->fill(PreferencePageService::loadKeys($keys));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // 1. Hero Banner (Component 1)
                Forms\Components\Section::make('Component 1: Hero Banner')
                    ->description('Renders at the top of the /our-business page.')
                    ->icon('heroicon-o-photo')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('our_business_banner_title_en')
                            ->label('Hero Title (🇬🇧 English)'),
                        Forms\Components\TextInput::make('our_business_banner_title_id')
                            ->label('Hero Title (🇮🇩 Bahasa Indonesia)'),
                        Forms\Components\Textarea::make('our_business_banner_content_en')
                            ->label('Hero Subtitle / Description (🇬🇧 English)')
                            ->rows(3),
                        Forms\Components\Textarea::make('our_business_banner_content_id')
                            ->label('Hero Subtitle / Description (🇮🇩 Bahasa Indonesia)')
                            ->rows(3),
                        Forms\Components\FileUpload::make('our_business_banner_file')
                            ->label('Hero Background Image')
                            ->image()
                            ->directory('page-management/our-business')
                            ->helperText('Recommended size: 1920 x 800 px')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                // 2. Business Overview (Component 2)
                Forms\Components\Section::make('Component 2: Business Overview')
                    ->description('Renders below the hero banner. Outlines CDI industrial capabilities.')
                    ->icon('heroicon-o-document-text')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('our_business_overview_title_en')
                            ->label('Section Title (🇬🇧 English)'),
                        Forms\Components\TextInput::make('our_business_overview_title_id')
                            ->label('Section Title (🇮🇩 Bahasa Indonesia)'),
                        Forms\Components\RichEditor::make('our_business_overview_content_en')
                            ->label('Overview Body (🇬🇧 English)')
                            ->columnSpanFull(),
                        Forms\Components\RichEditor::make('our_business_overview_content_id')
                            ->label('Overview Body (🇮🇩 Bahasa Indonesia)')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                // 3. Four Business Pillars Feed Reference (Component 3)
                Forms\Components\Section::make('Component 3: Business Pillars Feed')
                    ->description('The 4 core pillars (Energy, Water, Ports & Storage, Logistics) with detailed subsidiary data are managed in Corporate & Business > Business Pillars.')
                    ->icon('heroicon-o-cube')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Placeholder::make('pillars_info')
                            ->label('')
                            ->content(new \Illuminate\Support\HtmlString('
                                <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 flex flex-col sm:flex-row items-center justify-between gap-4">
                                    <div>
                                        <h4 class="font-bold text-sm text-gray-900 dark:text-gray-100 flex items-center gap-1.5">
                                            🏢 4 Dedicated Business Pillars
                                        </h4>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Manage subsidiaries, capacity stats, client portfolios, and photo galleries for each sector.
                                        </p>
                                    </div>
                                    <a href="/admin/our-business/our-businesses" class="shrink-0 px-4 py-2 bg-primary-600 hover:bg-primary-500 text-white text-xs font-semibold rounded-lg shadow-sm">
                                        Manage Business Pillars &rarr;
                                    </a>
                                </div>
                            ')),
                    ]),

                // 4. Schema Markup (Component 4)
                Forms\Components\Section::make('Component 4: Structured Data (JSON-LD)')
                    ->description('SEO Schema markup for the Business Overview page.')
                    ->icon('heroicon-o-code-bracket')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Forms\Components\Textarea::make('json_ld_our_business_content_en')
                            ->label('JSON-LD Schema Markup')
                            ->rows(8)
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('view_live')
                ->label('View Live Our Business')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->color('gray')
                ->url(env('FRONTEND_URL', 'http://localhost:3000') . '/en/our-business')
                ->openUrlInNewTab(),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Our Business Content')
                ->submit('save')
                ->color('primary')
                ->icon('heroicon-o-check'),
        ];
    }

    public function save(): void
    {
        $keys = PreferenceKey::getAllOurBusinessKey();
        $state = $this->form->getState();

        PreferencePageService::saveKeys($state, $keys, 'page-contents');

        Notification::make()
            ->title('Our Business Content Updated')
            ->body('Our Business page sections have been saved and frontend cache has been purged.')
            ->success()
            ->send();
    }
}
