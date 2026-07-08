<?php

namespace App\Filament\Resources\RootCauseAnalysisResource\Pages;

use App\Filament\Resources\RootCauseAnalysisResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListRootCauseAnalyses extends ListRecords
{
    protected static string $resource = RootCauseAnalysisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getMaxContentWidth(): string
    {
        return 'full';
    }
}
