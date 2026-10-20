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

class GovernancePageContent extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-shield-check';

    protected static ?string $navigationGroup = 'Page Management';

    protected static ?string $navigationLabel = 'Governance Content';

    protected static ?string $title = 'Good Corporate Governance (GCG) Components';

    protected static ?int $navigationSort = 6;

    protected static string $view = 'filament.pages.page-management.governance-page-content';

    public ?array $data = [];

    public function mount(): void
    {
        $keys = PreferenceKey::getAllGovernanceKey();
        $this->form->fill(PreferencePageService::loadKeys($keys));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // 1. Hero Banner
                Forms\Components\Section::make('Component 1: Governance Hero Banner')
                    ->description('Renders at the top of /governance.')
                    ->icon('heroicon-o-photo')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('governance_banner_title_en')->label('Headline (EN)')->required(),
                        Forms\Components\TextInput::make('governance_banner_title_id')->label('Headline (ID)')->required(),
                        Forms\Components\Textarea::make('governance_banner_content_en')->label('Subtitle (EN)')->rows(2),
                        Forms\Components\Textarea::make('governance_banner_content_id')->label('Subtitle (ID)')->rows(2),
                        Forms\Components\FileUpload::make('governance_banner_file')->label('Banner Image')->image()->directory('page-management/governance')->columnSpanFull(),
                    ])
                    ->columns(2),

                // 2. Corporate Secretary
                Forms\Components\Section::make('Component 2: Corporate Secretary Section')
                    ->description('Corporate Secretary role description, team profile, and appointed officer.')
                    ->icon('heroicon-o-user-circle')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Fieldset::make('Section Description')
                            ->schema([
                                Forms\Components\TextInput::make('governance_corporate_secretary_title_en')->label('Section Title (EN)'),
                                Forms\Components\TextInput::make('governance_corporate_secretary_title_id')->label('Section Title (ID)'),
                                Forms\Components\RichEditor::make('governance_corporate_secretary_content_en')->label('Description (EN)')->columnSpanFull(),
                                Forms\Components\RichEditor::make('governance_corporate_secretary_content_id')->label('Description (ID)')->columnSpanFull(),
                            ])
                            ->columns(2),

                        Forms\Components\Fieldset::make('Appointed Corporate Secretary Profile')
                            ->schema([
                                Forms\Components\TextInput::make('governance_corporate_secretary_team_title_en')->label('Officer Name & Title (EN)'),
                                Forms\Components\TextInput::make('governance_corporate_secretary_team_title_id')->label('Officer Name & Title (ID)'),
                                Forms\Components\RichEditor::make('governance_corporate_secretary_team_content_en')->label('Officer Biography (EN)')->columnSpanFull(),
                                Forms\Components\RichEditor::make('governance_corporate_secretary_team_content_id')->label('Officer Biography (ID)')->columnSpanFull(),
                                Forms\Components\FileUpload::make('governance_corporate_secretary_team_file')->label('Officer Portrait Photo')->image()->directory('page-management/governance')->columnSpanFull(),
                            ])
                            ->columns(2),
                    ]),

                // 3. Internal Audit Unit
                Forms\Components\Section::make('Component 3: Internal Audit Unit')
                    ->description('Internal Audit Unit mandate, oversight duties, and reporting lines.')
                    ->icon('heroicon-o-clipboard-document-check')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('governance_internal_audit_unit_title_en')->label('Title (EN)'),
                        Forms\Components\TextInput::make('governance_internal_audit_unit_title_id')->label('Title (ID)'),
                        Forms\Components\RichEditor::make('governance_internal_audit_unit_content_en')->label('Mandate Body (EN)')->columnSpanFull(),
                        Forms\Components\RichEditor::make('governance_internal_audit_unit_content_id')->label('Mandate Body (ID)')->columnSpanFull(),
                    ])
                    ->columns(2),

                // 4. Committees
                Forms\Components\Section::make('Component 4: Audit & Sustainability Committees')
                    ->description('Board committees, charters, and member structure.')
                    ->icon('heroicon-o-user-group')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Fieldset::make('Audit Committee')
                            ->schema([
                                Forms\Components\TextInput::make('governance_audit_committe_title_en')->label('Title (EN)'),
                                Forms\Components\TextInput::make('governance_audit_committe_title_id')->label('Title (ID)'),
                                Forms\Components\RichEditor::make('governance_audit_committe_content_en')->label('Charter / Description (EN)')->columnSpanFull(),
                                Forms\Components\RichEditor::make('governance_audit_committe_content_id')->label('Charter / Description (ID)')->columnSpanFull(),
                                Forms\Components\Toggle::make('governance_audit_committe_show')->label('Display Audit Committee on Page')->default(true)->columnSpanFull(),
                            ])
                            ->columns(2),

                        Forms\Components\Fieldset::make('Sustainability Committee')
                            ->schema([
                                Forms\Components\TextInput::make('governance_sustainability_committe_title_en')->label('Title (EN)'),
                                Forms\Components\TextInput::make('governance_sustainability_committe_title_id')->label('Title (ID)'),
                                Forms\Components\RichEditor::make('governance_sustainability_committe_content_en')->label('Mandate / Description (EN)')->columnSpanFull(),
                                Forms\Components\RichEditor::make('governance_sustainability_committe_content_id')->label('Mandate / Description (ID)')->columnSpanFull(),
                                Forms\Components\Toggle::make('governance_sustainability_committe_show')->label('Display Sustainability Committee on Page')->default(true)->columnSpanFull(),
                            ])
                            ->columns(2),
                    ]),

                // 5. Risk Management & SHE
                Forms\Components\Section::make('Component 5: Risk Management & Regulations')
                    ->description('Enterprise Risk Management framework and Safety, Health & Environment guidelines.')
                    ->icon('heroicon-o-shield-exclamation')
                    ->collapsible()
                    ->schema([
                        Forms\Components\Fieldset::make('Enterprise Risk Management')
                            ->schema([
                                Forms\Components\TextInput::make('governance_risk_management_title_en')->label('Title (EN)'),
                                Forms\Components\TextInput::make('governance_risk_management_title_id')->label('Title (ID)'),
                                Forms\Components\RichEditor::make('governance_risk_management_content_en')->label('Description (EN)')->columnSpanFull(),
                                Forms\Components\RichEditor::make('governance_risk_management_content_id')->label('Description (ID)')->columnSpanFull(),
                                Forms\Components\Toggle::make('governance_risk_management_show')->label('Display Risk Management on Page')->default(true)->columnSpanFull(),
                            ])
                            ->columns(2),

                        Forms\Components\Fieldset::make('Code of Conduct & SHE')
                            ->schema([
                                Forms\Components\TextInput::make('governance_code_of_conduct_title_en')->label('Code of Conduct Title (EN)'),
                                Forms\Components\TextInput::make('governance_code_of_conduct_title_id')->label('Code of Conduct Title (ID)'),
                                Forms\Components\RichEditor::make('governance_code_of_conduct_content_en')->label('Code of Conduct Text (EN)')->columnSpanFull(),
                                Forms\Components\RichEditor::make('governance_code_of_conduct_content_id')->label('Code of Conduct Text (ID)')->columnSpanFull(),

                                Forms\Components\TextInput::make('governance_she_regulation_title_en')->label('SHE Regulation Title (EN)'),
                                Forms\Components\TextInput::make('governance_she_regulation_title_id')->label('SHE Regulation Title (ID)'),
                                Forms\Components\RichEditor::make('governance_she_regulation_content_en')->label('SHE Regulation Text (EN)')->columnSpanFull(),
                                Forms\Components\RichEditor::make('governance_she_regulation_content_id')->label('SHE Regulation Text (ID)')->columnSpanFull(),
                                Forms\Components\Toggle::make('governance_she_regulation_show')->label('Display SHE Regulation')->default(true)->columnSpanFull(),
                            ])
                            ->columns(2),
                    ]),

                // 6. Whistleblowing System
                Forms\Components\Section::make('Component 6: Whistleblowing System (WBS)')
                    ->description('Whistleblowing guidelines, intake procedure, and operational flowcharts.')
                    ->icon('heroicon-o-megaphone')
                    ->collapsible()
                    ->schema([
                        Forms\Components\TextInput::make('governance_whistleblowing_title_en')->label('WBS Title (EN)'),
                        Forms\Components\TextInput::make('governance_whistleblowing_title_id')->label('WBS Title (ID)'),
                        Forms\Components\RichEditor::make('governance_whistleblowing_content_en')->label('WBS Policy Description (EN)')->columnSpanFull(),
                        Forms\Components\RichEditor::make('governance_whistleblowing_content_id')->label('WBS Policy Description (ID)')->columnSpanFull(),
                        Forms\Components\FileUpload::make('governance_whistleblowing_id_file')->label('WBS Mechanism Flowchart Image')->image()->directory('page-management/governance')->columnSpanFull(),
                        Forms\Components\RichEditor::make('governance_whistleblowing_detail_content_en')->label('Filing Procedures & Channels (EN)')->columnSpanFull(),
                        Forms\Components\RichEditor::make('governance_whistleblowing_detail_content_id')->label('Filing Procedures & Channels (ID)')->columnSpanFull(),
                    ])
                    ->columns(2),

                // 7. Dedicated Files Reference
                Forms\Components\Section::make('Dedicated Governance Documents')
                    ->description('Charters, policy PDFs, and official GCG downloadable documents:')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Forms\Components\Placeholder::make('governance_links')
                            ->label('')
                            ->content(new \Illuminate\Support\HtmlString('
                                <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 flex flex-col justify-between max-w-md">
                                    <div>
                                        <h4 class="font-bold text-sm text-gray-900 dark:text-gray-100 flex items-center gap-1.5">
                                            📄 Governance Policy & Charter Files
                                        </h4>
                                        <p class="text-xs text-gray-500 mt-1">Upload and manage downloadable PDFs for Corporate Charters, Code of Ethics, and Board Regulations.</p>
                                    </div>
                                    <a href="/admin/governance/governance-files" class="mt-4 inline-flex items-center text-xs font-semibold text-primary-600 hover:text-primary-500">
                                        Manage Governance Files &rarr;
                                    </a>
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
                ->label('View Live Governance')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->color('gray')
                ->url(env('FRONTEND_URL', 'http://localhost:3000') . '/en/governance')
                ->openUrlInNewTab(),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Governance Content')
                ->submit('save')
                ->color('primary')
                ->icon('heroicon-o-check'),
        ];
    }

    public function save(): void
    {
        $keys = PreferenceKey::getAllGovernanceKey();
        $state = $this->form->getState();

        PreferencePageService::saveKeys($state, $keys, 'page-contents');

        Notification::make()
            ->title('Governance Content Updated')
            ->body('Governance components have been saved successfully.')
            ->success()
            ->send();
    }
}
