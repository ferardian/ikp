<?php

namespace App\Filament\Resources\RootCauseAnalysisResource\Pages;

use App\Filament\Resources\InsidenResource;
use App\Filament\Resources\RootCauseAnalysisResource;
use App\Models\Insiden;
use App\Models\RootCauseAnalysis;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Wizard\Step;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditRootCauseAnalysis extends EditRecord
{
    use EditRecord\Concerns\HasWizard;

    protected static string $resource = RootCauseAnalysisResource::class;

    protected static ?string $title = "Edit RCA";

    protected static string $view = 'filament.pages.edit-rca';

    public ?Insiden $insiden = null;

    public function mount(int|string $record): void
    {
        parent::mount($record);

        if(request()->has('insiden')) {
            $data = Insiden::with('unit', 'rca')->find(request()->insiden);
            if (!$data) {
                Notification::make()->title('Insiden tidak ditemukan!')
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
        }
    }

    protected function getSteps(): array
    {
        return [
            Step::make('menentukan_investigator')
                ->label('Investigator')
                ->description('Menentukan Investigator')
                ->schema(\App\Filament\Resources\RootCauseAnalysisResource\Forms\RCAInvestigator::make())
                ->afterValidation(function ($state, $set, $get, $livewire) {
                    $insidenId = $get('insiden_id');

                    if (!$insidenId) {
                        Notification::make()
                            ->title('Insiden ID tidak ditemukan!')
                            ->danger()
                            ->send();
                        return;
                    }

                    // Cek apakah sudah ada RCA berdasarkan insiden_id
                    $rca = RootCauseAnalysis::where('insiden_id', $insidenId)->first();

                    if ($rca) {
                        // Update data yang sudah ada
                        $rca->update($state);
                    } else {
                        // Buat RCA baru jika belum ada
                        $rca = new RootCauseAnalysis($state);
                        $rca->insiden_id = $insidenId;
                        $rca->save();
                    }

                    // Update record di livewire agar tetap tersinkronisasi
                    $livewire->record = $rca;
                }),

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

            Step::make('formulir_analisis')
                ->label('Formulir Analisis')
                ->description('Analisis perubahan dan penghalang')
                ->schema(\App\Filament\Resources\RootCauseAnalysisResource\Forms\FormulirAnalisis::make())
                ->afterValidation(function ($state, $set, $get, $livewire) {
                    $this->record->update($state);
                }),

            Step::make('ringkasan_rca')
                ->label('Ringkasan RCA')
                ->description('Ringkasan detail input RCA')
                ->schema(\App\Filament\Resources\RootCauseAnalysisResource\Forms\RingkasanRCA::make()),
        ];
    }

    public function save(bool $shouldRedirect = true, bool $shouldSendSavedNotification = true): void
    {
        $data = $this->form->getState();

        if (!$this->insiden?->id) {
            Notification::make()
                ->title('Insiden ID tidak ditemukan!')
                ->danger()
                ->send();

            $this->redirect(InsidenResource::getUrl('index'));
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

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
