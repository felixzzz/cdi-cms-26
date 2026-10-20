<?php

namespace App\Filament\Resources\Utility\PreferenceResource\Pages;

use App\Filament\Resources\Utility\PreferenceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPreferences extends ListRecords
{
    protected static string $resource = PreferenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
