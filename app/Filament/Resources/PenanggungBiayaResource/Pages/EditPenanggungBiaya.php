<?php

namespace App\Filament\Resources\PenanggungBiayaResource\Pages;

use App\Filament\Resources\PenanggungBiayaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPenanggungBiaya extends EditRecord
{
    protected static string $resource = PenanggungBiayaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
