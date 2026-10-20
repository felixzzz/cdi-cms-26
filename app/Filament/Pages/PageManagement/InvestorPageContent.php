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

class InvestorPageContent extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';

    protected static ?string $navigationGroup = 'Page Management';

    protected static ?string $navigationLabel = 'Investor Relations Content';

    protected static ?string $title = 'Investor Relations Page Components';

    protected static ?int $navigationSort = 5;

    public static function canAccess(): bool
    {
        return itcan('page_management');
    }

    protected static string $view = 'filament.pages.page-management.investor-page-content';

    public ?array $data = [];

    public function mount(): void
    {
        $keys = PreferenceKey::getAllInvestorKey();
        $this->form->fill(PreferencePageService::loadKeys($keys));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // 1. Reports & Presentations (/investor/report)
                Forms\Components\Section::make('Component 1: Reports & Presentations (/investor/report)')
                    ->description('Renders hero banner, financial overview, and highlight table for the Investor Reports page.')
                    ->icon('heroicon-o-document-chart-bar')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Fieldset::make('Hero Banner')
                            ->schema([
                                Forms\Components\TextInput::make('investor_report_banner_title_en')->label('Banner Title (EN)'),
                                Forms\Components\TextInput::make('investor_report_banner_title_id')->label('Banner Title (ID)'),
                                Forms\Components\Textarea::make('investor_report_banner_content_en')->label('Banner Subtitle (EN)')->rows(2),
                                Forms\Components\Textarea::make('investor_report_banner_content_id')->label('Banner Subtitle (ID)')->rows(2),
                                Forms\Components\FileUpload::make('investor_report_banner_file')->label('Banner Image')->image()->directory('page-management/investor')->columnSpanFull(),
                            ])
                            ->columns(2),

                        Forms\Components\Fieldset::make('Financial Narrative Overview')
                            ->schema([
                                Forms\Components\TextInput::make('investor_report_overview_title_en')->label('Headline (EN)'),
                                Forms\Components\TextInput::make('investor_report_overview_title_id')->label('Headline (ID)'),
                                Forms\Components\RichEditor::make('investor_report_overview_content_en')->label('Narrative (EN)')->columnSpanFull(),
                                Forms\Components\RichEditor::make('investor_report_overview_content_id')->label('Narrative (ID)')->columnSpanFull(),
                            ])
                            ->columns(2),

                        Forms\Components\Toggle::make('investor_report_table_show')
                            ->label('Show Report Financial Table on Frontend')
                            ->helperText('Enable or disable display of the summary table on /investor/report')
                            ->default(true),
                    ]),

                // 2. Financial Information (/investor/financial-information)
                Forms\Components\Section::make('Component 2: Financial Information (/investor/financial-information)')
                    ->description('Renders banner and calendar section for financial highlights.')
                    ->icon('heroicon-o-banknotes')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Fieldset::make('Hero Banner')
                            ->schema([
                                Forms\Components\TextInput::make('investor_financial_banner_title_en')->label('Banner Title (EN)'),
                                Forms\Components\TextInput::make('investor_financial_banner_title_id')->label('Banner Title (ID)'),
                                Forms\Components\Textarea::make('investor_financial_banner_content_en')->label('Banner Subtitle (EN)')->rows(2),
                                Forms\Components\Textarea::make('investor_financial_banner_content_id')->label('Banner Subtitle (ID)')->rows(2),
                                Forms\Components\FileUpload::make('investor_financial_banner_file')->label('Banner Image')->image()->directory('page-management/investor')->columnSpanFull(),
                            ])
                            ->columns(2),
                    ]),

                // 3. Shares, Stocks & Bonds (/investor/shares-information)
                Forms\Components\Section::make('Component 3: Shares & Bonds Information (/investor/shares-information)')
                    ->description('Renders hero banner, tab titles, and visibility controls for shareholder and dividend data.')
                    ->icon('heroicon-o-presentation-chart-line')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Fieldset::make('Hero Banner')
                            ->schema([
                                Forms\Components\TextInput::make('investor_share_banner_title_en')->label('Banner Title (EN)'),
                                Forms\Components\TextInput::make('investor_share_banner_title_id')->label('Banner Title (ID)'),
                                Forms\Components\Textarea::make('investor_share_banner_content_en')->label('Banner Subtitle (EN)')->rows(2),
                                Forms\Components\Textarea::make('investor_share_banner_content_id')->label('Banner Subtitle (ID)')->rows(2),
                                Forms\Components\FileUpload::make('investor_share_banner_file')->label('Banner Image')->image()->directory('page-management/investor')->columnSpanFull(),
                            ])
                            ->columns(2),

                        Forms\Components\Fieldset::make('Tab Navigation Titles')
                            ->schema([
                                Forms\Components\TextInput::make('investor_share_tab_one_title_en')->label('Tab 1 Title (EN)')->placeholder('Shareholders Structure'),
                                Forms\Components\TextInput::make('investor_share_tab_one_title_id')->label('Tab 1 Title (ID)')->placeholder('Struktur Pemegang Saham'),
                                Forms\Components\TextInput::make('investor_share_tab_two_title_en')->label('Tab 2 Title (EN)')->placeholder('Dividend History'),
                                Forms\Components\TextInput::make('investor_share_tab_two_title_id')->label('Tab 2 Title (ID)')->placeholder('Riwayat Dividen'),
                            ])
                            ->columns(2),

                        Forms\Components\Fieldset::make('Table Visibility Controls')
                            ->schema([
                                Forms\Components\Toggle::make('investor_share_shareholders_table_show')
                                    ->label('Show Shareholders Table')
                                    ->default(true),
                                Forms\Components\Toggle::make('investor_share_dividend_table_show')
                                    ->label('Show Dividend Table')
                                    ->default(true),
                                Forms\Components\Toggle::make('investor_share_bonds_table_show')
                                    ->label('Show Bonds Table')
                                    ->default(true),
                            ])
                            ->columns(3),
                    ]),

                // 4. Publications for Investors (/investor/publications-for-investors)
                Forms\Components\Section::make('Component 4: Publications for Investors (/investor/publications-for-investors)')
                    ->description('Renders hero banner and publications download browser.')
                    ->icon('heroicon-o-newspaper')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Fieldset::make('Hero Banner')
                            ->schema([
                                Forms\Components\TextInput::make('investor_publication_banner_title_en')->label('Banner Title (EN)'),
                                Forms\Components\TextInput::make('investor_publication_banner_title_id')->label('Banner Title (ID)'),
                                Forms\Components\Textarea::make('investor_publication_banner_content_en')->label('Banner Subtitle (EN)')->rows(2),
                                Forms\Components\Textarea::make('investor_publication_banner_content_id')->label('Banner Subtitle (ID)')->rows(2),
                                Forms\Components\FileUpload::make('investor_publication_banner_file')->label('Banner Image')->image()->directory('page-contents')->columnSpanFull(),
                            ])
                            ->columns(2),
                    ]),

                // 5. Interactive Tabular Data Editors
                Forms\Components\Section::make('Component 5: Interactive Financial & Shareholder Tables (Data Schema)')
                    ->description('Directly edit rows, headers, financial metrics, and dividend amounts displayed in frontend tables.')
                    ->icon('heroicon-o-table-cells')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Forms\Components\Tabs::make('Investor Tables')
                            ->tabs([
                                Forms\Components\Tabs\Tab::make('Financial Highlights Table')
                                    ->schema([
                                        Forms\Components\Textarea::make('investor_report_table_json')
                                            ->label('Table Schema (JSON)')
                                            ->rows(12)
                                            ->helperText('Contains columns and row arrays for Net Revenues, Profit/Loss, Total Assets, EBITDA, and Ratios.'),
                                    ]),
                                Forms\Components\Tabs\Tab::make('Shareholders Structure Table')
                                    ->schema([
                                        Forms\Components\Textarea::make('investor_share_shareholders_table_json')
                                            ->label('Table Schema (JSON)')
                                            ->rows(12)
                                            ->helperText('Contains shareholder entities, total shares owned, and shareholding percentages.'),
                                    ]),
                                Forms\Components\Tabs\Tab::make('Dividend History Table')
                                    ->schema([
                                        Forms\Components\Textarea::make('investor_share_dividend_table_json')
                                            ->label('Table Schema (JSON)')
                                            ->rows(12)
                                            ->helperText('Contains financial year, dividend per share, total dividend amount, and payout date.'),
                                    ]),
                                Forms\Components\Tabs\Tab::make('Bonds & Sukuk Table')
                                    ->schema([
                                        Forms\Components\Textarea::make('investor_share_bonds_table_json')
                                            ->label('Table Schema (JSON)')
                                            ->rows(12)
                                            ->helperText('Contains bond names, total issuance, interest rates, and maturity dates.'),
                                    ]),
                            ])
                            ->columnSpanFull(),
                    ]),

                // 6. Dedicated Feeds Reference
                Forms\Components\Section::make('Dedicated Investor Resources')
                    ->description('Downloadable reports (Prospectus, Financial Statements, General Meeting of Shareholders) and Institutions are managed directly in their dedicated resources:')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Forms\Components\Placeholder::make('investor_resource_links')
                            ->label('')
                            ->content(new \Illuminate\Support\HtmlString('
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 py-2">
                                    <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 flex flex-col justify-between">
                                        <div>
                                            <h4 class="font-bold text-sm text-gray-900 dark:text-gray-100 flex items-center gap-1.5">
                                                📑 Investor Reports & Publications
                                            </h4>
                                            <p class="text-xs text-gray-500 mt-1">Upload and manage PDFs for Prospectus, Annual Reports, and Presentation decks.</p>
                                        </div>
                                        <a href="/admin/investor/investor-reports" class="mt-4 inline-flex items-center text-xs font-semibold text-primary-600 hover:text-primary-500">
                                            Manage Investor Reports &rarr;
                                        </a>
                                    </div>

                                    <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 flex flex-col justify-between">
                                        <div>
                                            <h4 class="font-bold text-sm text-gray-900 dark:text-gray-100 flex items-center gap-1.5">
                                                🏛️ Supporting Capital Market Institutions
                                            </h4>
                                            <p class="text-xs text-gray-500 mt-1">Manage partner securities, custodians, rating agencies, and auditors.</p>
                                        </div>
                                        <a href="/admin/data/institutions" class="mt-4 inline-flex items-center text-xs font-semibold text-primary-600 hover:text-primary-500">
                                            Manage Institutions &rarr;
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
                ->label('View Live Investor Relations')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->color('gray')
                ->url(env('FRONTEND_URL', 'http://localhost:3000') . '/en/investor/report')
                ->openUrlInNewTab(),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Investor Content')
                ->submit('save')
                ->color('primary')
                ->icon('heroicon-o-check'),
        ];
    }

    public function save(): void
    {
        $keys = PreferenceKey::getAllInvestorKey();
        $state = $this->form->getState();

        PreferencePageService::saveKeys($state, $keys, 'page-contents');

        Notification::make()
            ->title('Investor Relations Content Updated')
            ->body('Investor relations components have been saved successfully.')
            ->success()
            ->send();
    }
}
