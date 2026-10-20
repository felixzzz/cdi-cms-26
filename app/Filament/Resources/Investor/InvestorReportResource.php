<?php

namespace App\Filament\Resources\Investor;

use App\Enums\InvestorReportType;
use App\Filament\Resources\Investor\InvestorReportResource\Pages;
use App\Models\Investor\InvestorReport;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InvestorReportResource extends Resource
{
    protected static ?string $model = InvestorReport::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static ?string $navigationGroup = 'Investor Relations';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Tabs::make('Report Content')
                            ->tabs([
                                Forms\Components\Tabs\Tab::make('🇬🇧 English')
                                    ->schema([
                                        Forms\Components\TextInput::make('name_en')
                                            ->label('Report Title (English)')
                                            ->required(),
                                        Forms\Components\KeyValue::make('file_en')
                                            ->label('Document File Data (English)')
                                            ->helperText('Contains path, size, format metadata'),
                                    ]),
                                Forms\Components\Tabs\Tab::make('🇮🇩 Bahasa Indonesia')
                                    ->schema([
                                        Forms\Components\TextInput::make('name_id')
                                            ->label('Report Title (Indonesian)')
                                            ->required(),
                                        Forms\Components\KeyValue::make('file_id')
                                            ->label('Document File Data (Indonesian)')
                                            ->helperText('Contains path, size, format metadata'),
                                    ]),
                            ])
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Report Classification')
                            ->schema([
                                Forms\Components\Select::make('type')
                                    ->label('Report Category')
                                    ->options(array_combine(
                                        array_map(fn($c) => $c->value, InvestorReportType::cases()),
                                        array_map(fn($c) => ucwords(str_replace('_', ' ', $c->value)), InvestorReportType::cases())
                                    ))
                                    ->required(),
                                Forms\Components\DateTimePicker::make('datetime')
                                    ->label('Report Date')
                                    ->default(now())
                                    ->required(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name_en')
                    ->label('Report Title')
                    ->searchable(['name_en', 'name_id'])
                    ->limit(50)
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('type')
                    ->label('Type')
                    ->sortable(),
                Tables\Columns\TextColumn::make('datetime')
                    ->label('Report Date')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options(array_combine(
                        array_map(fn($c) => $c->value, InvestorReportType::cases()),
                        array_map(fn($c) => ucwords(str_replace('_', ' ', $c->value)), InvestorReportType::cases())
                    )),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('datetime', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvestorReports::route('/'),
            'create' => Pages\CreateInvestorReport::route('/create'),
            'edit' => Pages\EditInvestorReport::route('/{record}/edit'),
        ];
    }
}
