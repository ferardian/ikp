<?php

namespace App\Filament\Resources\Master\PegawaiMasterResource\Pages;

use App\Filament\Resources\Master\PegawaiMasterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPegawaiMaster extends EditRecord
{
    protected static string $resource = PegawaiMasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
