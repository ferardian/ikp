<?php

namespace App\Filament\Pages;

use App\Forms\Components\YearPicker;

use Filament\Facades\Filament;
use Filament\Forms\Components\Placeholder;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Widgets\AccountWidget;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\InsidenOverview::class,
            \App\Filament\Widgets\InsidenJenisOverview::class,
            \App\Filament\Widgets\InsidenBulananChart::class,
            \App\Filament\Widgets\InsidenGradingOverview::class,
            \App\Filament\Widgets\TopUnitInsiden::class
        ];
    }

    public function getColumns(): int|string|array
    {
        return 6;
    }

    public function filtersForm(Form $form): Form
    {
        return $form->schema([
            Section::make()
                ->columns(3)
                ->schema([
                    Placeholder::make('dashboard-title')
                        ->label('Dashboard Insiden Keselamatan Pasien.')
                        ->view('filament.dashboard-title'),
                    Placeholder::make(''),
                    YearPicker::make('tahun')
                        ->hiddenLabel()
                        ->placeholder("Filter tahun")
                        ->minYear(2000)
                        ->reactive()
                        ->maxYear(now()->year),
                ]),
        ]);
    }
}
