<?php

namespace App\Filament\Resources\InsidenResource\Forms;

use App\Livewire\AutoGrading2;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Livewire;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

class GradingInsiden
{
    public static function make(Form|null $form = null): array
    {
        return [
            // View::make('livewire.auto-grading-view'),
            Livewire::make(AutoGrading2::class, function ($state, callable $set) {
                return [
                    'jenis_insiden_id' => $state['jenis_insiden_id'],
                    'unit_id' => $state['unit_id'],
                    'dampak_insiden' => $state['dampak_insiden'],
                ];
            }),

            Fieldset::make('Grading Risiko')
                ->relationship('grading')
                ->columns(1)
                ->schema([
                    Radio::make('grading_risiko')
                        ->label('Grading Risiko')
                        ->options([
                            'Biru' => 'Biru',
                            'Hijau' => 'Hijau',
                            'Kuning' => 'Kuning',
                            'Merah' => 'Merah',
                        ])
                        ->inline()
                        ->view('filament.inputs.grading-radio')
                        // custom required validation message
                        ->validationMessages([
                            'required' => ':attribute harus dipilih',
                        ])
                        ->required(),

                    Hidden::make('created_by')
                        ->dehydrated()
                        ->formatStateUsing(fn($state) => $state ?? auth()->id()),
                ]),

            // input hidden
            TextInput::make('auto_grading_color')
                ->reactive()
                ->hidden()
                ->dehydrated()
                ->readOnly(),
        ];
    }
}
