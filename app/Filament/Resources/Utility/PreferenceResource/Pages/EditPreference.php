<?php

namespace App\Filament\Resources\Utility\PreferenceResource\Pages;

use App\Filament\Resources\Utility\PreferenceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPreference extends EditRecord
{
    protected static string $resource = PreferenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
