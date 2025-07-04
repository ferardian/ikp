<?php

namespace App\Filament\Resources\InvestigasiSederhanaResource\Pages;

use App\Action\UpdateInsidenAfterInvestigation;
use App\Models\Insiden;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\InvestigasiSederhanaResource;

class CreateInvestigasiSederhana extends CreateRecord
{
    protected static string $resource = InvestigasiSederhanaResource::class;
    protected function afterSave()
    {
        UpdateInsidenAfterInvestigation::handle(new Insiden(), $this->form->getState());
    }
}
