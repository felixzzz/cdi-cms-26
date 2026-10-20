<?php

namespace App\Filament\Resources\Investor\InvestorReportResource\Pages;

use App\Filament\Resources\Investor\InvestorReportResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInvestorReport extends EditRecord
{
    protected static string $resource = InvestorReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
