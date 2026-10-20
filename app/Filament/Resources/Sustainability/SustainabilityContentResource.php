<?php

namespace App\Filament\Resources\Sustainability;

use App\Filament\Resources\Sustainability\SustainabilityContentResource\Pages;
use App\Filament\Resources\Sustainability\SustainabilityContentResource\RelationManagers;
use App\Models\Sustainability\SustainabilityContent;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SustainabilityContentResource extends Resource
{
    protected static ?string $model = SustainabilityContent::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationGroup = 'Corporate & Business';

    protected static ?string $navigationLabel = 'Sustainability Pillars';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('ulid')
                    ->required(),
                Forms\Components\TextInput::make('category')
                    ->required(),
                Forms\Components\TextInput::make('name'),
                Forms\Components\TextInput::make('type')
                    ->required(),
                Forms\Components\TextInput::make('grid_type'),
                Forms\Components\TextInput::make('title_en'),
                Forms\Components\TextInput::make('title_id'),
                Forms\Components\Textarea::make('content_en')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('content_id')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('content_json_en')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('content_json_id')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('align')
                    ->required(),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->required(),
                Forms\Components\Textarea::make('file_information_id')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('background')
                    ->required(),
                Forms\Components\TextInput::make('grid_direction')
                    ->required(),
                Forms\Components\TextInput::make('grid_pattern')
                    ->required(),
                Forms\Components\TextInput::make('sort')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('is_show')
                    ->required()
                    ->numeric()
                    ->default(1),
                Forms\Components\Textarea::make('file_information_en')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ulid')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('grid_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title_en')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('align')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('background')
                    ->searchable(),
                Tables\Columns\TextColumn::make('grid_direction')
                    ->searchable(),
                Tables\Columns\TextColumn::make('grid_pattern')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sort')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('is_show')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSustainabilityContents::route('/'),
            'create' => Pages\CreateSustainabilityContent::route('/create'),
            'edit' => Pages\EditSustainabilityContent::route('/{record}/edit'),
        ];
    }
}
