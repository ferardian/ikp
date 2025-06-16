<?php

namespace App\Filament\Resources\RootCauseAnalysisResource\Forms;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Coolsam\SignaturePad\Forms\Components\Fields\SignaturePad;

class RekomendasiDanRencanaTindakan
{
    public static function make(): array
    {
        return [
            Repeater::make('rekomendasi')
                ->columnSpanFull()
                ->columns(1)
                ->collapsible()
                ->reorderable(false)
                ->addActionLabel("Tambah")
                ->defaultItems(1)
                ->minItems(1)
                ->itemLabel(fn(array $state): ?string => $state['akar_masalah'] ? 'Akar Masalah : ' . $state['akar_masalah'] : 'Akar Masalah')
                ->schema([
                    Grid::make(2)
                        ->schema([
                            Textarea::make('akar_masalah')
                                ->label("Akar Masalah")
                                ->placeholder("akar masalah")
                                ->required(),

                            Textarea::make('rekomendasi')
                                ->label("Rekomendasi")
                                ->placeholder("Rekomendasi")
                                ->required(),

                            TextInput::make('tim')
                                ->label("TK. Rekomendasi")
                                ->placeholder("individu/tim/unit/direktorat RS")
                                ->required(),

                            // select pegawai
                            Select::make('penanggung_jawab')
                                ->label("Penanggung Jawab")
                                ->placeholder("Penanggung Jawab")
                                ->options(\App\Models\User::all()->pluck('name', 'id'))
                                ->searchable()
                                ->required(),
                        ]),

                    RichEditor::make('sumber_daya')
                        ->label("Sumber Daya Yang dibutuhkan")
                        ->placeholder("sumber daya")
                        ->required(),

                    Fieldset::make("fieldset-penyelesaian")
                        ->label("Penyelesaian")
                        ->schema([
                            Grid::make(2)
                                ->schema([
                                    Textarea::make('bukti')
                                        ->label("Bukti")
                                        ->placeholder("bukti")
                                        ->rows(5)
                                        ->required(),

                                    SignaturePad::make('signature')
                                        ->label('Tanda Tangan Pembuat Laporan')
                                        ->backgroundColor('white') // Set the background color in case you want to download to jpeg
                                        ->penColor('black') // Set the pen color
                                        ->strokeMinDistance(2.0) // set the minimum stroke distance (the default works fine)
                                        ->strokeMaxWidth(2.5) // set the max width of the pen stroke
                                        ->strokeMinWidth(1.0) // set the minimum width of the pen stroke
                                        ->strokeDotSize(2.0) // set the stroke dot size.
                                        ->hideDownloadButtons() // In case you don't want to show the download buttons on the pad, you can hide them by setting this option.
                                        ->displayTemplate(false)
                                        ->view('vendor.signature-pad.signature-pad')
                                        ->required(),

                                    //oleh
                                    Select::make('oleh')
                                        ->label("Diselesaikan Oleh")
                                        ->placeholder("diselesaikan oleh")
                                        ->options(\App\Models\User::all()->pluck('name', 'id'))
                                        ->searchable()
                                        ->required(),

                                    // tanggal penelesian
                                    DatePicker::make('tanggal')
                                        ->label("Tanggal Penyelesaian")
                                        ->placeholder("tanggal penyelesaian")
                                        ->required()
                                        ->native(false)
                                        ->default(now()->format('Y-m-d')),
                                ]),
                        ]),
                ])
                ->defaultItems(1)
                ->columns(1),
        ];
    }
}
