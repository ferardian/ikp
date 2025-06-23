<?php

namespace App\Filament\Resources\InvestigasiSederhanaResource\Pages;

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

        $formData = $this->form->getState();
        $insidenId = $formData['insiden_id'];
        $insiden = Insiden::find($insidenId);


        if ($insiden) {
            $insiden->created_sign = $formData['created_sign'];
            $insiden->received_sign = $formData['received_sign'];
            $insiden->created_by = $formData['created_by'] ?? auth()->id();
            $insiden->received_by = $formData['received_by'] ?? auth()->id();
            $insiden->received_at = $formData['received_at'] ?? now();
            $insiden->save();
        }
    }
}
