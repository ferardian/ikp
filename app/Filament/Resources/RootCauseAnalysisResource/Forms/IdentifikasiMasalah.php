<?php

namespace App\Filament\Resources\RootCauseAnalysisResource\Forms;

use App\Forms\Components\FishboneImageData;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Builder\Block;

class IdentifikasiMasalah
{
    public static function make(): array
    {
        return [
            Builder::make('identifikasi_masalah')
                ->label('Analisa Identifikasi Masalah')
                ->addActionLabel('Tambah Analisa')
                ->collapsible()->collapsed()
                ->blocks([
                    Block::make('5why')
                        ->schema(self::_5whySchema())
                        ->label('5 Why Analysis')
                        ->icon('icon-help-hexagon-filled'),

                    Block::make('fishbone')
                        ->schema(self::_fishboneSchema())
                        ->label('Fishbone Analysis')
                        ->icon('icon-fishbone-filled'),
                ])
        ];
    }

    private static function _5whySchema(): array
    {
        return [
            TextInput::make('masalah')
                ->label("Masalah Pelayanan")
                ->placeholder("Masalah pelayanan yang diidentifikasi")
                ->required(),

            Repeater::make('repeater-whys')
                ->label("Mengapa ?")
                ->columns(1)
                ->collapsible()
                ->collapsed()
                ->reorderable(false)
                ->addActionLabel("Tambah Pernyataan")
                ->addActionAlignment('right')
                ->defaultItems(2)
                ->minItems(1)
                ->collapseAction(null)
                ->itemLabel(fn(array $state): ?string => $state['whys'] ? $state['whys'] : 'Mengapa ?')
                ->grid(2)
                ->schema([
                    TextInput::make('whys')
                        ->label("Mengapa ?")
                        ->required(),
                ])
        ];
    }

    private static function _fishboneSchema(): array
    {
        return [
            // \Filament\Forms\Components\Livewire::make(\App\Livewire\FishboneDiagramGenerator::class, function ($state, callable $set) {
            //     return [
            //         'masalah' => $state['masalah'],
            //         'repeaterCauses' => $state['repeater-causes'],
            //     ];
            // }),

            TextInput::make('masalah')
                ->label("Masalah Pelayanan")
                ->placeholder("Masalah pelayanan yang diidentifikasi")
                ->reactive()->live()->required()
                ->afterStateHydrated(function ($state, $component, $livewire) {
                    if ($state) {
                        $livewire->dispatch('setMasalah', $state);
                    }
                })
                ->afterStateUpdated(fn ($state, $component, $livewire) => $livewire->dispatch('setMasalah', $state)),

            // repeater causes
            Repeater::make('repeater-causes')
                ->label("Penyebab")
                ->columns(1)
                ->reorderable(false)
                ->addActionLabel("Tambah Penyebab")
                ->addActionAlignment('right')
                ->defaultItems(1)->minItems(1)
                ->collapseAction(null)
                ->collapsible()->collapsed()
                ->reactive()->live()
                ->afterStateHydrated(fn ($state, $component, $livewire) => $livewire->dispatch('setCauses', $state))
                ->afterStateUpdated(fn ($state, $component, $livewire) => $livewire->dispatch('setCauses', $state))
                ->itemLabel(fn(array $state): ?string => $state['causes'] ? "Penyebab : " . $state['causes'] : 'Penyebab')
                ->schema([
                    TextInput::make('causes')
                        ->label("Penyebab")
                        ->required(),

                    // repeater sub causes
                    Repeater::make('sub_causes')
                        ->label("Sub Penyebab")
                        ->columns(1)
                        ->grid(2)
                        ->defaultItems(2)
                        ->collapsible()
                        ->collapsed()
                        ->reorderable(false)
                        ->addActionLabel("Tambah Sub Penyebab")
                        ->collapseAction(null)
                        ->addActionAlignment('right')
                        ->itemLabel(fn(array $state): ?string => $state['sub_causes'] ? "Sub Penyebab : " . $state['sub_causes'] : 'Sub Penyebab')
                        ->schema([
                            TextInput::make('sub_causes')
                                ->label("Sub Penyebab")
                                ->required(),
                        ])
                ])
        ];
    }
}
