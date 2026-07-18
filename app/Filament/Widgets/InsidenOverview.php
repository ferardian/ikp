<?php

namespace App\Filament\Widgets;

use App\Models\Insiden;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class InsidenOverview extends BaseWidget
{
    use InteractsWithPageFilters;

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalInsiden = Insiden::query();
        $unGradingInsiden = Insiden::whereDoesntHave('grading');
        $totalInsidenChartQuery = Insiden::where('tanggal_insiden', '>=', now()->subYear())
            ->groupByRaw('DATE_FORMAT(tanggal_insiden, "%Y-%m")')
            ->orderByRaw('DATE_FORMAT(tanggal_insiden, "%Y-%m")');

        if (auth()->user()->can('view_only_unit_insiden')){
            $totalInsiden = Insiden::where('unit_id', auth()->user()?->detail?->unit_id);
            $unGradingInsiden = $unGradingInsiden->where('unit_id', auth()->user()?->detail?->unit_id);
            $totalInsidenChartQuery = $totalInsidenChartQuery->where('unit_id', auth()->user()?->detail?->unit_id);
        }

        return [
            Stat::make("Total Insiden", $totalInsiden->count())
                ->description("Total Keseluruhan Insiden")
                ->descriptionIcon("heroicon-o-exclamation-triangle", IconPosition::Before)
                ->color('gray')
                ->chartColor('gray')
                ->chart(
                    $totalInsidenChartQuery
                        ->pluck(DB::raw('COUNT(*)'), DB::raw('DATE_FORMAT(tanggal_insiden, "%Y-%m")'))
                        ->toArray()
                )
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:opacity-85 transition',
                    'wire:click' => '$dispatch(\'open-insiden-lookup\', { type: \'total\', title: \'Total Insiden\' })',
                ]),

            $this->InsidenTahunIni(),

            Stat::make("Insiden Belum Tergrading", $unGradingInsiden->count())
                ->description("Insiden yang belum tergrading")
                ->descriptionIcon("heroicon-o-exclamation-triangle", IconPosition::Before)
                ->color('warning')
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:opacity-85 transition',
                    'wire:click' => '$dispatch(\'open-insiden-lookup\', { type: \'belum_tergrading\', title: \'Insiden Belum Tergrading\' })',
                ]),
        ];
    }

    public function getColumns(): int
    {
        return 3;
    }

    public function InsidenTahunIni(): Stat
    {
        // Mengambil filter tahun dari halaman, jika tidak ada, gunakan tahun sekarang
        $tahunIni = (int) ($this->filters['tahun'] ?? now()->format('Y'));
        $tahunLalu = $tahunIni - 1;

        // Hitung jumlah insiden berdasarkan tahun
        $insidenTahunIni = Insiden::whereYear('tanggal_insiden', $tahunIni);
        $insidenTahunLalu = Insiden::whereYear('tanggal_insiden', $tahunLalu);

        $q = Insiden::when($tahunIni, fn ($query) => $query->whereYear('tanggal_insiden', $tahunIni))
            ->groupByRaw('DATE_FORMAT(tanggal_insiden, "%Y-%m")')
            ->orderByRaw('DATE_FORMAT(tanggal_insiden, "%Y-%m")');

        if (auth()->user()->can('view_only_unit_insiden')){
            $q = $q->where('unit_id', auth()->user()?->detail?->unit_id);
            $insidenTahunIni = $insidenTahunIni->where('unit_id', auth()->user()?->detail?->unit_id)->count();
            $insidenTahunLalu = $insidenTahunLalu->where('unit_id', auth()->user()?->detail?->unit_id) ->count();
        } else {
            $insidenTahunIni = $insidenTahunIni->count();
            $insidenTahunLalu = $insidenTahunLalu->count();
        }

        // Hitung selisih
        $diff = $insidenTahunIni - $insidenTahunLalu;

        // Tentukan deskripsi, ikon, dan warna berdasarkan selisih
        if ($diff > 0) {
            $deskripsi = "Naik {$diff} insiden dibanding tahun lalu";
            $icon = "heroicon-o-arrow-trending-up";
            $color = "danger"; // Merah untuk kenaikan insiden
        } elseif ($diff < 0) {
            $deskripsi = "Turun " . abs($diff) . " insiden dibanding tahun lalu";
            $icon = "heroicon-o-arrow-trending-down";
            $color = "success"; // Hijau untuk penurunan insiden
        } else {
            $deskripsi = "Jumlah insiden sama seperti tahun lalu";
            $icon = "heroicon-o-chart-bar";
            $color = "warning"; // Kuning untuk kondisi stabil
        }

        return Stat::make("Insiden Tahun {$tahunIni}", $insidenTahunIni)
            ->description($deskripsi)
            ->descriptionIcon($icon, IconPosition::Before)
            ->color($color)
            ->chartColor($color)
            ->chart(
                $q->pluck(DB::raw('COUNT(*)'), DB::raw('DATE_FORMAT(tanggal_insiden, "%Y-%m")'))
                    ->toArray(),
            )
            ->extraAttributes([
                'class' => 'cursor-pointer hover:opacity-85 transition',
                'wire:click' => '$dispatch(\'open-insiden-lookup\', { type: \'tahun\', title: \'Insiden Tahun ' . $tahunIni . '\', tahun: ' . $tahunIni . ' })',
            ]);
    }
}
