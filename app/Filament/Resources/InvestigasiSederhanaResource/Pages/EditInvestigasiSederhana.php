<?php

namespace App\Filament\Resources\InvestigasiSederhanaResource\Pages;

use App\Action\UpdateInsidenAfterInvestigation;
use Filament\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\InvestigasiSederhanaResource;
use App\Models\Insiden;

class EditInvestigasiSederhana extends EditRecord
{
    protected static string $resource = InvestigasiSederhanaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        UpdateInsidenAfterInvestigation::handle(new Insiden, $this->form->getState());
    }

}
