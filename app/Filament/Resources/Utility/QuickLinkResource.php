<?php

namespace App\Filament\Resources\Utility;

use App\Enums\QuickLinkCategory;
use App\Filament\Resources\Utility\QuickLinkResource\Pages;
use App\Models\Utility\QuickLink;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class QuickLinkResource extends Resource
{
    protected static ?string $model = QuickLink::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    protected static ?string $navigationGroup = 'Page Management';
    protected static ?string $navigationLabel = 'Quick & Footer Links';
    protected static ?int $navigationSort = 7;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Quick Link Details')
                    ->schema([
                        Forms\Components\Select::make('category')
                            ->label('Page Category')
                            ->options(collect(QuickLinkCategory::cases())->mapWithKeys(fn ($case) => [$case->value => $case->word()]))
                            ->required()
                            ->native(false),

                        Forms\Components\TextInput::make('url')
                            ->label('Target URL')
                            ->url()
                            ->required()
                            ->placeholder('https://example.com'),

                        Forms\Components\TextInput::make('sort')
                            ->label('Sort Order')
                            ->numeric()
                            ->default(1),

                        Forms\Components\Tabs::make('Bilingual Titles')
                            ->tabs([
                                Forms\Components\Tabs\Tab::make('🇬🇧 English')
                                    ->schema([
                                        Forms\Components\TextInput::make('name_en')
                                            ->label('Link Label (EN)')
                                            ->required(),
                                    ]),
                                Forms\Components\Tabs\Tab::make('🇮🇩 Bahasa Indonesia')
                                    ->schema([
                                        Forms\Components\TextInput::make('name_id')
                                            ->label('Link Label (ID)')
                                            ->required(),
                                    ]),
                            ])
                            ->columnSpanFull(),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state instanceof QuickLinkCategory ? $state->word() : ($state ?? '—'))
                    ->color(fn ($state) => match ($state instanceof QuickLinkCategory ? $state->value : $state) {
                        1 => 'primary',
                        2 => 'warning',
                        3 => 'success',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('name_en')
                    ->label('Title (EN)')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('name_id')
                    ->label('Title (ID)')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('url')
                    ->label('URL')
                    ->limit(40)
                    ->url(fn ($record) => $record->url, true)
                    ->color('info')
                    ->searchable(),

                Tables\Columns\TextColumn::make('sort')
                    ->label('Order')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options(collect(QuickLinkCategory::cases())->mapWithKeys(fn ($case) => [$case->value => $case->word()])),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuickLinks::route('/'),
            'create' => Pages\CreateQuickLink::route('/create'),
            'edit' => Pages\EditQuickLink::route('/{record}/edit'),
        ];
    }
}
