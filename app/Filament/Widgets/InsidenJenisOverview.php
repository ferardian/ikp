<?php

namespace App\Filament\Widgets;

use App\Models\Insiden;

use App\Models\JenisInsiden;
use Filament\Forms\Form;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class InsidenJenisOverview extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    protected static string $view = 'filament.widgets.custom-insiden-jenis-overview-widget';

    protected function getStats(): array
    {
        $y = $this->filters['tahun'] ?? now()->year;

        $jumlahInsidenPerJenis = JenisInsiden::query()
            ->leftJoin('insiden', function ($join) use ($y) {
                $join->on('insiden.jenis_insiden_id', '=', 'jenis_insiden.id')
                    ->whereYear('insiden.tanggal_insiden', $y);

                if (auth()->user()->can('view_only_unit_insiden')) {
                    $join->where('insiden.unit_id', auth()->user()?->detail?->unit_id);
                }
            })
            ->select([
                'jenis_insiden.id',
                'jenis_insiden.nama_jenis_insiden',
                'jenis_insiden.alias',
            ])
            ->selectRaw('COALESCE(COUNT(insiden.id), 0) as jumlah')
            ->groupBy('jenis_insiden.id', 'jenis_insiden.nama_jenis_insiden', 'jenis_insiden.alias')
            ->get();

        $widgets = [];

        foreach ($jumlahInsidenPerJenis as $item) {
            $widgets[] = Stat::make($item->nama_jenis_insiden, $item->jumlah)
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:opacity-85 transition',
                    'wire:click' => '$dispatch(\'open-insiden-lookup\', { type: \'jenis\', id: ' . $item->id . ', title: \'' . $item->nama_jenis_insiden . '\', tahun: ' . $y . ' })',
                ]);
        }

        return $widgets;
    }
}
