<?php

namespace App\Filament\Resources\InsidenResource\Pages;

use App\Filament\Resources\InsidenResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInsidens extends ListRecords
{
    protected static string $resource = InsidenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getMaxContentWidth(): string
    {
        return 'full';
    }
}
