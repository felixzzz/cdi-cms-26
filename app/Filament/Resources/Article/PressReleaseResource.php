<?php

namespace App\Filament\Resources\Article;

use App\Filament\Resources\Article\PressReleaseResource\Pages;
use App\Models\Article\PressRelease;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PressReleaseResource extends Resource
{
    protected static ?string $model = PressRelease::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationGroup = 'Media & News';

    protected static ?int $navigationSort = 2;

    public static function canViewAny(): bool
    {
        return itcan('press_releases');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Release Meta & Status')
                    ->schema([
                        Forms\Components\DateTimePicker::make('datetime')
                            ->label('Publication Date & Time')
                            ->default(now())
                            ->required(),

                        Forms\Components\Toggle::make('status')
                            ->label('Published')
                            ->default(true),
                    ])
                    ->columns(2),

                Forms\Components\Tabs::make('Bilingual Content')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('🇬🇧 English')
                            ->schema([
                                Forms\Components\TextInput::make('name_en')
                                    ->label('Release Title (EN)')
                                    ->required(),
                                Forms\Components\FileUpload::make('file_en')
                                    ->label('Document (PDF / EN)')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->directory('press-release/en'),
                            ]),
                        Forms\Components\Tabs\Tab::make('🇮🇩 Bahasa Indonesia')
                            ->schema([
                                Forms\Components\TextInput::make('name_id')
                                    ->label('Release Title (ID)')
                                    ->required(),
                                Forms\Components\FileUpload::make('file_id')
                                    ->label('Document (PDF / ID)')
                                    ->acceptedFileTypes(['application/pdf'])
                                    ->directory('press-release/id'),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_en')
                    ->label('Title (EN)')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('datetime')
                    ->label('Date')
                    ->dateTime('d M Y')
                    ->sortable(),

                Tables\Columns\IconColumn::make('status')
                    ->label('Published')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('datetime', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('status')
                    ->label('Publication Status'),
            ])
            ->actions([
                Tables\Actions\Action::make('download_en')
                    ->label('PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('gray')
                    ->url(fn (PressRelease $record) => $record->file_en ? (str_starts_with($record->file_en, 'http') ? $record->file_en : "/file-storage/{$record->file_en}") : null)
                    ->openUrlInNewTab()
                    ->visible(fn (PressRelease $record) => filled($record->file_en)),
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
            'index' => Pages\ListPressReleases::route('/'),
            'create' => Pages\CreatePressRelease::route('/create'),
            'edit' => Pages\EditPressRelease::route('/{record}/edit'),
        ];
    }
}
