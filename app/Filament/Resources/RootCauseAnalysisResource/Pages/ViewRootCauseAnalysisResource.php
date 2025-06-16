<?php

namespace App\Filament\Resources\RootCauseAnalysisResource\Pages;

use App\Filament\Resources\RootCauseAnalysisResource;
use App\Infolists\Components\AnalisisPerubahanDanPenghalangEntry;
use App\Infolists\Components\IdentifikasiMasalahEntry;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;

class ViewRootCauseAnalysisResource extends ViewRecord
{
    protected static string $resource = RootCauseAnalysisResource::class;

    protected static $badgeDampakColor = [
        'tidak signifikan' => 'primary',
        'minor' => 'success',
        'moderat' => 'warning',
        'mayor' => 'danger',
        'katastropik' => 'danger',
    ];

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Detail Insiden')
                    ->description('Detail singkat insiden yang terjadi')
                    ->collapsible()
                    ->collapsed()
                    ->relationship('insiden')
                    ->columns([ 'sm' => 2, "md" => 3 ])
                    ->schema([
                        TextEntry::make('insiden')->columnSpan(2),
                        TextEntry::make('dampak')
                            ->label('Dampak Insiden')
                            ->badge()->color(self::$badgeDampakColor[$this->record->insiden->dampak_insiden])
                            ->default(Str::title($this->record->insiden->dampak_insiden)),
                        TextEntry::make('jam_waktu_insiden')
                            ->default($this->record->insiden->tanggal_insiden->translatedFormat('l, d F Y') . ' ' . $this->record->insiden->waktu_insiden),
                        TextEntry::make('tempat_kejadian'),
                        TextEntry::make('unit.nama_unit'),
                    ]),

                Section::make("Investigator")
                    ->description('RCA Investigator')
                    ->collapsible()
                    ->collapsed()
                    ->columns([ 'sm' => 2 ])
                    ->schema([
                        Group::make([
                            TextEntry::make('ketua.name'),
                            TextEntry::make('notulen.name'),
                            TextEntry::make('kepalaIgd.name'),
                        ]),

                        Group::make([
                            TextEntry::make('members')
                                ->formatStateUsing(fn ($state): View => view(
                                    'filament.member-list-entry-content',
                                    ['state' => $state]
                                )),
                        ]),

                        TextEntry::make('area_terwakili')
                            ->label('Apakah semua area yang  terkait sudah terwakili ?')
                            ->formatStateUsing(fn (string $state): string =>
                            $state === '1' ? 'Ya, sudah terwakili !' : 'Tidak, belum terwakili !'
                            ),

                        TextEntry::make('pengetahuan_terwakili')
                            ->label('Apakah macam-macam & tingkat pengetahuan sudah diwakili ?')
                            ->formatStateUsing(fn (string $state): string =>
                            $state === '1' ? 'Ya, sudah terwakili !' : 'Tidak, belum terwakili !'
                            ),

                        TextEntry::make('tanggal_mulai_investigasi')
                            ->formatStateUsing(fn ($state): string => $state->translatedFormat('l, d F Y')),

                        TextEntry::make('tanggal_selesai_dilengkapi')
                            ->formatStateUsing(fn ($state): string => $state->translatedFormat('l, d F Y')),
                    ]),

                Section::make('Data & Informasi')
                    ->description('Data dan informasi yang sudah dikumpulkan')
                    ->collapsible()
                    ->collapsed(true)
                    ->schema([
                        RepeatableEntry::make('data_primer')
                            ->grid(2)
                            ->schema([
                                TextEntry::make('data')
                                    ->label('Data Primer'),

                                TextEntry::make('catatan')
                                    ->label('Catatan')
                            ]),

                        RepeatableEntry::make('data_sekunder')
                            ->grid(2)
                            ->schema([
                                TextEntry::make('data')
                                    ->label('Data Sekunder'),

                                TextEntry::make('catatan')
                                    ->label('Catatan')
                            ]),

                        RepeatableEntry::make('data_lainnya')
                            ->grid(2)
                            ->schema([
                                TextEntry::make('data')
                                    ->label('Data Lainnya'),

                                TextEntry::make('catatan')
                                    ->label('Catatan')
                            ]),
                    ]),

