<?php

namespace App\Filament\Resources\Pasien2Resource\Pages;

use App\Filament\Resources\Pasien2Resource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPasien2 extends EditRecord
{
    protected static string $resource = Pasien2Resource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
