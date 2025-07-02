<?php

namespace App\Filament\Resources\PasienMasterResource\Pages;

use App\Filament\Resources\PasienMasterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPasienMasters extends ListRecords
{
    protected static string $resource = PasienMasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
