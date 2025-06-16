<?php

namespace App\Filament\Resources\PenanggungBiayaResource\Pages;

use App\Filament\Resources\PenanggungBiayaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPenanggungBiayas extends ListRecords
{
    protected static string $resource = PenanggungBiayaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return 'Data Penanggung Biaya';
    }

    public function getBreadcrumb(): ?string
    {
        return 'Data';
    }
}
