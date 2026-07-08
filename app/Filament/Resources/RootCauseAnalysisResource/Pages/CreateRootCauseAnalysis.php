<?php

namespace App\Filament\Resources\RootCauseAnalysisResource\Pages;

use App\Filament\Resources\InsidenResource;
use App\Filament\Resources\RootCauseAnalysisResource;
use App\Models\Insiden;

use App\Models\RootCauseAnalysis;
use Filament\Forms\Components\Wizard\Step;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateRootCauseAnalysis extends CreateRecord
{
    use CreateRecord\Concerns\HasWizard;

    protected static ?string $title = "Buat RCA";

    protected static string $view = 'filament.pages.create-rca';

    protected static string $resource = RootCauseAnalysisResource::class;

    public ?Insiden $insiden = null;

    public function mount(): void
    {
        parent::mount();

        if(request()->has('insiden')) {
            $data = Insiden::with('unit', 'rca')->find(request()->insiden);
            if (!$data) {
                Notification::make()->title('Insiden tidak ditemukan!')
                    ->body("Sepertinya ada yang salah, silahkan coba lagi")
                    ->danger()->send();

                redirect()->to(InsidenResource::getUrl('index'));
            } else {
                $this->insiden = $data;

                $formData = [
                    'insiden_id' => $data->id,
                    'insiden' => $data->insiden,
                    'dampak' => $data->dampak_insiden,
                    'tanggal_insiden' => $data->tanggal_insiden,
                    'waktu_insiden' => $data->waktu_insiden,
                    'tgl_pasien_masuk' => $data->tgl_pasien_masuk
                ];

                if($data->rca) {
                    $formData = array_merge($formData, $data->rca->toArray());
                }

                $this->form->fill($formData);
            }
        } else {
            Notification::make()->title('Insiden tidak ditemukan!')
                ->body("sepertinya anda lupa memilih insiden")
                ->danger()->send();

            redirect()->to(InsidenResource::getUrl('index'));
        }
    }

    protected function getSteps(): array
    {
        return [
            Step::make('menentukan_investigator')
                ->label('Investigator')
                ->description('Menentukan Investigator')
                ->schema(\App\Filament\Resources\RootCauseAnalysisResource\Forms\RCAInvestigator::make())
                ->afterValidation(fn ($state, $set, $get, $livewire) => RootCauseAnalysisResource::afterValidationMenentukanInvestigator($state, $set, $get, $livewire)),

            Step::make('data_dan_informasi')
                ->label('Data & Informasi')
                ->description('Data & Informasi Terkait')
                ->schema(\App\Filament\Resources\RootCauseAnalysisResource\Forms\InformasiTerkait::make())
                ->afterValidation(function ($state, $set, $get, $livewire) {
                    $this->record->update($state);
                }),

            Step::make('peta_kronologi_kejadian')
                ->label('Kronologi Kejadian')
                ->description('Peta Kronologi Kejadian')
                ->schema(\App\Filament\Resources\RootCauseAnalysisResource\Forms\PetaKronologiKejadian::make())
                ->afterValidation(function ($state, $set, $get, $livewire) {
                    $this->record->update($state);
                }),

            Step::make('identifikasi_masalah')
                ->label('Identifikasi Masalah')
                ->description('Masalah Pelayanan / CMP')
                ->schema(\App\Filament\Resources\RootCauseAnalysisResource\Forms\IdentifikasiMasalah::make())
                ->afterValidation(fn ($state, callable $set, callable $get, $livewire) => RootCauseAnalysisResource::afterValidationIdentifikasiMasalah($state, $set, $get, $livewire)),

            Step::make('formulir_analisis')
                ->label('Formulir Analisis')
                ->description('Analisis perubahan dan penghalang')
                ->schema(\App\Filament\Resources\RootCauseAnalysisResource\Forms\FormulirAnalisis::make())
                ->afterValidation(function ($state, $set, $get, $livewire) {
                    $this->record->update($state);
                }),

            Step::make('rekomendasi_dan_rencana_tindakan')
                ->label('Rekomendasi & Tindakan')
                ->description('Rekomendasi & Rencana Tindakan')
                ->schema(\App\Filament\Resources\RootCauseAnalysisResource\Forms\RekomendasiDanRencanaTindakan::make())
                ->afterValidation(function ($state, $set, $get, $livewire) {
                    $this->record->update($state);
                }),

            Step::make('ringkasan_rca')
                ->label('Ringkasan RCA')
                ->description('Ringkasan detail input RCA')
                ->schema(\App\Filament\Resources\RootCauseAnalysisResource\Forms\RingkasanRCA::make()),
        ];
    }

    public function create(bool $another = false): void
    {
        $data = $this->form->getState();
        if (!$this->insiden->id) {
            Notification::make()
                ->title('Insiden ID tidak ditemukan!')
                ->danger()
                ->send();

            return;
        }

        // Cek apakah sudah ada RCA berdasarkan insiden_id
        $rca = RootCauseAnalysis::where('insiden_id', $this->insiden->id)->first();

        if ($rca) {
            $rca->update($data);
        } else {
            // Buat RCA baru jika belum ada
            $rca = new RootCauseAnalysis($data);
            $rca->insiden_id = $this->insiden->id;
            $rca->save();
        }

        $this->record = $rca;

        Notification::make()
            ->title('RCA berhasil dibuat!')
            ->success()
            ->send();

        $this->redirect(RootCauseAnalysisResource::getUrl('index'));
    }

    public function saveDraft(): void
    {
        $data = $this->form->getRawState();

        $draftData = [
            'insiden_id' => $this->insiden->id,
            'ketua_id' => $data['ketua_id'] ?? auth()->id(),
            'area_terwakili' => $data['area_terwakili'] ?? 0,
            'pengetahuan_terwakili' => $data['pengetahuan_terwakili'] ?? 0,
            'tanggal_mulai_investigasi' => $data['tanggal_mulai_investigasi'] ?? now()->format('Y-m-d'),
        ];

        $saveData = array_merge($data, $draftData);

        $rca = RootCauseAnalysis::where('insiden_id', $this->insiden->id)->first();

        if ($rca) {
            $rca->update($saveData);
        } else {
            $rca = RootCauseAnalysis::create($saveData);
        }

        $this->record = $rca;

        Notification::make()
            ->title('Draft berhasil disimpan!')
            ->success()
            ->send();
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\Action::make('saveDraft')
                ->label('Simpan Draft')
                ->color('warning')
                ->icon('heroicon-o-document-duplicate')
                ->action(fn () => $this->saveDraft()),
        ];
    }
}
