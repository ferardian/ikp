<?php

namespace App\Filament\Resources\JenisInsidenResource\Pages;

use App\Filament\Resources\JenisInsidenResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateJenisInsiden extends CreateRecord
{
    protected static string $resource = JenisInsidenResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
