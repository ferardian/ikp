<?php

namespace App\Filament\Resources\JenisInsidenResource\Pages;

use App\Filament\Resources\JenisInsidenResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJenisInsidens extends ListRecords
{
    protected static string $resource = JenisInsidenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getBreadcrumb(): ?string
    {
        return 'Data';
    }
}
