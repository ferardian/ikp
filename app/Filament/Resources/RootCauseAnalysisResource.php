<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RootCauseAnalysisResource\Pages;
use App\Models\Insiden;
use App\Models\RootCauseAnalysis;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class RootCauseAnalysisResource extends Resource
{
    protected static ?string $model = RootCauseAnalysis::class;

    protected static ?string $navigationLabel = "RCA";

    protected static ?string $slug = 'rca';

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Step::make('menentukan_investigator')
                        ->label('Investigator')
                        ->description('Menentukan Investigator')
                        ->schema(\App\Filament\Resources\RootCauseAnalysisResource\Forms\RCAInvestigator::make()),

                    Step::make('data_dan_informasi')
                        ->label('Data & Informasi')
                        ->description('Data & Informasi Terkait')
                        ->schema(\App\Filament\Resources\RootCauseAnalysisResource\Forms\InformasiTerkait::make()),

                    Step::make('peta_kronologi_kejadian')
                        ->label('Kronologi Kejadian')
                        ->description('Peta Kronologi Kejadian')
                        ->schema(\App\Filament\Resources\RootCauseAnalysisResource\Forms\PetaKronologiKejadian::make()),

                    Step::make('identifikasi_masalah')
                        ->label('Identifikasi Masalah')
                        ->description('Masalah Pelayanan / CMP')
                        ->schema(\App\Filament\Resources\RootCauseAnalysisResource\Forms\IdentifikasiMasalah::make()),

                    Step::make('formulir_analisis')
                        ->label('Formulir Analisis')
                        ->description('Analisis perubahan dan penghalang')
                        ->schema(\App\Filament\Resources\RootCauseAnalysisResource\Forms\FormulirAnalisis::make()),

                    Step::make('rekomendasi_dan_rencana_tindakan')
                        ->label('Rekomendasi & Tindakan')
                        ->description('Rekomendasi & Rencana Tindakan')
                        ->schema(\App\Filament\Resources\RootCauseAnalysisResource\Forms\RekomendasiDanRencanaTindakan::make()),

                    Step::make('ringkasan_rca')
                        ->label('Ringkasan RCA')
                        ->description('Ringkasan detail input RCA')
                        ->schema(\App\Filament\Resources\RootCauseAnalysisResource\Forms\RingkasanRCA::make()),
                ])->label('Root Cause Analysis')
                ->extraAlpineAttributes([
                    '@step-menentukan-investigator.window' => "step='menentukan_investigator'",
                    '@step-data-dan-informasi.window' => "step='data_dan_informasi'",
                    '@step-peta-kronologi-kejadian.window' => "step='peta_kronologi_kejadian'",
                    '@step-identifikasi-masalah.window' => "step='identifikasi_masalah'",
                    '@step-formulir-analisis.window' => "step='formulir_analisis'",
                    '@step-rekomendasi-dan-rencana-tindakan.window' => "step='rekomendasi_dan_rencana_tindakan'",
                    '@step-ringkasan-rca.window' => "step='ringkasan_rca'",
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('insiden.insiden')
                    ->label('Insiden')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('ketua.name')
                    ->label('Ketua Tim')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('members')
                    ->label('Jml Anggota')
                    ->badge()->color('gray')
                    ->getStateUsing(fn ($record) => is_array($record->members) ? count($record->members) : 0)
                    ->sortable(),

                // mulai investigasi
                TextColumn::make('tanggal_mulai_investigasi')
                    ->label('Mulai Investigasi')
                    ->date()
                    ->sortable(),

                // selesai investigasi
                TextColumn::make('tanggal_selesai_dilengkapi')
                    ->label('Selesai Investigasi')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordAction(ViewAction::class)
            ->recordUrl(fn($record): string => RootCauseAnalysisResource::getUrl('view', ['record' => $record]))
            ->actions([
                Action::make('edit')
                    ->label('Edit')
                    ->icon('heroicon-s-pencil-square')
                    ->url(fn (RootCauseAnalysis $record) => RootCauseAnalysisResource::getUrl('edit', ['record' => $record, 'insiden' => $record->insiden_id])),

                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['insiden', 'ketua', 'notulen', 'kepalaIgd']);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRootCauseAnalyses::route('/'),
            'create' => Pages\CreateRootCauseAnalysis::route('/create'),
            'view' => Pages\ViewRootCauseAnalysisResource::route('/{record}'),
            'edit' => Pages\EditRootCauseAnalysis::route('/{record}/edit'),
        ];
    }





    public static function afterValidationMenentukanInvestigator($state, $set, $get, $livewire): void
    {
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
    }

    public static function afterValidationIdentifikasiMasalah($state, $set, $get, $livewire)
    {
        // Update record di livewire agar tetap tersinkronisasi
        // $this->record->update($state);

        $livewire->record->update($state);
    }
}
