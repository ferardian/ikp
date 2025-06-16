<?php

namespace App\Livewire;

use App\Settings\GeneralSettings;
use Livewire\Component;

class JuknisModal extends Component
{
    public $juknisUrl;

    public function mount()
    {
        $settings = app(GeneralSettings::class);
        $this->juknisUrl = $settings->juknis ? asset('storage/' . $settings->juknis) : asset('juknis/juknis.pdf');
    }

    public function render()
    {
        return view('livewire.juknis-modal');
    }
}
