<?php

namespace App\Filament\Widgets;

use App\Enums\TopicType;
use App\Models\Utility\Inbox;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentSubmissionsWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Inbox::query()->latest()->limit(5))
            ->heading('Recent Public Inquiries & Whistleblowing')
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn ($state): string => match ($state instanceof TopicType ? $state->value : (string) $state) {
                        TopicType::ContactUs->value, 'contact_us', 'contact-us' => 'primary',
                        TopicType::Whistleblowing->value, 'whistleblowing' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state): string => match ($state instanceof TopicType ? $state->value : (string) $state) {
                        TopicType::ContactUs->value, 'contact_us' => 'Contact Us',
                        TopicType::Whistleblowing->value, 'whistleblowing' => 'Whistleblowing',
                        default => ucfirst((string) $state),
                    }),
                Tables\Columns\TextColumn::make('first_name')->label('First Name'),
                Tables\Columns\TextColumn::make('last_name')->label('Last Name'),
                Tables\Columns\TextColumn::make('email')->copyable(),
                Tables\Columns\TextColumn::make('topic.name_en')->label('Topic')->placeholder('-'),
                Tables\Columns\TextColumn::make('created_at')->label('Received')->dateTime('d M Y H:i')->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-m-eye')
                    ->url(fn (Inbox $record): string => "/admin/utility/inboxes/{$record->id}"),
            ])
            ->emptyStateHeading('No inquiries received yet')
            ->emptyStateDescription('Contact messages and whistleblowing reports submitted on the public website will appear here.')
            ->emptyStateIcon('heroicon-o-inbox');
    }
}
