<?php

namespace App\Filament\Resources\InsidenResource\Forms;

use App\Models\Pasien;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Date;

class DetailPasien
{
    // public static function make()
    // {
    //     return [
    //         Hidden::make('activeTab')
    //             ->default('Pasien') // Tab default
    //             ->dehydrated()
    //             ->reactive(),

    //         Tabs::make('Tab Pasien')
    //             ->tabs([
    //                 Tabs\Tab::make('Pasien')
    //                     ->icon('heroicon-m-user')
    //                     ->schema([
    //                         Select::make('pasien_id')
    //                             ->label('Pasien')
    //                             ->relationship('pasien')
    //                             ->placeholder('Pilih Pasien')
    //                             ->searchable(['nm_pasien', 'no_rkm_medis'])
    //                             ->reactive()
    //                             // ->required()
    //                             // ->required(fn($get) => $get('activeTab') === 'Pasien')
    //                             ->createOptionModalHeading("Tambah Pasien Baru")
    //                             ->getOptionLabelFromRecordUsing(fn(Pasien $record) => "[ $record?->no_rkm_medis ] {$record?->nm_pasien}")
    //                             // ->createOptionForm([
    //                             //     Section::make('Tambah Pasien Baru')
    //                             //         ->description("Silahkan isi form berikut untuk menambahkan pasien baru")
    //                             //         ->schema([
    //                             //             ...\App\Filament\Resources\PasienResource\Forms\Detail::make(null),
    //                             //             ...\App\Filament\Resources\PasienResource\Forms\Kontak::make(null),
    //                             //         ]),
    //                             // ])
    //                             ->afterStateHydrated(function ($state, callable $set) {
    //                                 if (!$state) {
    //                                     $set('pasien.no_rkm_medis', null);
    //                                     $set('pasien.nm_pasien', null);
    //                                     $set('pasien.tgl_lahir', null);
    //                                     $set('pasien.jk', null);
    //                                     return;
    //                                 }

    //                                 $pasien = Pasien::where('no_rkm_medis', $state)->first();

    //                                 if ($pasien) {
    //                                     $set('pasien.no_rkm_medis', $pasien->no_rkm_medis);
    //                                     $set('pasien.nm_pasien', $pasien->nm_pasien);
    //                                     $set('pasien.tgl_lahir', \Carbon\Carbon::parse($pasien->tgl_lahir)->translatedFormat('l, d F Y'));
    //                                     $set('pasien.jk', $pasien->jk == "P" ? "Perempuan" : "Laki-laki");
    //                                 }
    //                             })
    //                             ->afterStateUpdated(function ($state, callable $set) {
    //                                 if (!$state) {
    //                                     $set('pasien.no_rkm_medis', null);
    //                                     $set('pasien.tgl_lahir', null);
    //                                     $set('pasien.jk', null);
    //                                     $set('pasien.nm_pasien', null);
    //                                     return;
    //                                 }

    //                                 $pasien = Pasien::where('no_rkm_medis', $state)->first();

    //                                 if ($pasien) {
    //                                     $set('pasien.no_rkm_medis', $pasien->no_rkm_medis);
    //                                     $set('pasien.nm_pasien', $pasien->nm_pasien);
    //                                     $set('pasien.tgl_lahir', \Carbon\Carbon::parse($pasien->tgl_lahir)->translatedFormat('l, d F Y'));
    //                                     $set('pasien.jk', $pasien->jk == "P" ? "Perempuan" : "Laki-laki");
    //                                 }
    //                             })
    //                             ->dehydrated(fn($get) => $get('activeTab') === 'Pasien'),

    //                         Grid::make(4)
    //                             ->schema([
    //                                 TextInput::make('pasien.no_rkm_medis')
    //                                     ->label('Rekam Medis')
    //                                     ->readOnly()
    //                                     // ->required()
    //                                     // ->required(fn($get) => $get('activeTab') === 'Pasien')
    //                                     ->dehydrated(fn($get) => $get('activeTab') === 'Pasien'),
    //                                 TextInput::make('pasien.nm_pasien')
    //                                     ->label('Nama')
    //                                     ->readOnly()
    //                                     // ->required()
    //                                     // ->required(fn($get) => $get('activeTab') === 'Pasien')
    //                                     ->dehydrated(fn($get) => $get('activeTab') === 'Pasien'),

    //                                 TextInput::make('pasien.tgl_lahir')
    //                                     ->label('Tanggal Lahir')
    //                                     ->readOnly()
    //                                     // ->required()
    //                                     // ->required(fn($get) => $get('activeTab') === 'Pasien')
    //                                     ->dehydrated(fn($get) => $get('activeTab') === 'Pasien'),

    //                                 TextInput::make('pasien.jk')
    //                                     ->label('Jenis Kelamin')
    //                                     ->readOnly()
    //                                     // ->required()
    //                                     // ->required(fn($get) => $get('activeTab') === 'Pasien')
    //                                     ->dehydrated(fn($get) => $get('activeTab') === 'Pasien'),
    //                             ]),
    //                     ]),

