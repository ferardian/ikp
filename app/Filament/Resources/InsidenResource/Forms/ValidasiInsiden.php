<?php

namespace App\Filament\Resources\InsidenResource\Forms;

use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use Coolsam\SignaturePad\Forms\Components\Fields\SignaturePad;

class ValidasiInsiden
{
    public static function make(Form|null $form): array
    {
        return [
            ...($form?->getOperation() != 'edit' ? self::summaryInsiden() : []),
            Grid::make(2)
                ->schema([
                    SignaturePad::make('created_sign')
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

                    SignaturePad::make('received_sign')
                        ->label('Tanda Tangan Penerima laporan')
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


                    // PEMBUAT LAPORAN
                    Hidden::make('created_by')
                        ->dehydrated()
                        ->formatStateUsing(fn($state) => $state ?? auth()->id()),

                    // PENERIMA LAPORAN
                    Hidden::make('received_by')
                        ->dehydrated()
                        ->formatStateUsing(fn($state) => $state ?? auth()->id()),

                    Hidden::make('received_at')
                        ->dehydrated()
                        ->formatStateUsing(fn($state) => $state ?? now()->toDateTimeString()),
                ])
        ];
    }

    protected static function summaryInsiden(): array
    {
        return [
            Section::make('Pasien')
                ->description('Pasien yang terlibat')
                ->columns(2)
                ->schema([
                    Placeholder::make('placeholder_nama_pasien')
                        ->label('Pasien')
                        ->content(function (Get $get) {
                            $idPasien = $get('pasien_id');
                            $pasien = \App\Models\Pasien::where('id', $idPasien)->first();

                            return $pasien?->nama;
                        }),

                    Placeholder::make('placeholder_no_rekam_medis')
                        ->label('No Rekam Medis')
                        ->content(fn(Get $get): string|null => $get('pasien.no_rekam_medis')),

                    // tanggal lahir dan jenis kelamin
                    Placeholder::make('placeholder_tanggal_lahir')
                        ->label('Tanggal Lahir')
                        ->content(fn(Get $get): string|null => $get('pasien.tanggal_lahir')),

                    Placeholder::make('placeholder_jenis_kelamin')
                        ->label('Jenis Kelamin')
                        ->content(fn(Get $get): string|null => $get('pasien.jenis_kelamin')),
                ]),

            Section::make('Insiden')
                ->description('Insiden yang terjadi')
                ->schema([
                    Grid::make(3)->schema([
                        // tanggal pasien masuk
                        Placeholder::make('placeholder_tgl_pasien_masuk')
                            ->label('Tanggal Pasien Masuk')
                            ->content(fn(Get $get): string|null => $get('tgl_pasien_masuk')),

                        // tanggal insiden
                        Placeholder::make('placeholder_tanggal_insiden')
                            ->label('Tanggal Insiden')
                            ->content(fn(Get $get): string|null => $get('tanggal_insiden')),

                        // waktu insiden
                        Placeholder::make('placeholder_waktu_insiden')
                            ->label('Waktu Insiden')
                            ->content(fn(Get $get): string|null => $get('waktu_insiden')),
                    ]),

                    // insiden
                    Placeholder::make('placeholder_insiden')
                        ->label('Insiden')
                        ->content(fn(Get $get): string|null => $get('insiden')),

                    // kronologi
                    Placeholder::make('placeholder_kronologi')
                        ->label('Kronologi')
                        ->content(fn(Get $get): string|null => $get('kronologi')),

                    Grid::make(2)->schema([
                        // jenis insiden
                        Placeholder::make('placeholder_jenis_insiden')
                            ->label('Jenis Insiden')
                            ->content(function (Get $get) {
                                $idJenisInsiden = $get('jenis_insiden_id');
                                $jenisInsiden = \App\Models\JenisInsiden::where('id', $idJenisInsiden)->first();

                                return $jenisInsiden?->nama_jenis_insiden . ' (' . $jenisInsiden?->alias . ')';
                            }),

                        // jenis pelapor
                        Placeholder::make('placeholder_jenis_pelapor')
                            ->label('Orang Pertama Yang Melaporkan')
                            ->content(fn(Get $get): string|null => $get('jenis_pelapor')),
                    ]),

                    Grid::make(2)->schema([
                        // korban insiden
                        Placeholder::make('placeholder_korban_insiden')
                            ->label('Insiden terjadi pada')
                            ->content(fn(Get $get): string|null => $get('korban_insiden')),

                        // layanan insiden
                        Placeholder::make('placeholder_layanan_insiden')
                            ->label('Insiden Menyangkut Pasien')
                            ->content(fn(Get $get): string|null => $get('layanan_insiden')),
                    ]),

                    Placeholder::make('placeholder_kasus_insiden')
                        ->label('Insiden terjadi pada pasien (sesuai kasus penyakit / spesialisasi)')
                        ->content(function (Get $get) {
                            $html = '<ul class="list-disc ml-6">';
                            $kasusInsiden = $get('kasus_insiden');

                            if (!$kasusInsiden) {
                                return '';
                            }

                            foreach ($kasusInsiden as $kasus) {
                                $html .= '<li>' . Str::replace('-', ' ', $kasus) . '</li>';
                            }
                            $html .= '</ul>';
                            $html = new HtmlString($html);
                            return $html;
                        }), // Agar HTML bisa dirender dengan benar

                    Grid::make(2)->schema([
                        // tempat
                        Placeholder::make('placeholder_tempat_kejadian')
                            ->label('Tempat Kejadian')
                            ->content(fn(Get $get): string|null => $get('tempat_kejadian')),

                        // unit
                        Placeholder::make('placeholder_unit')
                            ->label('Unit / Departemen terkait yang menyebabkan insiden')
                            ->content(function (Get $get) {
                                $idUnit = $get('unit_id');
                                $unit = \App\Models\Unit::where('id', $idUnit)->first();

                                return $unit?->nama_unit;
                            }),
                    ]),

                    // dampak
                    Placeholder::make('placeholder_dampak_insiden')
                        ->label('Dampak Insiden Terhadap Pasien')
                        ->content(fn(Get $get): string|null => $get('dampak_insiden')),
                ]),

            Section::make('Tindakan & Grading')
                ->description('Tindakan dan grading yang dilakukan pasca insiden')
                ->schema([
                    Placeholder::make('placeholder_tindakan_insiden')
                        ->label('Tindakan')
                        ->content(function (Get $get) {
                            $tindakan = $get('tindakan.content');
                            $tindakanHtml = new HtmlString($tindakan);

                            return $tindakanHtml;
                        }),

                    Grid::make(3)->schema([
                        // oleh
                        Placeholder::make('placeholder_oleh')
                            ->label('Tindakan Oleh')
                            ->content(fn(Get $get): string|null => $get('tindakan.oleh')),

                        // status pelapor
                        Placeholder::make('placeholder_status_pelapor')
                            ->label('Status Pelapor')
                            ->content(fn(Get $get): string|null => $get('status_pelapor')),

                        // grading risiko
                        Placeholder::make('placeholder_grading_risiko')
                            ->label('Grading Risiko')
                            ->content(fn(Get $get): string|null => $get('grading.grading_risiko'))
                    ])
                ]),

            Section::make('Investigasi Sederhana')
                ->description('Investigasi sederhana yang dilakukan pasca insiden')
                ->relationship('investigasi_sederhana')
                ->schema([
                    // kepala
                    Placeholder::make('placeholder_kepala_id')
                        ->label('Kepala')
                        ->content(function (Get $get) {
                            $idKepala = $get('kepala_id');
                            $kepala = \App\Models\User::where('id', $idKepala)->first();

                            return $kepala?->name;
                        }),

                    // penyebab insidne
                    Placeholder::make('placeholder_penyebab_insiden')
                        ->label('Penyebab Insiden')
                        ->content(fn(Get $get): string|null => $get('penyebab_insiden')),

                    // penyebab melatarbelakangi
                    Placeholder::make('placeholder_penyebab_melatarbelakangi')
                        ->label('Penyebab Yang Melatarbelakangi')
                        ->content(fn(Get $get): string|null => $get('penyebab_melatarbelakangi')),

                    Fieldset::make('Rekomendasi Investigasi')
                        ->schema([
                            // rekomendasi
                            Placeholder::make('placeholder_rekomendasi')
                                ->label('Rekomendasi')
                                ->content(function (Get $get) {
                                    $tindakan = $get('rekomendasi');
                                    $tindakanHtml = new HtmlString($tindakan);

                                    return $tindakanHtml;
                                }),

                            Grid::make(2)->schema([
                                Placeholder::make('placeholder_penanggung_jawab_rekomendasi')
                                    ->label('Penanggung Jawab Rekomendasi')
                                    ->content(function (Get $get) {
                                        $idPenanggungJawab = $get('penanggung_jawab_rekomendasi');
                                        $penanggungJawab = \App\Models\User::where('id', $idPenanggungJawab)->first();

                                        return $penanggungJawab?->name;
                                    }),

                                Placeholder::make('placeholder_tanggal_rekomendasi')
                                    ->label('Tanggal Rekomendasi')
                                    ->content(fn(Get $get): string|null => $get('tanggal_rekomendasi')),
                            ]),
                        ]),

                    Fieldset::make('Tindakan Rekomendasi')
                        ->schema([
                            Placeholder::make('placeholder_tindakan_rekomendasi')
                                ->label('Tindakan')
                                ->content(function (Get $get) {
                                    $tindakan = $get('tindakan_rekomendasi');
                                    $tindakanHtml = new HtmlString($tindakan);

                                    return $tindakanHtml;
                                }),

                            Grid::make(2)->schema([
                                Placeholder::make('placeholder_penanggung_jawab_tindakan')
                                    ->label('Penanggung Jawab Rekomendasi')
                                    ->content(function (Get $get) {
                                        $idPenanggungJawab = $get('penanggung_jawab_tindakan');
                                        $penanggungJawab = \App\Models\User::where('id', $idPenanggungJawab)->first();

                                        return $penanggungJawab?->name;
                                    }),

                                Placeholder::make('placeholder_tanggal_tindakan')
                                    ->label('Tanggal Rekomendasi')
                                    ->content(fn(Get $get): string|null => $get('tanggal_tindakan')),
                            ]),
                        ]),

                    Grid::make(2)->schema([
                        // tanggal_mulai
                        Placeholder::make('placeholder_tanggal_mulai')
                            ->label('Tanggal Mulai')
                            ->content(fn(Get $get): string|null => $get('tanggal_mulai')),

                        // tanggal selesai
                        Placeholder::make('placeholder_tanggal_selesai')
                            ->label('Tanggal Selesai')
                            ->content(fn(Get $get): string|null => $get('tanggal_selesai')),

                        // lengkap
                        Placeholder::make('placeholder_lengkap')
                            ->label('Investigasi Lengkap')
                            ->content(fn(Get $get): string|null => $get('lengkap') == 'lengkap' ? 'Ya, Lengkap !' : 'Tidak, Belum Lengkap'),

                        // investigasi lanjut
                        Placeholder::make('placeholder_investigasi_lanjut')
                            ->label('Diperlukan Investigasi Lebih Lanjut')
                            ->content(fn(Get $get): string|null => $get('investigasi_lanjut') == 'ya' ? 'Ya, Perlu !' : 'Tidak Perlu'),
                    ]),
                ]),
        ];
    }
}
