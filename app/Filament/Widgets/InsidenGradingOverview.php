<?php

namespace App\Filament\Widgets;

use App\Models\Grading;
use App\Models\Insiden;

use App\Models\JenisInsiden;
use Filament\Forms\Form;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class InsidenGradingOverview extends StatsOverviewWidget
{
    use InteractsWithPageFilters;

    protected int|string|array $columnSpan = 2;

    protected function getColumns(): int
    {
        return 1;
    }

    protected function getStats(): array
    {
        $user = auth()->user();
        $y = $this->filters['tahun'] ?? now()->year;

        $gradingColor = collect([
            "Hijau", "Biru", "Kuning", "Merah"
        ]);

        $d = Grading::query()
            ->join('insiden', 'insiden.id', '=', 'grading.insiden_id') // Join tabel insiden dengan grading
            ->selectRaw('COUNT(insiden.id) as total, grading.grading_risiko') // Hitung jumlah insiden per grading_risiko
            ->groupBy('grading.grading_risiko');

        // Cek jika user memiliki izin 'view_only_unit_insiden', filter berdasarkan unit_id
        if ($user && $user->can('view_only_unit_insiden')) {
            $d = $d->where('insiden.unit_id', $user->detail?->unit_id);
        }

        $d = $d->whereYear('insiden.tanggal_insiden', $y)->get();

        // if the gradingColor is not in the $d data, set the total to 0
        $d = $gradingColor->map(function ($color) use ($d) {
            $total = $d->where('grading_risiko', $color)->first();
            return [
                'grading_risiko' => $color,
                'total' => $total ? $total->total : 0,
            ];
        });

        $widgets = [];

        foreach ($d as $item) {
            $widgets[] = Stat::make($item['grading_risiko'], $item['total'])
                ->view('filament.widgets.custom-stats', [
                    'label' => $item['grading_risiko'],
                    'value' => $item['total'],
                    'tahun' => $y,
                ]);
        }

        return $widgets;
    }
}
