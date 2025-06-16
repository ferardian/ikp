<?php

namespace App\Filament\Resources\InsidenResource\Forms;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class InvestigasiSederhanaInsiden
{
    public static function make(): array
    {
        return [
            Group::make()
                ->relationship('investigasi_sederhana')
                ->schema([
                    // select karyawan from table users
                    Select::make('kepala_id')
                        ->label('Manager / Kepala Bagian / Kepala Unit')
                        ->options(\App\Models\User::all()->pluck('name', 'id'))
                        ->searchable()
                        ->required(),

                    // penyebab insiden langsung
                    TextInput::make('penyebab_insiden')
                        ->label('Penyebab Insiden Langsung')
                        ->placeholder('penyebab langsung insiden')
                        ->required(),

                    // penyebab yang melatarbelakangi insiden
                    TextInput::make('penyebab_melatarbelakangi')
                        ->label('Penyebab yang Melatarbelakangi Insiden')
                        ->placeholder('penyebab melatarbelakangi insiden')
                        ->required(),

                    Fieldset::make('Rekomendasi Investigasi')
                        ->columns(1)
                        ->schema([
                            RichEditor::make('rekomendasi')
                                ->label('Rekomendasi')
                                ->placeholder('rekomendasi')
                                ->required(),

                            Grid::make(2)
                                ->schema([
                                    // select karyawan from table users
                                    Select::make('penanggung_jawab_rekomendasi')
                                        ->label('Penanggung Jawab')
                                        ->options(\App\Models\User::all()->pluck('name', 'id'))
                                        ->searchable()
                                        ->required(),

                                    // tanggal
                                    DatePicker::make('tanggal_rekomendasi')
                                        ->label('Tanggal Rekomendasi')
                                        ->native(false)
                                        ->required(),
                                ])
                        ]),

                    Fieldset::make('Tindakan Sesuai Rekomendasi')
                        ->columns(1)
                        ->schema([
                            RichEditor::make('tindakan_rekomendasi')
                                ->label('Tindakan')
                                ->placeholder('tindakan yang akan dilakukan')
                                ->required(),

                            Grid::make(2)
                                ->schema([
                                    // select karyawan from table users
                                    Select::make('penanggung_jawab_tindakan')
                                        ->label('Penanggung Jawab')
                                        ->options(\App\Models\User::all()->pluck('name', 'id'))
                                        ->searchable()
                                        ->required(),

                                    // tanggal
                                    DatePicker::make('tanggal_tindakan')
                                        ->label('Tanggal Tindakan')
                                        ->native(false)
                                        ->required(),
                                ])
                        ]),

                    Grid::make(2)
                        ->schema([
                            // tanggal mulai investigasi
                            DatePicker::make('tanggal_mulai')
                                ->label('Tanggal Mulai Investigasi')
                                ->native(false)
                                ->required(),

                            // tanggal selesai investigasi
                            DatePicker::make('tanggal_selesai')
                                ->label('Tanggal Selesai Investigasi')
                                ->native(false)
                                ->required(),
                        ]),

                    Grid::make(2)
                        ->schema([
                            Radio::make('lengkap')
                                ->label('Investigasi Lengkap')
                                ->options([
                                    'lengkap' => 'Lengkap',
                                    'belum' => 'Tidak Lengkap',
                                ])
                                ->inline()
                                ->inlineLabel(false)
                                ->required(),

                            Radio::make('investigasi_lanjut')
                                ->label('Diperlukan Investigasi Lebih Lanjut')
                                ->options([
                                    'ya' => 'Ya, Perlu !',
                                    'tidak' => 'Tidak Perlu',
                                ])
                                ->inline()
                                ->inlineLabel(false)
                                ->required(),
                        ])
                ]),
        ];
    }
}
