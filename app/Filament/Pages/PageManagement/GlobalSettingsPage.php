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

class GlobalSettingsPage extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';

    protected static ?string $navigationGroup = 'Page Management';

    protected static ?string $navigationLabel = 'Global & Legal Settings';

    protected static ?string $title = 'Global, Legal & AI Settings';

    protected static ?int $navigationSort = 8;

    public static function canAccess(): bool
    {
        return itcan('page_management');
    }

    protected static string $view = 'filament.pages.page-management.global-settings-page';

    public ?array $data = [];

    protected function getCombinedKeys(): array
    {
        return array_merge(
            PreferenceKey::getOtherKeys(),
            PreferenceKey::getLlmsKeys()
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
                Forms\Components\Tabs::make('Settings Tabs')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Social Links')
                            ->icon('heroicon-o-share')
                            ->schema([
                                Forms\Components\Section::make('Corporate Social Media Channels')
                                    ->schema([
                                        Forms\Components\TextInput::make('social_linkedin_content_en')->label('LinkedIn URL')->url()->prefix('https://'),
                                        Forms\Components\TextInput::make('social_youtube_content_en')->label('YouTube Channel URL')->url()->prefix('https://'),
                                        Forms\Components\TextInput::make('social_instagram_content_en')->label('Instagram URL')->url()->prefix('https://'),
                                        Forms\Components\TextInput::make('social_x_content_en')->label('X / Twitter URL')->url()->prefix('https://'),
                                        Forms\Components\TextInput::make('social_facebook_content_en')->label('Facebook URL')->url()->prefix('https://'),
                                        Forms\Components\TextInput::make('social_tiktok_content_en')->label('TikTok URL')->url()->prefix('https://'),
                                    ])
                                    ->columns(2),
                            ]),

                        Forms\Components\Tabs\Tab::make('Contact & Whistleblowing')
                            ->icon('heroicon-o-envelope')
                            ->schema([
                                Forms\Components\Section::make('Email Dispatch Settings')
                                    ->schema([
                                        Forms\Components\TextInput::make('email_pic_whistleblowing_content_en')
                                            ->label('Whistleblowing Recipient Email (PIC)')
                                            ->email()
                                            ->helperText('Form submissions to Whistleblowing will be routed to this address'),
                                    ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Legal Pages')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                Forms\Components\Section::make('Privacy Policy')
                                    ->collapsible()
                                    ->schema([
                                        Forms\Components\RichEditor::make('privacy_policy_content_en')->label('Privacy Policy (🇬🇧 English)'),
                                        Forms\Components\RichEditor::make('privacy_policy_content_id')->label('Privacy Policy (🇮🇩 Bahasa Indonesia)'),
                                    ])
                                    ->columns(2),

                                Forms\Components\Section::make('Terms and Conditions')
                                    ->collapsible()
                                    ->schema([
                                        Forms\Components\RichEditor::make('terms_and_conditions_content_en')->label('Terms (🇬🇧 English)'),
                                        Forms\Components\RichEditor::make('terms_and_conditions_content_id')->label('Terms (🇮🇩 Bahasa Indonesia)'),
                                    ])
                                    ->columns(2),

                                Forms\Components\Section::make('Cookies Consent Notice')
                                    ->collapsible()
                                    ->schema([
                                        Forms\Components\RichEditor::make('cookies_consent_content_en')->label('Notice (🇬🇧 English)'),
                                        Forms\Components\RichEditor::make('cookies_consent_content_id')->label('Notice (🇮🇩 Bahasa Indonesia)'),
                                    ])
                                    ->columns(2),

                                Forms\Components\Section::make('Disclaimer')
                                    ->collapsible()
                                    ->schema([
                                        Forms\Components\RichEditor::make('disclaimer_content_en')->label('Disclaimer (🇬🇧 English)'),
                                        Forms\Components\RichEditor::make('disclaimer_content_id')->label('Disclaimer (🇮🇩 Bahasa Indonesia)'),
                                    ])
                                    ->columns(2),
                            ]),

                        Forms\Components\Tabs\Tab::make('AI Discovery (llms.txt)')
                            ->icon('heroicon-o-cpu-chip')
                            ->schema([
                                Forms\Components\Section::make('LLMS Content for AI Search Engines')
                                    ->description('These plain text documents allow LLMs (Perplexity, ChatGPT, Claude) to parse CDI corporate structure cleanly.')
                                    ->schema([
                                        Forms\Components\Textarea::make('llms_txt_content_en')
                                            ->label('llms.txt (Compact Guide)')
                                            ->rows(10),
                                        Forms\Components\Textarea::make('llms_full_txt_content_en')
                                            ->label('llms-full.txt (Full Knowledge Base)')
                                            ->rows(14),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ])
            ->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('view_live')
                ->label('View Legal Page')
                ->icon('heroicon-o-arrow-top-right-on-square')
                ->color('gray')
                ->url(env('FRONTEND_URL', 'http://localhost:3000') . '/en/privacy-policy')
                ->openUrlInNewTab(),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save Global Settings')
                ->submit('save')
                ->color('primary')
                ->icon('heroicon-o-check'),
        ];
    }

    public function save(): void
    {
        $keys = $this->getCombinedKeys();
        $state = $this->form->getState();

        PreferencePageService::saveKeys($state, $keys, 'page-contents');

        Notification::make()
            ->title('Global & Legal Settings Updated')
            ->body('Global preferences and legal documents saved successfully.')
            ->success()
            ->send();
    }
}
