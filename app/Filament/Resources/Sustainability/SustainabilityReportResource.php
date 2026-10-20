<?php

namespace App\Filament\Resources\Sustainability;

use App\Filament\Resources\Sustainability\SustainabilityReportResource\Pages;
use App\Filament\Resources\Sustainability\SustainabilityReportResource\RelationManagers;
use App\Models\Sustainability\SustainabilityReport;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SustainabilityReportResource extends Resource
{
    protected static ?string $model = SustainabilityReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static ?string $navigationGroup = 'Corporate & Business';

    protected static ?string $navigationLabel = 'Sustainability Reports';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('ulid')
                    ->required(),
                Forms\Components\TextInput::make('type')
                    ->required(),
                Forms\Components\TextInput::make('title_en'),
                Forms\Components\TextInput::make('title_id'),
                Forms\Components\Textarea::make('description_en')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('description_id')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('author'),
                Forms\Components\TextInput::make('publisher'),
                Forms\Components\TextInput::make('release_year')
                    ->numeric(),
                Forms\Components\TextInput::make('pages')
                    ->numeric(),
                Forms\Components\TextInput::make('format'),
                Forms\Components\FileUpload::make('image')
                    ->image(),
                Forms\Components\Textarea::make('file')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ulid')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title_en')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('author')
                    ->searchable(),
                Tables\Columns\TextColumn::make('publisher')
                    ->searchable(),
                Tables\Columns\TextColumn::make('release_year')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pages')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('format')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListSustainabilityReports::route('/'),
            'create' => Pages\CreateSustainabilityReport::route('/create'),
            'edit' => Pages\EditSustainabilityReport::route('/{record}/edit'),
        ];
    }
}
