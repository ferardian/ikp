<?php

namespace App\Filament\Resources\InsidenResource\Pages;

use App\Filament\Resources\InsidenResource;
use App\Helpers\AutoGradingHelper;
use Filament\Actions;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Exceptions\Halt;
use Illuminate\Support\Str;

class CreateInsiden extends CreateRecord
{
    use CreateRecord\Concerns\HasWizard;

    protected static string $resource = InsidenResource::class;

    protected function getSteps(): array
    {
        return [
            Step::make('pasien')
                ->label('Pasien')
                ->schema(\App\Filament\Resources\InsidenResource\Forms\DetailPasien::make()),

            Step::make('detail-insiden')
                ->label('Detail Insiden')
                ->schema(\App\Filament\Resources\InsidenResource\Forms\DetailInsiden::make())
                ->afterValidation(fn($state, $set, $get, $livewire) => InsidenResource::afterValidationStepPasien($state, $set, $get, $livewire)),

            Step::make('tindakan-pasca-insiden')
                ->label('Tindakan dan Grading')
                ->schema([
                    ...\App\Filament\Resources\InsidenResource\Forms\TindakanInsiden::make(),
                    ...\App\Filament\Resources\InsidenResource\Forms\GradingInsiden::make()
                ])
                ->afterValidation(fn($state) => InsidenResource::afterValidationStepTindakanInsiden($state)),

            // Step::make('investigasi-sederhana')
            //     ->label('Investigasi Sederhana')
            //     ->schema(\App\Filament\Resources\InsidenResource\Forms\InvestigasiSederhanaInsiden::make()),

            // Step::make('validasi-dan-kirim-laporan')
            //     ->label('Validasi dan Kirim Laporan')
            //     ->schema(\App\Filament\Resources\InsidenResource\Forms\ValidasiInsiden::make(null))
        ];
    }

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     dd($data);
    // }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
