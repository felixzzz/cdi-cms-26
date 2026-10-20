<?php

namespace App\Filament\Resources\OurBusiness\OurBusinessResource\Pages;

use App\Filament\Resources\OurBusiness\OurBusinessResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOurBusiness extends EditRecord
{
    protected static string $resource = OurBusinessResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
