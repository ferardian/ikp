<?php

namespace App\Filament\Resources\InsidenResource\Forms;

use App\Models\Pasien;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;

class DetailPasien
{
    public static function make()
    {
        return [
            Select::make('pasien_id')
                ->label('Pasien')
                ->relationship('pasien', 'nama')
                ->placeholder('Pilih Pasien')
                ->searchable(['nama', 'no_rekam_medis'])
                ->reactive()
                ->required()
                ->createOptionModalHeading("Tambah Pasien Baru")
                ->getOptionLabelFromRecordUsing(fn (Pasien $record) => "[ $record->no_rekam_medis ] {$record->nama}")
                ->createOptionForm([
                    Section::make('Tambah Pasien Baru')
                        ->description("Silahkan ini form berikut untuk menambahkan pasien baru")
                        ->schema([
                            ...\App\Filament\Resources\PasienResource\Forms\Detail::make(null),
                            ...\App\Filament\Resources\PasienResource\Forms\Kontak::make(null),
                        ])
                ])
                ->afterStateHydrated(function ($state, callable $set) {
                    if (!$state) {
                        $set('pasien.no_rekam_medis', null);
                        $set('pasien.tanggal_lahir', null);
                        $set('pasien.jenis_kelamin', null);
                        return;
                    }

                    $pasien = Pasien::find($state);

                    if ($pasien) {
                        $set('pasien.no_rekam_medis', $pasien->no_rekam_medis);
                        $set('pasien.tanggal_lahir', \Carbon\Carbon::parse($pasien->tanggal_lahir)->translatedFormat('l, d F Y'));
                        $set('pasien.jenis_kelamin', $pasien->jenis_kelamin == "P" ? "Perempuan" : "Laki-laki");
                    }
                })
                ->afterStateUpdated(function ($state, callable $set) {
                    if (!$state) {
                        $set('pasien.no_rekam_medis', null);
                        $set('pasien.tanggal_lahir', null);
                        $set('pasien.jenis_kelamin', null);
                        return;
                    }

                    $pasien = Pasien::find($state);

                    if ($pasien) {
                        $set('pasien.no_rekam_medis', $pasien->no_rekam_medis);
                        $set('pasien.tanggal_lahir', \Carbon\Carbon::parse($pasien->tanggal_lahir)->translatedFormat('l, d F Y'));
                        $set('pasien.jenis_kelamin', $pasien->jenis_kelamin == "P" ? "Perempuan" : "Laki-laki");
                    }
                }),

            Grid::make(3)
                ->schema([
                    TextInput::make('pasien.no_rekam_medis')
                        ->label('Rekam Medis')
                        ->readOnly()
                        ->required()
                        ->dehydrated(),

                    TextInput::make('pasien.tanggal_lahir')
                        ->label('Tanggal Lahir')
                        ->readOnly()
                        ->required()
                        ->dehydrated(),

                    TextInput::make('pasien.jenis_kelamin')
                        ->label('Jenis Kelamin')
                        ->readOnly()
                        ->required()
                        ->dehydrated(),
                ])
        ];
    }
}
