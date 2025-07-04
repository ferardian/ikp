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
                                        $set('nm_pasien', null);
                                        $set('tgl_lahir', null);
                                        $set('jk', null);
                                        return;
                                    }

                                    $pasien = Pasien::where('no_rkm_medis', $state)->first();
                                    if ($pasien) {
                                        $set('nm_pasien', $pasien->nm_pasien);
                                        $set('tgl_lahir', \Carbon\Carbon::parse($pasien->tgl_lahir)->translatedFormat('Y-m-d'));
                                        $set('jk', $pasien->jk === 'P' ? 'Perempuan' : 'Laki-laki');
                                    }
                                })
                                ->dehydrated(fn($get) => $get('activeTab') === 'Pasien'),

                            Grid::make(3)->schema([

                                TextInput::make('nm_pasien')
                                    ->label('Nama')
                                    ->readOnly()
                                    ->dehydrated(fn($get) => $get('activeTab') === 'Pasien'),
                                DatePicker::make('tgl_lahir')
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
