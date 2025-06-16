<?php

namespace App\Livewire;

use App\Models\Insiden;
use Livewire\Component;
use App\Helpers\AutoGradingHelper;

class AutoGrading extends Component
{
    public Insiden|array|null $insiden;

    public $probabilitas;

    public $impact;

    public $riskGrading;

    public string $autoColor;


    public function mount(Insiden|array|null $insiden)
    {
        $this->insiden = $insiden;

        if ($this->insiden) {
            $this->getAutoGrading();
        }
    }

    public function render()
    {
        return view('livewire.auto-grading');
    }

    public function getAutoGrading()
    {
        // if insiden not array convert to array
        if (!is_array($this->insiden)) {
            $this->insiden = $this->insiden->toArray();
        }

        $this->probabilitas = AutoGradingHelper::getProbabilityLevel($this->insiden['jenis_insiden_id'], $this->insiden['unit_id']);
        $this->impact       = AutoGradingHelper::getImpactLevel($this->insiden['dampak_insiden']);
        $this->riskGrading  = AutoGradingHelper::getRiskGrading($this->probabilitas, $this->impact);
        $this->autoColor    = AutoGradingHelper::riskGradingToColor($this->riskGrading);
    }
}
