<?php

namespace App\Filament\Widgets;

use App\Models\Insiden;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class InsidenBulananChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Jumlah Insiden Per Bulan';

    protected static ?string $maxHeight = "500px";

    protected int | string | array $columnSpan = 4;

    protected function getData(): array
    {
        $y = $this->filters['tahun'] ?? now()->year;

        $data = Insiden::selectRaw('MONTH(tanggal_insiden) as bulan, COUNT(*) as jumlah')
            ->whereYear('tanggal_insiden', $y)
            ->groupBy('bulan')
            ->orderBy('bulan');

        if (auth()->user()->can('view_only_unit_insiden')) {
            $data = $data->where('unit_id', auth()->user()?->detail?->unit_id);
        }

        $data = $data->pluck('jumlah', 'bulan')->toArray();

        // Buat array kosong untuk semua bulan (1-12)
        $jumlahPerBulan = array_fill(1, 12, 0);

        // Gabungkan data hasil query dengan array bulan
        foreach ($data as $bulan => $jumlah) {
            $jumlahPerBulan[$bulan] = $jumlah;
        }

        return [
            'datasets' => [
                [
                    'label' => "Jumlah Insiden $y",
                    'data' => array_values($jumlahPerBulan),
                    'backgroundColor' => 'rgba(' .\Filament\Support\Colors\Color::Indigo[500]. ', 0.2)',
                    'fill' => true,
                    'borderWidth' => 3,
                ],
            ],
            'labels' => [
                'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
            ],
        ];
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'max' => 10,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
