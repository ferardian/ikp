<?php

namespace App\Filament\Resources\InsidenResource\Pages;

use App\Filament\Resources\InsidenResource;
use Filament\Actions;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Colors\Color;
use Illuminate\Support\Str;

class ViewInsiden extends ViewRecord
{
    protected static string $resource = InsidenResource::class;
    protected static $jenisPelapor = [
        "karyawan" => "Karyawan ( Dokter, Perawat, dll )",
        "pengunjung" => "Pengunjung",
        "pasien" => "Pasien",
        "keluarga" => "Keluarga / Pendamping Pasien",
        "lainnya" => "Lainnya"
    ];

    protected static $dampakInsiden = [
        "katastropik" => "Kematian",
        "mayor" => "Cedera Irriversibel / Berat",
        "moderat" => "Cedera Reversibel / Sedang",
        "minor" => "Cedera Ringan",
        "tidak signifikan" => "Tidak Cedera",
    ];

    protected static $gradingColor = [
        "Biru" => Color::Sky,
        "Hijau" => Color::Emerald,
        "Kuning" => Color::Amber,
        "Merah" => Color::Rose,
    ];

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                \Filament\Infolists\Components\Section::make('Detail Pasien')
                    ->description('Detail pasien terdampak')
                    ->collapsible()
                    ->collapsed(false)
                    ->columns(['sm' => 2])
                    ->schema([
                        ...self::getPasienComponent($this->record),
                    ]),

                \Filament\Infolists\Components\Section::make('Detail Insiden')
                    ->description('Detail insiden terkait')
                    ->collapsible()
                    ->collapsed()
                    ->columns(['sm' => 2])
                    ->schema([
                        ...self::getInsidenComponent($this->record),
                    ]),

                \Filament\Infolists\Components\Section::make('Tindakan & Grading Pasca Insiden')
                    ->description('Tindakan yang dilakukan')
                    ->collapsible()
                    ->collapsed()
                    ->columns(['sm' => 2])
                    ->schema([
                        ...self::getTindakanComponent($this->record),
                    ]),

