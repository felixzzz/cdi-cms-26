<?php

namespace App\Filament\Resources\Sustainability\SustainabilityContentResource\Pages;

use App\Filament\Resources\Sustainability\SustainabilityContentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSustainabilityContents extends ListRecords
{
    protected static string $resource = SustainabilityContentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
