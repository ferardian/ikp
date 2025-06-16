<?php

namespace App\Filament\Resources\InvestigasiSederhanaResource\Pages;

use App\Filament\Resources\InvestigasiSederhanaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInvestigasiSederhana extends EditRecord
{
    protected static string $resource = InvestigasiSederhanaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
