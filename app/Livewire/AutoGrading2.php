<?php

namespace App\Livewire;

use Livewire\Component;
use App\Helpers\AutoGradingHelper;

class AutoGrading2 extends Component
{
    public $jenis_insiden_id;
    public $unit_id;
    public $dampak_insiden;

    public $riskGrading;
    public $autoColor;
    public $classes = [];

    protected $listeners = ['updateAutoGradingState' => 'updateState'];

    public function mount($jenis_insiden_id, $unit_id, $dampak_insiden)
    {
        $this->jenis_insiden_id = $jenis_insiden_id;
        $this->unit_id = $unit_id;
        $this->dampak_insiden = $dampak_insiden;

        $this->updateGrading();
    }

    public function updateState($d)
    {
         $this->jenis_insiden_id = $d['jenis_insiden_id'];
         $this->unit_id = $d['unit_id'];
         $this->dampak_insiden = $d['dampak_insiden'];

         $this->updateGrading();
    }

    public function updateGrading()
    {
        if ($this->jenis_insiden_id && $this->unit_id && $this->dampak_insiden) {
            $probabilitas = AutoGradingHelper::getProbabilityLevel($this->jenis_insiden_id, $this->unit_id);
            $impact = AutoGradingHelper::getImpactLevel($this->dampak_insiden);

            $this->riskGrading = AutoGradingHelper::getRiskGrading($probabilitas, $impact);
            $this->autoColor = AutoGradingHelper::riskGradingToColor($this->riskGrading);

            $this->determineColor();
        }
    }

    public function render()
    {
        return view('livewire.auto-grading2', [
            'riskGrading' => $this->riskGrading
        ]);
    }





    public function determineColor()
    {
        $alertClasses = [
            'Rendah'  => 'bg-sky-100 dark:bg-sky-800 border-sky-300',
            'Moderat' => 'bg-emerald-100 dark:bg-emerald-800 border-emerald-300',
            'Tinggi'  => 'bg-amber-100 dark:bg-amber-800 border-amber-300',
            'Ekstrim' => 'bg-rose-100 dark:bg-rose-800 border-rose-300',
        ];

        $iconClasses = [
            'Rendah'  => 'bg-sky-50 border-sky-500 text-sky-500',
            'Moderat' => 'bg-emerald-50 border-emerald-500 text-emerald-500',
            'Tinggi'  => 'bg-amber-50 border-amber-500 text-amber-500',
            'Ekstrim' => 'bg-rose-50 border-rose-500 text-rose-500',
        ];

        $titleClasses = [
            'Rendah'  => 'text-sky-800 dark:text-sky-200',
            'Moderat' => 'text-emerald-800 dark:text-emerald-200',
            'Tinggi'  => 'text-amber-800 dark:text-amber-200',
            'Ekstrim' => 'text-rose-800 dark:text-rose-200',
        ];

        $bodyClasses = [
            'Rendah'  => 'text-sky-600 dark:text-sky-300',
            'Moderat' => 'text-emerald-600 dark:text-emerald-300',
            'Tinggi'  => 'text-amber-600 dark:text-amber-300',
            'Ekstrim' => 'text-rose-600 dark:text-rose-300',
        ];

        $this->classes = [
            'alertClasses' => $alertClasses[$this->riskGrading],
            'iconClasses'  => $iconClasses[$this->riskGrading],
            'titleClasses' => $titleClasses[$this->riskGrading],
            'bodyClasses'  => $bodyClasses[$this->riskGrading],
        ];
    }
}
