<?php

namespace App\Filament\Resources\Sustainability\SustainabilityReportResource\Pages;

use App\Filament\Resources\Sustainability\SustainabilityReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSustainabilityReport extends EditRecord
{
    protected static string $resource = SustainabilityReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
