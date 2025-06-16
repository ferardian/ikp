<?php

namespace App\Filament\Resources\InsidenResource\Forms;

use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;

class TindakanInsiden
{
    public static function make()
    {
        return [
            Select::make('status_pelapor')
                ->label("Status Pelapor")
                ->required()
                ->options([
                    "Penemu Insiden" => "Penemu Insiden",
                    "Terlibat Langsung" => "Terlibat Langsung"
                ])
                ->placeholder("Pilih status pelapor"),

            Fieldset::make('Tindakan Pasca Insiden')
                ->relationship('tindakan')
                ->columns(1)
                ->schema([
                    RichEditor::make("content")
                        ->label("Tindakan")
                        ->required()
                        ->placeholder("Tindakan yang dilakukan"),

                    Radio::make('oleh')
                        ->label('Tindakan dilakukan oleh')
                        ->options([
                            'dokter' => 'Dokter',
                            'perawat' => 'Perawat',
                            'tim' => 'Tim',
                            'petugas' => 'Petugas'
                        ])
                        ->columns(2)
                        ->required()
                        ->live(), // Menjadikan radio button ini reactive

                    TextInput::make('detail')
                        ->label('Detail Tim / Petugas')
                        ->placeholder('John Doe, Jane Doe, etc.')
                        ->reactive()
                        ->required(fn($get) => in_array($get('oleh'), ['tim', 'petugas']))
                        ->hidden(fn($get) => !in_array($get('oleh'), ['tim', 'petugas'])), // Menggunakan 'oleh' langsung tanpa 'tindakan.oleh'
                ]),
        ];
    }
}
