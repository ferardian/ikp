<?php

namespace App\Filament\Resources\InsidenResource\Forms;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\TimePicker;

class DetailInsiden
{
    public static function make()
    {
        return [
            DatePicker::make('tgl_pasien_masuk')
                ->label('Tanggal Masuk Pasien')
                ->required(),

            Grid::make(2)
                ->schema([
                    DatePicker::make('tanggal_insiden')
                        ->label('Tanggal Insiden')
                        ->required(),

                    TimePicker::make('waktu_insiden')
                        ->label('Waktu Insiden')
                        ->required(),
                ]),

            TextInput::make('insiden')
                ->label('Insiden Yang Terjadi')
                ->placeholder('Contoh : Pasien jatuh saat berjalan menuju kamar mandi')
                ->required(),

            Textarea::make('kronologi')
                ->label('Kronologi Insiden')
                ->placeholder('Jelaskan kronologi insiden yang terjadi')
                ->required(),

            Radio::make('jenis_insiden_id')
                ->label('Jenis Insiden')
                ->inline()
                ->inlineLabel(false)
                ->options(fn() => \App\Models\JenisInsiden::pluck('alias', 'id')->toArray())
                ->required(),

            Radio::make('jenis_pelapor')
                ->label('Orang Pertama Yang Melaporkan')
                ->inline()
                ->inlineLabel(false)
                ->options([
                    "karyawan" => "Karyawan (Dokter, Perawat, dll)",
                    "pengunjung" => "Pengunjung",
                    "pasien" => "Pasien",
                    "keluarga" => "Keluarga / Pendamping Pasien",
                    "lainnya" => "Lainnya"
                ])
                ->required(),

            Radio::make('korban_insiden')
                ->label('Insiden terjadi pada')
                ->inline()
                ->inlineLabel(false)
                ->options([
                    "pasien" => "Pasien",
                    "lainnya" => "Lainnya"
                ])
                ->required(),

            Radio::make('layanan_insiden')
                ->label('Insiden Menyangkut Pasien')
                ->inline()
                ->inlineLabel(false)
                ->options([
                    "ranap" => "Rawat Inap",
                    "ralan" => "Rawat Jalan",
                    "ugd" => "UGD / IGD",
                    "lainnya" => "Lainnya"
                ])
                ->required(),

            CheckboxList::make('kasus_insiden')
                ->label('Insiden terjadi pada pasien ( sesuai kasus penyakit / spesialisasi )')
                ->columns(2)
                ->options([
                    'Penyakit-Dalam-dan-Subspesialiasinya' => 'Penyakit Dalam dan Subspesialiasinya',
                    'Anak-dan-Subspesialiasinya' => 'Anak dan Subspesialiasinya',
                    'Bedah-dan-Subspesialiasinya' => 'Bedah dan Subspesialiasinya',
                    'Obstetri-Gynekologi-dan-Subspesialiasinya' => 'Obstetri Gynekologi dan Subspesialiasinya',
                    'THT-dan-Subspesialiasinya' => 'THT dan Subspesialiasinya',
                    'Mata-dan-Subspesialiasinya' => 'Mata dan Subspesialiasinya',
                    'Saraf-dan-Subspesialiasinya' => 'Saraf dan Subspesialiasinya',
                    'Anastesi-dan-Subspesialiasinya' => 'Anastesi dan Subspesialiasinya',
                    'Kulit-Kelamin-dan-Subspesialiasinya' => 'Kulit & Kelamin dan Subspesialiasinya',
                    'Jantung-dan-Subspesialiasinya' => 'Jantung dan Subspesialiasinya',
                    'Paru-dan-Subspesialiasinya' => 'Paru dan Subspesialiasinya',
                    'Jiwa-dan-Subspesialiasinya' => 'Jiwa dan Subspesialiasinya',
                    'Orthopedi-dan-Subspesialiasinya' => 'Orthopedi dan Subspesialiasinya'
                ])->afterStateHydrated(function ($component, $state, $record, $set) {
                    if ($state && is_string($state)) {
                        $decodedState = json_decode($state);
                        // Make sure json_decode worked and returned an array
                        if (is_array($decodedState)) {
                            $processedState = array_map(fn($value) => str_replace(' ', '-', $value), $decodedState);
                            $set($component->getName(), $processedState);
                        }
                    } else if ($state && is_array($state)) {
                        $set($component->getName(), $state);
                    } else {
                        $set($component->getName(), []);
                    }
                }),

            Grid::make(2)
                ->schema([
                    TextInput::make('tempat_kejadian')
                        ->label("Tempat Kejadian")
                        ->placeholder("Contoh : Ruang Perawatan, Ruang Tindakan, dll")
                        ->required(),

                    Select::make('unit_id')
                        ->label('Unit / Departemen terkait yang menyebabkan insiden')
                        ->relationship('unit', 'nama_unit')
                        ->placeholder('Pilih Unit')
                        ->searchable()->preload()
                        // ->default(fn () => auth()->user()?->detail?->unit_id)
                        ->disabled(fn() => auth()->user()->can('view_only_unit_insiden'))
                        ->required(),
                ]),

            Radio::make('dampak_insiden')
                ->label('Dampak Insiden Terhadap Pasien')
                ->inline()
                ->inlineLabel(false)
                ->options([
                    "katastropik" => "Kematian",
                    "mayor" => "Cedera Irriversibel / Berat",
                    "moderat" => "Cedera Reversibel / Sedang",
                    "minor" => "Cedera Ringan",
                    "tidak signifikan" => "Tidak Cedera",
                ])
                ->required(),

            Hidden::make('created_by')
                ->default(auth()->id())
                ->dehydrated(),
        ];
    }
}