    //                 Tabs\Tab::make('Keluarga Pasien/Lainnya')
    //                     ->icon('heroicon-m-users')
    //                     ->schema([
    //                         Grid::make(3)
    //                             ->schema([
    //                                 Hidden::make('pasien.no_rkm_medis')->default(0),
    //                                 TextInput::make('pasien.nm_pasien')
    //                                     ->label('Nama')
    //                                     ->required(fn($get) => $get('activeTab') === 'Keluarga Pasien/Lainnya')
    //                                     ->dehydrated(fn($get) => $get('activeTab') === 'Keluarga Pasien/Lainnya'),
    //                                 TextInput::make('pasien.tgl_lahir')
    //                                     ->label('Tgl. Lahir')
    //                                     ->required(fn($get) => $get('activeTab') === 'Keluarga Pasien/Lainnya')
    //                                     ->dehydrated(fn($get) => $get('activeTab') === 'Keluarga Pasien/Lainnya'),

    //                                 TextInput::make('pasien.jk')
    //                                     ->label('Jenis Kelamin')
    //                                     ->required(fn($get) => $get('activeTab') === 'Keluarga Pasien/Lainnya')
    //                                     ->dehydrated(fn($get) => $get('activeTab') === 'Keluarga Pasien/Lainnya'),
    //                             ]),
    //                     ]),
    //             ])
    //             ->persistTabInQueryString(), // agar tab tetap aktif saat reload
    //     ];
    // }

    public static function make()
    {
        return [
            Hidden::make('activeTab')
                ->default('Pasien')
                ->dehydrated()
                ->reactive(),

            Tabs::make('Tab Pasien')
                ->tabs([
                    Tabs\Tab::make('Pasien')
                        ->icon('heroicon-m-user')
                        ->schema([
                            Select::make('pasien_id')
                                ->label('Pasien')
                                ->relationship('pasien')
                                ->placeholder('Pilih Pasien')
                                ->searchable(['nm_pasien', 'no_rkm_medis'])
                                ->reactive()
                                ->createOptionModalHeading("Tambah Pasien Baru")
                                ->getOptionLabelFromRecordUsing(fn(Pasien $record) => "[ $record?->no_rkm_medis ] {$record?->nm_pasien}")
                                ->afterStateUpdated(function ($state, callable $set) {
                                    if (!$state) {
                                        $set('no_rkm_medis', null);
                                        $set('nm_pasien', null);
                                        $set('tgl_lahir', null);
                                        $set('jk', null);
                                        return;
                                    }

                                    $pasien = Pasien::where('no_rkm_medis', $state)->first();
                                    if ($pasien) {
                                        $set('no_rkm_medis', $pasien->no_rkm_medis);
                                        $set('nm_pasien', $pasien->nm_pasien);
                                        $set('tgl_lahir', \Carbon\Carbon::parse($pasien->tgl_lahir)->translatedFormat('Y-m-d'));
                                        $set('jk', $pasien->jk === 'P' ? 'Perempuan' : 'Laki-laki');
                                    }
                                })
                                ->dehydrated(fn($get) => $get('activeTab') === 'Pasien'),

                            Grid::make(4)->schema([
                                TextInput::make('no_rkm_medis')
                                    ->label('Rekam Medis')
                                    ->readOnly()
                                    ->dehydrated(fn($get) => $get('activeTab') === 'Pasien'),
                                TextInput::make('nm_pasien')
                                    ->label('Nama')
                                    ->readOnly()
                                    ->dehydrated(fn($get) => $get('activeTab') === 'Pasien'),
                                TextInput::make('tgl_lahir')
                                    ->label('Tanggal Lahir')
                                    ->readOnly()
                                    ->dehydrated(fn($get) => $get('activeTab') === 'Pasien'),
                                TextInput::make('jk')
                                    ->label('Jenis Kelamin')
                                    ->readOnly()
                                    ->dehydrated(fn($get) => $get('activeTab') === 'Pasien'),
                            ]),
                        ]),

                    Tabs\Tab::make('Keluarga Pasien/Lainnya')
                        ->icon('heroicon-m-users')
                        ->schema([
                            Grid::make(3)->schema([
                                Hidden::make('no_rkm_medis')->default(0),
                                TextInput::make('nm_pasien')
                                    ->label('Nama')
                                    ->required(fn($get) => $get('activeTab') === 'Keluarga Pasien/Lainnya')
                                    ->dehydrated(fn($get) => $get('activeTab') === 'Keluarga Pasien/Lainnya'),
                                DatePicker::make('tgl_lahir')
                                    ->label('Tgl. Lahir')
                                    ->required(fn($get) => $get('activeTab') === 'Keluarga Pasien/Lainnya')
                                    ->dehydrated(fn($get) => $get('activeTab') === 'Keluarga Pasien/Lainnya'),
                                Select::make('jk')
                                    ->label('Jenis Kelamin')
                                    ->options([
                                        'L' => 'Laki-laki',
                                        'P' => 'Perempuan',
                                    ])
                                    ->required(fn($get) => $get('activeTab') === 'Keluarga Pasien/Lainnya')
                                    ->dehydrated(fn($get) => $get('activeTab') === 'Keluarga Pasien/Lainnya'),
                            ]),
                        ]),
                ])
                ->persistTabInQueryString(),
        ];
    }
}
