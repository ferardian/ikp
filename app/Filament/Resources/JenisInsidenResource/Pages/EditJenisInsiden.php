<?php

namespace App\Filament\Resources\JenisInsidenResource\Pages;

use App\Filament\Resources\JenisInsidenResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJenisInsiden extends EditRecord
{
    protected static string $resource = JenisInsidenResource::class;

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
