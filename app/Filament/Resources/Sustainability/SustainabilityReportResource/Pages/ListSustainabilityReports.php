<?php

namespace App\Filament\Resources\Sustainability\SustainabilityReportResource\Pages;

use App\Filament\Resources\Sustainability\SustainabilityReportResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSustainabilityReports extends ListRecords
{
    protected static string $resource = SustainabilityReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
