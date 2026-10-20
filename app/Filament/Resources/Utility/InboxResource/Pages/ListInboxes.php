<?php

namespace App\Filament\Resources\Utility\InboxResource\Pages;

use App\Filament\Resources\Utility\InboxResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInboxes extends ListRecords
{
    protected static string $resource = InboxResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export_csv')
                ->label('Export to CSV')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->action(function () {
                    $fileName = 'cdi-inbox-export-' . now()->format('Y-m-d-His') . '.csv';
                    return response()->streamDownload(function () {
                        $handle = fopen('php://output', 'w');
                        fputcsv($handle, ['ID', 'Type', 'First Name', 'Last Name', 'Email', 'Topic', 'Country', 'Message', 'Received At']);

                        \App\Models\Utility\Inbox::with(['topic', 'country'])->chunk(100, function ($inboxes) use ($handle) {
                            foreach ($inboxes as $inbox) {
                                fputcsv($handle, [
                                    $inbox->id,
                                    $inbox->type instanceof \App\Enums\TopicType ? $inbox->type->word() : $inbox->type,
                                    $inbox->first_name,
                                    $inbox->last_name,
                                    $inbox->email,
                                    $inbox->topic?->name_en ?? '-',
                                    $inbox->country?->name ?? '-',
                                    $inbox->message,
                                    $inbox->created_at?->toIso8601String(),
                                ]);
                            }
                        });

                        fclose($handle);
                    }, $fileName, [
                        'Content-Type' => 'text/csv',
                    ]);
                }),
        ];
    }
}
