<?php

namespace App\Filament\Resources\InsidenResource\Pages;

use App\Models\Insiden;
use Filament\Forms\Form;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use App\Helpers\AutoGradingHelper;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use App\Filament\Resources\InsidenResource;
use Filament\Forms\Concerns\InteractsWithForms;

class UpdateGrading extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = InsidenResource::class;

    protected static string $view = 'filament.pages.update-grading';

    public ?array $data = [];

    public Insiden $record;

    public Collection $insidenPadaUnitYangSama;

    public function mount(Insiden $record): void
    {
        $this->record = $record;

        // insiden pada unit yang sama
        $this->insidenPadaUnitYangSama = Insiden::with(['jenis', 'unit'])->where('unit_id', $record->unit_id)
            ->where('id', '!=', $record->id)
            ->orderBy('tanggal_insiden', 'DESC')
            ->limit(5)
            ->get();

        // Fill form dengan data yang sudah ada jika ada
        if ($record->grading) {
            $this->form->fill([
                'grading_risiko' => $record->grading->grading_risiko,
            ]);
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make("Grading Risiko Insiden")
                    ->description("Grading risiko insiden ini akan digunakan untuk menentukan tindak lanjut insiden.")
                    ->schema([
                        Radio::make('grading_risiko')
                            ->label('Grading Risiko')
                            ->options([
                                'Biru' => 'Biru',
                                'Hijau' => 'Hijau',
                                'Kuning' => 'Kuning',
                                'Merah' => 'Merah',
                            ])
                            ->inline()
                            ->view('filament.inputs.grading-radio', [
                                'insidenPadaUnitYangSama' => $this->insidenPadaUnitYangSama,
                            ])
                            ->required(),
                    ])
            ])
            ->statePath('data');
    }

    public function confirmSave()
    {
        $probabilitas = AutoGradingHelper::getProbabilityLevel($this->record->jenis_insiden_id, $this->record->unit_id);
        $impact       = AutoGradingHelper::getImpactLevel($this->record->dampak_insiden);
        $riskGrading  = AutoGradingHelper::getRiskGrading($probabilitas, $impact);
        $autoColor    = AutoGradingHelper::riskGradingToColor($riskGrading);

        $data = $this->form->getState();

        if (Str::lower($data['grading_risiko']) != Str::lower($autoColor)) {
            $this->dispatch('open-modal', id: 'confirm-save');
        } else {
            $this->save();
        }
    }

    public function save()
    {
        $data = $this->form->getState();

        \App\Models\Grading::updateOrCreate(
            ['insiden_id' => $this->record->id],
            [
                'grading_risiko' => $data['grading_risiko'],
                'created_by' => auth()->id(),
            ]
        );

        Notification::make()
            ->success()
            ->title('Grading berhasil disimpan')
            ->send();

        return redirect()->to(InsidenResource::getUrl('index'));
    }
}
