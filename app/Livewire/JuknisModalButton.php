<?php

namespace App\Livewire;

use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Actions\Action;
use Filament\Forms\Contracts\HasForms;
use Livewire\Component;

class JuknisModalButton extends Component implements HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;

    public function juknis(): Action
    {
        return Action::make('juknis')
            ->color('primary')
            ->label('Lihat Juknis')
            ->keyBindings(['command+m', 'ctrl+m'])
            ->extraAttributes(['class' => 'w-full'])
            ->icon('heroicon-o-document-text')
            ->dispatch('open-modal', [
                'modal' => 'edit-user',
                'id' => 'edit-user',
            ]);
    }

    public function render(): string
    {
        return <<<'HTML'
            <div class="space-y-2">
                {{ $this->juknis() }}
            </div>
        HTML;
    }

}
