<?php

namespace App\Filament\Resources\InvestigasiSederhanaResource\Pages;

use App\Filament\Resources\InvestigasiSederhanaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInvestigasiSederhanas extends ListRecords
{
    protected static string $resource = InvestigasiSederhanaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getMaxContentWidth(): string
    {
        return 'full';
    }
}
