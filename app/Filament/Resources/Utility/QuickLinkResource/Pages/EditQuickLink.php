<?php

namespace App\Filament\Resources\Utility\QuickLinkResource\Pages;

use App\Filament\Resources\Utility\QuickLinkResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuickLink extends EditRecord
{
    protected static string $resource = QuickLinkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
