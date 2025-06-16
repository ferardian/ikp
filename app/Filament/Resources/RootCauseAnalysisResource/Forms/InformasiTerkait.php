<?php

namespace App\Filament\Resources\RootCauseAnalysisResource\Forms;

use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class InformasiTerkait
{
    /*
     * Form Schema untuk Informasi Terkait
     * Setiap informasi yang ditambahkan bisa ditambahkan catatan sebagai pendukung
     *
     * @return array
     */
    public static function make(): array
    {
        return [
            Fieldset::make("Data Primer")
                ->columnSpanFull()
                ->schema([
                    Repeater::make('data_primer')
                        ->label('observasi, wawancar, dll')
                        ->columnSpanFull()
                        ->itemLabel(fn(array $state): ?string => $state['data'] ? $state['data'] : 'Data Primer')
                        ->schema([
                            TextInput::make('data')
                                ->label('Data Primer')
                                ->placeholder('observasi, wawancar, dll')
                                ->required(),

                            Textarea::make('catatan')
                                ->label('Catatan')
                                ->rows(3)
                                ->autosize()
                                ->placeholder('Catatan untuk observasi, wawancara, dll')
                                ->maxLength(255)
                        ])
                        ->defaultItems(2)
                        ->columns(2)
                        ->collapsible()
                        ->collapsed()
                        ->addActionLabel('Tambah Data Primer'),
                ]),

            Fieldset::make("Data Sekunder")
                ->columnSpanFull()
                ->schema([
                    Repeater::make('data_sekunder')
                        ->label('spo, berkas, rekam medis, dll')
                        ->columnSpanFull()
                        ->itemLabel(fn(array $state): ?string => $state['data'] ? $state['data'] : 'Data Sekunder')
                        ->schema([
                            TextInput::make('data')
                                ->label('Data Sekunder')
                                ->placeholder('spo, berkas rekam medis, dll')
                                ->required(),

                            Textarea::make('catatan')
                                ->label('Catatan')
                                ->rows(3)
                                ->autosize()
                                ->placeholder('Catatan untuk spo, berkas rekam medis, dll')
                                ->maxLength(255),
                        ])
                        ->defaultItems(2)
                        ->columns(2)
                        ->collapsible()
                        ->collapsed()
                        ->addActionLabel('Tambah Data Sekunder'),
                ]),

            Fieldset::make("Data Lainnya")
                ->columnSpanFull()
                ->schema([
                    Repeater::make('data_lainnya')
                        ->label('rekaman cctv, dll')
                        ->columnSpanFull()
                        ->itemLabel(fn(array $state): ?string => $state['data'] ? $state['data'] : 'Data Lainnya')
                        ->schema([
                            TextInput::make('data')
                                ->label('Data Lainnya')
                                ->placeholder('rekaman cctv, dll')
                                ->required(),

                            Textarea::make('catatan')
                                ->label('Catatan')
                                ->rows(3)
                                ->autosize()
                                ->placeholder('Catatan untuk rekaman cctv, dll')
                                ->maxLength(255)
                        ])
                        ->defaultItems(2)
                        ->columns(2)
                        ->collapsible()
                        ->collapsed()
                        ->addActionLabel('Tambah Data Lainnya'),
                ]),
        ];
    }
}
