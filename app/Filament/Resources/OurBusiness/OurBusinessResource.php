<?php

namespace App\Filament\Resources\OurBusiness;

use App\Filament\Resources\OurBusiness\OurBusinessResource\Pages;
use App\Models\OurBusiness\OurBusiness;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OurBusinessResource extends Resource
{
    protected static ?string $model = OurBusiness::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';

    protected static ?string $navigationGroup = 'Corporate & Business';

    protected static ?string $navigationLabel = 'Business Pillars';

    protected static ?int $navigationSort = 1;

    public static function canViewAny(): bool
    {
        return itcan('our_business');
    }

    public static function canCreate(): bool
    {
        return false; // The 4 business units (energy, water, port_storage, logistic) are core pillars
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Pillar Overview')
                    ->schema([
                        Forms\Components\TextInput::make('type')
                            ->label('Pillar Code')
                            ->disabled(),
                        Forms\Components\TextInput::make('link_url')
                            ->label('External / Pillar URL')
                            ->placeholder('https://...'),
                    ])
                    ->columns(2),

                Forms\Components\Tabs::make('Pillar Details')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('🇬🇧 English')
                            ->schema([
                                Forms\Components\TextInput::make('title_en')->label('Pillar Title (EN)')->required(),
                                Forms\Components\RichEditor::make('description_en')->label('Description (EN)')->columnSpanFull(),
                                Forms\Components\TextInput::make('banner_title_en')->label('Banner Title (EN)'),
                                Forms\Components\Textarea::make('banner_description_en')->label('Banner Description (EN)'),
                                Forms\Components\TextInput::make('overview_title_en')->label('Overview Section Title (EN)'),
                                Forms\Components\RichEditor::make('overview_description_en')->label('Overview Description (EN)')->columnSpanFull(),
                                Forms\Components\TextInput::make('heading_tab_title_en')->label('Tabs Section Heading (EN)'),
                                Forms\Components\TextInput::make('link_title_en')->label('Button / Link Label (EN)'),
                            ])
                            ->columns(2),

                        Forms\Components\Tabs\Tab::make('🇮🇩 Bahasa Indonesia')
                            ->schema([
                                Forms\Components\TextInput::make('title_id')->label('Pillar Title (ID)')->required(),
                                Forms\Components\RichEditor::make('description_id')->label('Description (ID)')->columnSpanFull(),
                                Forms\Components\TextInput::make('banner_title_id')->label('Banner Title (ID)'),
                                Forms\Components\Textarea::make('banner_description_id')->label('Banner Description (ID)'),
                                Forms\Components\TextInput::make('overview_title_id')->label('Overview Section Title (ID)'),
                                Forms\Components\RichEditor::make('overview_description_id')->label('Overview Description (ID)')->columnSpanFull(),
                                Forms\Components\TextInput::make('heading_tab_title_id')->label('Tabs Section Heading (ID)'),
                                Forms\Components\TextInput::make('link_title_id')->label('Button / Link Label (ID)'),
                            ])
                            ->columns(2),

                        Forms\Components\Tabs\Tab::make('Media Assets')
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->label('Thumbnail Image')
                                    ->image()
                                    ->directory('business/thumb'),
                                Forms\Components\FileUpload::make('banner_image')
                                    ->label('Hero Banner Image')
                                    ->image()
                                    ->directory('business/banner'),
                                Forms\Components\FileUpload::make('overview_image')
                                    ->label('Overview Section Image')
                                    ->image()
                                    ->directory('business/overview'),
                            ])
                            ->columns(3),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('Pillar')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'energy' => 'warning',
                        'water' => 'info',
                        'port_storage' => 'primary',
                        'logistic' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('title_en')
                    ->label('Title (EN)')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('title_id')
                    ->label('Title (ID)')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('banner_title_en')
                    ->label('Banner Headline')
                    ->limit(35),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOurBusinesses::route('/'),
            'edit' => Pages\EditOurBusiness::route('/{record}/edit'),
        ];
    }
}
