<?php

namespace App\Filament\Resources\RootCauseAnalysisResource\Forms;

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Textarea;

class FormulirAnalisis
{
    public static function make(): array
    {
        return [
            Builder::make('perubahan_dan_penghalang')
                ->label('Analisis Perubahan & Penghalang')
                ->addActionLabel("Tambah Analisis")
                ->collapsible()
                ->schema([
                    Builder\Block::make('analisis_perubahan')
                        ->label('Analisis Perubahan')
                        ->icon('icon-layers-difference')
                        ->schema([
                            Group::make([
                                Textarea::make('prosedur-sesuai-sop')
                                    ->label('Prosedur Sesuai SOP'),
                                Textarea::make('prosedur-saat-insiden')
                                    ->label('Prosedur Yang Dilakukan Saat Insiden'),
                            ])->columns(2),
                            Textarea::make('bukti-perubahan-dalam-proses')
                                ->label('Bukti Perubahan Dalam Proses'),
                        ]),

                    Builder\Block::make('analisis_penghalang')
                        ->label('Analisis Penghalang')
                        ->icon('icon-barrier-block')
                        ->schema([
                            Group::make([
                                Textarea::make('penghalang')
                                    ->label('Apa Penghalang Pada Masalah Ini'),
                                Textarea::make('penghalang-dilakukan')
                                    ->label('Apa Penghalang Dilakukan'),
                            ])->columns(2),
                            Textarea::make('mengapa-gagal')
                                ->label('Mengapa Penghalang Gagal ? Apa Dampaknya ? '),
                        ]),
                ])
        ];
    }
}
