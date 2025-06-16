<?php

namespace App\Filament\Resources\RootCauseAnalysisResource\Forms;

use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Get;

class RingkasanRCA
{
    public static function make(): array {
        return [
            Section::make('Ringkasan Investigator')
                ->label('Ringkasan Investigator')
                ->description('Ringkasan Data Investigator')
                ->columns(1)
                ->schema([
                    Grid::make(2)
                        ->schema([
                            // ketua investigator
                            PlaceHolder::make('ringkasan-ketua-investigator')
                                ->label('Ketua Investigator')
                                ->content(function (Get $get) {
                                    $id_ketua = $get('ketua_id');
                                    $d = \App\Models\User::where('id', $id_ketua)->first();

                                    return $d?->name;
                                }),

                            // anggota investigator
                            PlaceHolder::make('ringkasan-members')
                                ->label('Anggota Investigator')
                                ->content(function (Get $get) {
                                    $id_member = $get('members');
                                    $d = \App\Models\User::whereIn('id', $id_member)->get();

                                    return $d->implode('name', ', ');
                                }),

                            // notulen
                            PlaceHolder::make('ringkasan-notulen-id')
                                ->label('Notulen')
                                ->content(function (Get $get) {
                                    $id_notulen = $get('notulen_id');
                                    $d = \App\Models\User::where('id', $id_notulen)->first();

                                    return $d?->name;
                                }),
                        ]),

                    Grid::make(2)
                        ->schema([
                            // radio area_terwakili
                            PlaceHolder::make('ringkasan-area-terwakili')
                                ->label('Apakah semua area yang terkait sudah terwakili ?')
                                ->content(function (Get $get) {
                                    return $get('area_terwakili') == 1 ? 'Ya, sudah terwakili !' : 'Tidak, belum terwakili !';
                                }),

                            // radio pengetahuan_terwakili
                            PlaceHolder::make('ringkasan-pengetahuan-terwakili')
                                ->label('Apakah macam-macam & tingkat pengetahuan sudah diwakili ?')
                                ->content(function (Get $get) {
                                    return $get('pengetahuan_terwakili') == 1 ? 'Ya, sudah terwakili !' : 'Tidak, belum terwakili !';
                                }),

                            // tanggal mulai investigasi
                            PlaceHolder::make('ringkasan-tanggal-mulai-investigasi')
                                ->label('Tanggal mulai investigasi')
                                ->content(function (Get $get) {
                                    return $get('tanggal_mulai_investigasi');
                                }),

                            // tanggal selesai investigasi
                            PlaceHolder::make('ringkasan-tanggal_selesai_dilengkapi')
                                ->label('Tanggal selesai dilengkapi')
                                ->content(function (Get $get) {
                                    return $get('tanggal_selesai_dilengkapi');
                                }),
                        ]),
                ]),
        ];
    }
}
