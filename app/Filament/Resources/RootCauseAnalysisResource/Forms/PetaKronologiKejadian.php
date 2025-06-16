<?php

namespace App\Filament\Resources\RootCauseAnalysisResource\Forms;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;

class PetaKronologiKejadian
{
   /**
    * Form schema untuk Peta Kronologi Kejadian
    *
    * @return array
    */
    public static function make(): array
    {
        return [
            Repeater::make('kronologi_waktu_kejadian')
                ->columnSpanFull()
                ->columns(1)
                ->collapsible()
                ->addActionLabel("Tambah")
                ->defaultItems(1)
                ->minItems(1)
                ->itemLabel(fn (array $state) : ?string => $state['waktu-kejadian'] ?? 'Peta Kronologi Kejadian')
                ->schema([
                    DateTimePicker::make('waktu-kejadian')
                        ->label("Waktu Kejadian")
                        ->placeholder("Detail waktu kejadian")
                        ->native(false)
                        ->seconds(false)
                        ->required(),

                    Grid::make(2)
                        ->schema([
                            Textarea::make('kejadian')
                                ->label("Kronologi Kejadian")
                                ->placeholder("Detail kronologi kejadian")
                                ->required(),

                            Textarea::make('informasi-tambahan')
                                ->label("Informasi Tambahan")
                                ->placeholder("Informasi tambahan untuk menunjang")
                                ->required(),

                            Textarea::make('good-practice')
                                ->label("Good Practice")
                                ->placeholder("Good practice yang dilakukan")
                                ->required(),

                            Textarea::make('masalah-pelayanan')
                                ->label("Masalah Pelayanan")
                                ->placeholder("Masalah pelayanan yang terjadi")
                                ->required(),
                        ])
                ]),
        ];
    }
}
