<?php

namespace App\Filament\Resources\Utility;

use App\Enums\TopicType;
use App\Filament\Resources\Utility\InboxResource\Pages;
use App\Models\Utility\Inbox;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class InboxResource extends Resource
{
    protected static ?string $model = Inbox::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';

    protected static ?string $navigationGroup = 'Inquiries & Submissions';

    public static function canCreate(): bool
    {
        return false; // Submissions come exclusively from the frontend forms
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Submission Details')
                    ->schema([
                        Forms\Components\Grid::make(2)->schema([
                            Forms\Components\TextInput::make('first_name')->disabled(),
                            Forms\Components\TextInput::make('last_name')->disabled(),
                            Forms\Components\TextInput::make('email')->disabled(),
                            Forms\Components\TextInput::make('type')->disabled(),
                            Forms\Components\Select::make('country_id')
                                ->relationship('country', 'name')
                                ->disabled(),
                            Forms\Components\Select::make('topic_id')
                                ->relationship('topic', 'name_en')
                                ->disabled(),
                        ]),
                        Forms\Components\Textarea::make('message')
                            ->rows(5)
                            ->disabled()
                            ->columnSpanFull(),
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Received At')
                            ->content(fn ($record) => $record?->created_at?->toDayDateTimeString()),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\BadgeColumn::make('type')
                    ->colors([
                        'primary' => fn ($state) => $state === TopicType::ContactUs || $state === TopicType::ContactUs->value,
                        'danger' => fn ($state) => $state === TopicType::Whistleblowing || $state === TopicType::Whistleblowing->value,
                    ]),
                Tables\Columns\TextColumn::make('first_name')
                    ->label('First Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->label('Last Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('topic.name_en')
                    ->label('Topic')
                    ->limit(30),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Received At')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        TopicType::ContactUs->value => 'Contact Us',
                        TopicType::Whistleblowing->value => 'Whistleblowing',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInboxes::route('/'),
            'view' => Pages\ViewInbox::route('/{record}'),
        ];
    }
}
