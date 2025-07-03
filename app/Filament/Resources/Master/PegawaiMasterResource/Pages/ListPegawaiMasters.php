<?php

namespace App\Filament\Resources\Master\PegawaiMasterResource\Pages;

use App\Filament\Resources\Master\PegawaiMasterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPegawaiMasters extends ListRecords
{
    protected static string $resource = PegawaiMasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
