<?php

namespace App\Filament\Resources\RootCauseAnalysisResource\Forms;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;

class DetailInsidenRCA
{
    /**
     * Form schema untuk Detail Insiden
     * Detail insiden ini adalah insiden yang akan dibuatkan RCA-nya.
     *
     * @return array
     */
    public static function make(): array
    {
        return [
            TextInput::make('insiden')
                ->label('Insiden')
                ->disabled()
                ->required(),

            TextInput::make('insiden_id')
                ->readonly()
                ->required()
                ->hidden('insiden_id'),

            Grid::make(4)
                ->schema([
                    DatePicker::make('tanggal_insiden')
                        ->label('Tanggal Insiden')
                        ->disabled()
                        ->required(),

                    TimePicker::make('waktu_insiden')
                        ->label('Waktu Insiden')
                        ->disabled(),

                    DatePicker::make('tgl_pasien_masuk')
                        ->label('Tanggal Pasien Masuk')
                        ->disabled(),

                    TextInput::make('dampak')
                        ->label('Dampak Insiden')
                        ->disabled()
                ]),
        ];
    }
}
