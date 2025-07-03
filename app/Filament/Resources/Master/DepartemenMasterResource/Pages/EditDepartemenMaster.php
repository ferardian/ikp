<?php

namespace App\Filament\Resources\Master\DepartemenMasterResource\Pages;

use App\Filament\Resources\Master\DepartemenMasterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDepartemenMaster extends EditRecord
{
    protected static string $resource = DepartemenMasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
