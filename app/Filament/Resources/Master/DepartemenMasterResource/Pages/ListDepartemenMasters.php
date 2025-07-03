<?php

namespace App\Filament\Resources\Master\DepartemenMasterResource\Pages;

use App\Filament\Resources\Master\DepartemenMasterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDepartemenMasters extends ListRecords
{
    protected static string $resource = DepartemenMasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
