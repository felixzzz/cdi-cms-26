<?php

namespace App\Filament\Resources\Utility;

use App\Filament\Resources\Utility\PreferenceResource\Pages;
use App\Models\Utility\Preference;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PreferenceResource extends Resource
{
    protected static ?string $model = Preference::class;

    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';

    protected static ?string $navigationGroup = 'System Settings';

    protected static ?string $navigationLabel = 'Raw Preferences (All Keys)';

    protected static ?int $navigationSort = 99;

    public static function canViewAny(): bool
    {
        return itcan('system_settings');
    }

    public static function canCreate(): bool
    {
        return false; // Keys are pre-defined by the corporate CMS schema
    }

    public static function canDelete($record): bool
    {
        return false; // Prevent accidental deletion of core corporate preferences
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Setting Identification')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('key')
                                ->label('Preference Key')
                                ->disabled(),
                            Forms\Components\TextInput::make('type')
                                ->label('Type')
                                ->disabled(),
                        ]),
                    ]),

                Forms\Components\Tabs::make('Content')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('🇬🇧 English')
                            ->schema([
                                Forms\Components\TextInput::make('title_en')
                                    ->label('Title / Heading (English)'),
                                Forms\Components\RichEditor::make('content_en')
                                    ->label('Body Content / Value (English)'),
                            ]),

                        Forms\Components\Tabs\Tab::make('🇮🇩 Bahasa Indonesia')
                            ->schema([
                                Forms\Components\TextInput::make('title_id')
                                    ->label('Title / Heading (Indonesian)'),
                                Forms\Components\RichEditor::make('content_id')
                                    ->label('Body Content / Value (Indonesian)'),
                            ]),

                        Forms\Components\Tabs\Tab::make('Media & Tables')
                            ->schema([
                                Forms\Components\TextInput::make('file')
                                    ->label('Associated Media Path / Key'),
                                Forms\Components\KeyValue::make('content_table')
                                    ->label('Structured Table Data')
                                    ->helperText('Custom table headers and rows'),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('Key')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('title_en')
                    ->label('Title (EN)')
                    ->searchable()
                    ->limit(35),
                Tables\Columns\TextColumn::make('title_id')
                    ->label('Title (ID)')
                    ->searchable()
                    ->limit(35)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\BadgeColumn::make('type')
                    ->label('Type')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Last Updated')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Page Category')
                    ->options([
                        'home' => 'Home Page',
                        'about_us' => 'About Us',
                        'investor' => 'Investor Relations',
                        'governance' => 'Governance',
                        'sustainability' => 'Sustainability',
                        'meta' => 'SEO Metadata',
                        'social' => 'Social Channels',
                        'legal' => 'Legal Policies',
                    ])
                    ->query(function ($query, array $data) {
                        $value = $data['value'] ?? null;
                        if (!$value) return $query;
                        return match ($value) {
                            'home' => $query->where('key', 'like', 'home_%'),
                            'about_us' => $query->where('key', 'like', 'about_us_%'),
                            'investor' => $query->where('key', 'like', 'investor_%'),
                            'governance' => $query->where('key', 'like', 'governance_%'),
                            'sustainability' => $query->where('key', 'like', 'sustainability_%'),
                            'meta' => $query->where('key', 'like', 'meta_%'),
                            'social' => $query->where('key', 'like', 'social_%'),
                            'legal' => $query->whereIn('key', ['terms_and_conditions', 'privacy_policy', 'cookies_consent', 'disclaimer']),
                            default => $query,
                        };
                    }),
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'text' => 'Text',
                        'image' => 'Image',
                        'video' => 'Video',
                        'table' => 'Table',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->defaultSort('key', 'asc')
            ->paginated([25, 50, 100]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPreferences::route('/'),
            'edit' => Pages\EditPreference::route('/{record}/edit'),
        ];
    }
}
