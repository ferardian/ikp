<?php

namespace App\Filament\Resources\PasienResource\Forms;

use App\Models\Pasien;
use App\Models\Pasien2;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;

class Detail
{
    public static function make(Form|null $form): array
    {
        return [

            Select::make('master_pasien')
                ->label(
                    'Master Pasien'
                )
                ->searchable(['no_rkm_medis', 'nm_pasien'])
                ->options(Pasien2::take(100)->pluck('nm_pasien', 'no_rkm_medis'))
                ->getOptionLabelFromRecordUsing(fn(Pasien2 $record) => "[ $record->no_rkm_medis ] {$record->nm_pasien}"),

            \Filament\Forms\Components\TextInput::make('nama')
                ->label('Nama Lengkap')
                ->required()
                ->placeholder('Masukkan nama lengkap pasien')
                ->maxLength(255),

            \Filament\Forms\Components\Grid::make(2) // Grid 2 kolom
                ->schema([
                    \Filament\Forms\Components\TextInput::make('nik')
                        ->label('NIK')
                        ->placeholder('Masukkan NIK pasien')
                        ->unique(ignoreRecord: true)
                        ->length(16) // Harus 16 karakter
                        ->inputMode('numeric') // Mengaktifkan keyboard angka di mobile
                        ->live() // Menjalankan validasi secara real-time saat diketik
                        ->afterStateUpdated(
                            fn($state, callable $set) =>
                            $set('nik', preg_replace('/\D/', '', $state)) // Hapus karakter selain angka
                        )
                        ->rule('digits:16') // Validasi agar panjang harus 16 angka
                        ->validationMessages([
                            'digits' => 'NIK harus terdiri dari 16 angka.',
                        ]),


                    \Filament\Forms\Components\TextInput::make('no_rekam_medis')
                        ->label('No. Rekam Medis')
                        ->unique(ignoreRecord: true)
                        ->disabled(fn($record) => $form?->getOperation() === 'edit' && $record->exists)
                        ->required($form?->getOperation() === 'create')
                        // auto value last record + 1, if record not exist make random 6 digit number
                        ->default(fn($record) => $form?->getOperation() === 'create' ? (Pasien::max('no_rekam_medis') + 1 ?? rand(10000000, 99999999)) : $record?->no_rekam_medis)
                        ->placeholder('Masukkan nomor rekam medis pasien')
                        ->maxLength(20),
                ]),

            \Filament\Forms\Components\Select::make('penanggung_biaya_id')
                ->label('Penanggung Biaya')
                ->options(\App\Models\PenanggungBiaya::pluck('jenis_penanggung', 'id'))
                ->searchable()
                ->placeholder('Pilih Penanggung Biaya')
                ->required(),

            \Filament\Forms\Components\Select::make('jenis_kelamin')
                ->label('Jenis Kelamin')
                ->options([
                    'L' => 'Laki-laki',
                    'P' => 'Perempuan',
                ])
                ->required(),

            \Filament\Forms\Components\Grid::make(2) // Grid 2 kolom
                ->schema([
                    \Filament\Forms\Components\TextInput::make('tempat_lahir')
                        ->label('Tempat Lahir')
                        ->required()
                        ->placeholder('Jakarta, Surabaya, dll')
                        ->maxLength(255),

                    \Filament\Forms\Components\DatePicker::make('tanggal_lahir')
                        ->label('Tanggal Lahir')
                        ->required()
                        ->placeholder('Pilih tanggal lahir pasien')
                        ->native(false),
                ]),
        ];
    }
}
