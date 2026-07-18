<?php

namespace App\Filament\Widgets;

use App\Models\Insiden;
use Filament\Widgets\Widget;
use Livewire\Attributes\On;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class InsidenLookupWidget extends Widget
{
    use InteractsWithPageFilters;

    protected static string $view = 'filament.widgets.insiden-lookup-widget';

    protected static ?int $sort = 99;

    public $isOpen = false;
    public $title = '';
    public $incidents = [];

    public $selectedIncident = null;
    public $isDetailOpen = false;

    // Set width span to full but hide standard card styling
    protected int | string | array $columnSpan = 'full';

    #[On('open-insiden-lookup')]
    public function openLookup($type, $title, $id = null, $color = null, $tahun = null)
    {
        $this->title = $title;
        $tahun = (is_array($this->filters) && isset($this->filters['tahun'])) ? $this->filters['tahun'] : ($tahun ?? now()->year);
        
        $query = Insiden::with(['pasien', 'jenis', 'unit', 'grading']);

        // Filter unit if applicable
        if (auth()->user()->can('view_only_unit_insiden')) {
            $query->where('unit_id', auth()->user()?->detail?->unit_id);
        }

        // Apply filters based on type
        switch ($type) {
            case 'total':
                // Total is overall, no year filter
                break;
            case 'tahun':
                if ($tahun) {
                    $query->whereYear('tanggal_insiden', $tahun);
                }
                break;
            case 'belum_tergrading':
                $query->whereDoesntHave('grading');
                break;
            case 'jenis':
                if ($id) {
                    $query->where('jenis_insiden_id', $id);
                }
                if ($tahun) {
                    $query->whereYear('tanggal_insiden', $tahun);
                }
                break;
            case 'grading':
                if ($color) {
                    $query->whereHas('grading', function ($q) use ($color) {
                        $q->where('grading_risiko', $color);
                    });
                }
                if ($tahun) {
                    $query->whereYear('tanggal_insiden', $tahun);
                }
                break;
        }

        $this->incidents = $query->orderBy('tanggal_insiden', 'DESC')->get()->toArray();
        $this->isOpen = true;
        $this->isDetailOpen = false;
        $this->selectedIncident = null;
    }

    public function showDetail($incidentId)
    {
        $incident = Insiden::with(['pasien', 'jenis', 'unit', 'grading', 'tindakan', 'oleh', 'penerima', 'investigasi_sederhana', 'rca'])
            ->find($incidentId);
            
        if ($incident) {
            $this->selectedIncident = $incident->toArray();
            $this->isDetailOpen = true;
        }
    }

    public function closeLookup()
    {
        $this->isOpen = false;
    }

    public function closeDetail()
    {
        $this->isDetailOpen = false;
    }
}