                Section::make('Kronologi Waktu Kejadian')
                    ->description('Peta kronologi Waktu Kejadian')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        RepeatableEntry::make('kronologi_waktu_kejadian')
                            ->columns(2)
                            ->schema([
                                TextEntry::make('waktu-kejadian')
                                    ->columnSpanFull()
                                    ->label('Waktu Kejadian'),

                                TextEntry::make('kejadian')
                                    ->label('Kejadian'),

                                TextEntry::make('informasi-tambahan')
                                    ->label('Informasi Tambahan'),

                                TextEntry::make('good-practice')
                                    ->label('Good Practice'),

                                TextEntry::make('masalah-pelayanan')
                                    ->label('Masalah Pelayanan'),
                            ]),
                    ]),

                Section::make('Identifikasi Masalah')
                    ->description('Identifikasi Masalah Pelayanan / CMP')
                    ->collapsible()
                    ->collapsed(false)
                    ->schema([
                        IdentifikasiMasalahEntry::make('identifikasi_masalah')
                            ->label("Analisis Identifikasi Masalah")
                    ]),

                Section::make('Perubahan dan Penghalang')
                    ->description('Analisis Perubahan dan Penghalang')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        AnalisisPerubahanDanPenghalangEntry::make('perubahan_dan_penghalang')
                            ->label("Analisis Perubahan Dan Penghalang")
                    ]),

                Section::make('Rekomendasi')
                    ->description('Rekomendasi RCA')
                    ->collapsible()
                    ->collapsed(true)
                    ->schema([
                        RepeatableEntry::make('rekomendasi')
                            ->columns(2)
                            ->schema([
                                TextEntry::make('akar_masalah')
                                    ->label('Akar Masalah'),

                                TextEntry::make('rekomendasi')
                                    ->label('Rekomendasi'),

                                TextEntry::make('tim')
                                    ->label('Tim Rekomendasi'),

                                TextEntry::make('penanggung_jawab')
                                    ->label('Penanggung Jawab')
                                    ->formatStateUsing(fn ($state): string => \App\Models\User::find($state)->name),

                                TextEntry::make('sumber_daya')
                                    ->columnSpanFull()
                                    ->html()
                                    ->label('Sumber Daya Yang dibutuhkan'),

                                Fieldset::make('Penyelesaian')
                                    ->columnSpanFull()
                                    ->columns(4)
                                    ->schema([
                                        TextEntry::make('bukti')
                                            ->label('Bukti')
                                            ->columnSpan(2),

                                        TextEntry::make('oleh')
                                            ->label('Oleh')
                                            ->formatStateUsing(fn ($state): string => \App\Models\User::find($state)->name),

                                        TextEntry::make('tanggal')
                                            ->label('Tanggal Penyelesaian')
                                            ->formatStateUsing(fn ($state): string => \Carbon\Carbon::parse($state)->translatedFormat('l, d F Y')),
                                    ])
                                // tampilkan tanda_tangan atau timestamp signature dan anam yang menandatangani
                            ])
                    ])
            ]);
    }

    public function detail5Why() : array
    {
        return [
            Group::make([
                TextEntry::make('masalah')
                    ->label('Masalah'),
            ]),
            Group::make([
                RepeatableEntry::make('repeater-whys')
                    ->label("Mengapa ?")
                    ->grid(3)
                    ->schema([
                        TextEntry::make('whys')
                            ->label('Mengapa ?'),
                    ]),
            ])
        ];
    }

    public function detailFishbone() : array
    {
        return [
            Group::make([
                TextEntry::make('masalah')
                    ->label('Masalah'),
            ]),
        ];
    }
}
