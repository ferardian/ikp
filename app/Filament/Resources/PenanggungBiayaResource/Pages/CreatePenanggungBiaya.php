<?php

namespace App\Filament\Resources\PenanggungBiayaResource\Pages;

use App\Filament\Resources\PenanggungBiayaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePenanggungBiaya extends CreateRecord
{
    protected static string $resource = PenanggungBiayaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