                \Filament\Infolists\Components\Section::make('Investigasi Sederhana')
                    ->description('Investigasi Sederhana terhadap insiden')
                    ->collapsible()
                    ->collapsed()
                    ->columns(['sm' => 2])
                    ->schema([
                        ...self::getInvestigasiSederhanaComponent($this->record),
                    ])
            ]);
    }

    private static function getTindakanComponent($insiden): array
    {
        $components = [];
        $data = [
            'status_pelapor' => [
                'label' => 'Status Pelapor',
                'default' => $insiden->status_pelapor,
            ],
            'tindakan.oleh' => [
                'label' => 'Tindakan Dilakukan Oleh',
                'default' => in_array($insiden->tindakan->oleh, ['tim', 'petugas'])
                    ? Str::ucfirst($insiden->tindakan->oleh) . " : " . $insiden->tindakan->detail
                    : Str::ucfirst($insiden->tindakan->oleh),
            ],
            'grading.grading_risiko' => [
                'label' => 'Grading Risiko',
                'default' => $insiden?->grading?->grading_risiko ?? "-",
                'badge' => true,
                'color' => self::$gradingColor[$insiden?->grading?->grading_risiko] ?? Color::Slate,
            ],
            'tindakan.content' => [
                'label' => 'Tindakan',
                'default' => $insiden->tindakan->content,
                'columnSpan' => 'full',
            ],
        ];

        foreach ($data as $key => $value) {
            $components[] = TextEntry::make(isset($value['default']) && $value['default'] ? $key . '_' . $value['label'] : $key)
                ->label($value['label'])
                ->badge($value['badge'] ?? false)
                ->default($value['default'] ?? $insiden->{$key})
                ->color($value['color'] ?? null)
                ->columnSpan($value['columnSpan'] ?? 1);
        }

        return $components;
    }

    private static function getInsidenComponent($insiden): array
    {
        $components = [];
        $data = [
            'insiden' => [
                'label' => 'Insiden',
            ],
            'tanggal_insiden' => [
                'label' => 'Tanggal Insiden',
                'default' => \Carbon\Carbon::parse(explode(' ', $insiden->tanggal_insiden)[0])->translatedFormat('l, d F Y'),
            ],
            'waktu_insiden' => [
                'label' => 'Waktu Insiden'
            ],
            'tgl_pasien_masuk' => [
                'label' => 'Tanggal Masuk Pasien',
                'default' => \Carbon\Carbon::parse(explode(' ', $insiden->tgl_pasien_masuk)[0])->translatedFormat('l, d F Y'),
            ],
            'kronologi' => [
                'label' => 'Kronologi',
                'columnSpan' => 'full',
            ],
            'jenis_insiden' => [
                'label' => 'Jenis Insiden',
                'default' => $insiden->jenis->nama_jenis_insiden . " ( " . $insiden->jenis->alias . " )",
            ],
            'jenis_pelapor' => [
                'label' => 'Pelapor',
                'default' => self::$jenisPelapor[$insiden->jenis_pelapor] ?? $insiden->jenis_pelapor,
            ],
            'korban_insiden' => [
                'label' => 'Insiden Terjadi Pada',
                'default' => $insiden->korban_insiden == 'pasien' ? 'Pasien' : 'Lainnya',
            ],
            'kasus_insiden' => [
                'label' => 'Kasus Insiden',
                'default' => $insiden->kasus_insiden ? Str::replace('-', ' ', $insiden->kasus_insiden) : "-",
            ],
            'tempat_kejadian' => [
                'label' => 'Tempat Kejadian'
            ],
            'unit' => [
                'label' => 'Unit',
                'default' => $insiden->unit->nama_unit ?? "-",
            ],
            'dampak_insiden' => [
                'label' => 'Dampak Insiden',
                'default' => self::$dampakInsiden[$insiden->dampak_insiden] ?? $insiden->dampak_insiden,
            ],
            'crated_by' => [
                'label' => 'Dilaporkan Oleh',
                'default' => $insiden->oleh->name ?? "-",
            ],
        ];

        foreach ($data as $key => $value) {
            ;
            $components[] = TextEntry::make(isset($value['default']) && $value['default'] ? $key . '_' . $value['label'] : $key)
                ->label($value['label'])
                ->default($value['default'] ?? $insiden->{$key})
                ->badge($value['badge'] ?? false)
                ->columnSpan($value['columnSpan'] ?? 1);
        }

        return $components;
    }

    private static function getPasienComponent($insiden): array
    {
        $components = [];
        $data = [
            'nm_pasien' => [
                'label' => 'Nama',
                'default' => function () use ($insiden) {
                    return $insiden->pasien ? $insiden->pasien->nm_pasien : $insiden->nm_pasien;
                },
            ],
            'no_rkm_medis' => [
                'label' => 'No. Rekam Medis',
                'badge' => true,
                'default' => function () use ($insiden) {
                    return $insiden->pasien ? $insiden->pasien->no_rkm_medis : $insiden->pasien_id;
                }
            ],
            'tanggal_lahir' => [
                'label' => 'Tanggal Lahir',
                'default' => function () use ($insiden) {
                    if ($insiden->pasien) {
                        return \Carbon\Carbon::parse($insiden->pasien->tanggal_lahir)->translatedFormat('l, d F Y');
                    } else {
                        return \Carbon\Carbon::parse($insiden->tgl_lahir)->translatedFormat('d F Y');
                    }
                },
            ],
            'jenis_kelamin' => [
                'label' => 'Jenis Kelamin',
                'default' => $insiden->pasien?->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan',
            ]
        ];

        foreach ($data as $key => $value) {
            $components[] = TextEntry::make(isset($value['default']) && $value['default'] ? $key . '_' . $value['label'] : $key)
                ->label($value['label'])
                ->badge($value['badge'] ?? false)
                ->default($value['default'] ?? 'default');
            // ->columnSpan($value['columnSpan'] ?? 1);
        }

        return $components;
    }

    private static function getInvestigasiSederhanaComponent($insiden): array
    {
        return [
            TextEntry::make('investigasi_sederhana.kepala.name')
                ->label('Manager / Kepala Bagian / Kepala Unit')
                ->default($insiden?->investigasi_sederhana?->kepala?->name ?? "-")
                ->columnSpan('full'),

            TextEntry::make('investigasi_sederhana.penyebab_insiden')
                ->label('Penyebab Insiden Langsung')
                ->default($insiden?->investigasi_sederhana?->penyebab_insiden ?? "-"),

            TextEntry::make('investigasi_sederhana.penyebab_melatarbelakangi')
                ->label('Penyebab yang Melatarbelakangi Insiden')
                ->default($insiden?->investigasi_sederhana?->penyebab_melatarbelakangi ?? "-"),

            // lengkap
            TextEntry::make('investigasi_sederhana.lengkap_key')
                ->label('Investigasi Lengkap')
                ->default($insiden?->investigasi_sederhana?->lengkap == 'lengkap' ? 'Ya, Lengkap !' : 'Tidak, Belum Lengkap'),

            // investigasi_lanjut
            TextEntry::make('investigasi_sederhana.investigasi_lanjut_key')
                ->label('Diperlukan Investigasi Lebih Lanjut')
                ->default($insiden?->investigasi_sederhana?->investigasi_lanjut == 'investigasi_lanjut' ? 'Ya, Investigasi Lanjut' : 'Tidak, Cukup Investigasi Sederhana !'),

            Fieldset::make('Rekomendas Investigasi')
                ->schema([
                    TextEntry::make('investigasi_sederhana.rekomendasi')
                        ->label('Rekomendasi')
                        ->html()
                        ->default($insiden?->investigasi_sederhana?->rekomendasi ?? "-")
                        ->columnSpan('full'),

                    TextEntry::make('investigasi_sederhana.penanggung_jawab_rekomendasi_key')
                        ->label('Penanggung Jawab')
                        ->default($insiden?->investigasi_sederhana?->pj_rekomendasi?->name ?? "-"),

                    TextEntry::make('investigasi_sederhana.tanggal_rekomendasi_key')
                        ->label('Tanggal Rekomendasi')
                        ->default($insiden?->investigasi_sederhana?->tanggal_rekomendasi?->translatedFormat('l, d F Y') ?? "-")
                ]),

            Fieldset::make('Tindakan Sesuai Rekomendasi')
                ->schema([
                    TextEntry::make('investigasi_sederhana.tindakan_rekomendasi')
                        ->label('Tindakan')
                        ->html()
                        ->default($insiden?->investigasi_sederhana->rekomendasi ?? "-")
                        ->columnSpan('full'),

                    TextEntry::make('investigasi_sederhana.penanggung_jawab_tindakan_key')
                        ->label('Penanggung Jawab')
                        ->default($insiden?->investigasi_sederhana?->pj_tindakan?->name ?? "-"),

                    TextEntry::make('investigasi_sederhana.tanggal_tindakan_key')
                        ->label('Tanggal Tindakan')
                        ->default($insiden?->investigasi_sederhana?->tanggal_tindakan?->translatedFormat('l, d F Y') ?? "-"),
                ]),
        ];
    }
}
