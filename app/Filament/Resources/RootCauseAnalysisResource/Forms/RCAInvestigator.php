<?php

namespace App\Filament\Resources\RootCauseAnalysisResource\Forms;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;

class RCAInvestigator
{
    /*
     * Form schema untuk Investigator RCA
     * @return array
     */
    public static function make(): array
    {
        return [
            // Select ketua
            Select::make('ketua_id')
                ->label('Ketua Komite Mutu ')
                ->options(\App\Models\User::all()->pluck('name', 'id'))
                ->searchable()
                ->required(),

            // select anggota
            Select::make('members')
                ->label('Anggota Investigator')
                ->options(\App\Models\User::all()->pluck('name', 'id'))
                ->searchable()->multiple(true)
                ->required(),

            Grid::make(2)
                ->schema([
                    // radio area_terwakili
                    Radio::make('area_terwakili')
                        ->label('Apakah semua area yang  terkait sudah terwakili ?')
                        ->options([
                            '1' => 'Ya, sudah terwakili !',
                            '0' => 'Tidak, belum terwakili !',
                        ])
                        ->inline()
                        ->inlineLabel(false)
                        ->required(),

                    // radio pengetahuan_terwakili
                    Radio::make('pengetahuan_terwakili')
                        ->label('Apakah macam-macam & tingkat pengetahuan sudah diwakili ?')
                        ->options([
                            '1' => 'Ya, sudah terwakili !',
                            '0' => 'Tidak, belum terwakili !',
                        ])
                        ->inline()
                        ->inlineLabel(false)
                        ->required(),
                ]),

            Grid::make(2)
                ->schema([
                    Select::make('notulen_id')
                        ->label('Notulen')
                        ->options(\App\Models\User::all()->pluck('name', 'id'))
                        ->searchable()
                        ->required(),

                    Select::make('kepala_igd_id')
                        ->label('Kepala Ruang IGD')
                        ->options(\App\Models\User::all()->pluck('name', 'id'))
                        ->searchable()
                        ->required(),

                    DatePicker::make('tanggal_mulai_investigasi')
                        ->label('Tanggal Mulai Investigasi')
                        ->minDate(fn($livewire) => $livewire->insiden?->tanggal_insiden ? $livewire->insiden->tanggal_insiden : now()->subDays(3))
                        ->maxDate(fn($livewire) => $livewire->insiden ? $livewire->insiden->tanggal_insiden->copy()->addMonths(6) : now()->addMonths(6))
                        // ->maxDate(now()->addMonth(3))
                        ->required(),

                    DatePicker::make('tanggal_selesai_dilengkapi')
                        ->label('Tanggal Selesai Investigasi')
                        ->minDate(fn($livewire) => $livewire->insiden?->tanggal_insiden ? $livewire->insiden->tanggal_insiden : now()->subDays(3))
                        ->maxDate(fn($livewire) => $livewire->insiden ? $livewire->insiden->tanggal_insiden->copy()->addMonths(6) : now()->addMonths(6))
                        // ->maxDate(now()->addMonth(3))
                        ->required(),
                ]),
        ];
    }
}
