<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InsidenResource\Pages;
use App\Helpers\AutoGradingHelper;
use App\Models\Grading;
use App\Models\Insiden;

use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Section;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Blade;
use Filament\Forms\Components\Wizard;
use Filament\Support\Exceptions\Halt;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard\Step;
use Filament\Notifications\Livewire\Notifications as LivewireNotifications;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;

class InsidenResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = Insiden::class;

    protected static ?string $navigationIcon = 'heroicon-o-exclamation-triangle';

    // Properti statis untuk menyimpan data insiden pada unit yang sama
    public static $insidenPadaUnitYangSama = [];

    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'view_only_unit',
            'create',
            'update',
            'restore',
            'restore_any',
            'replicate',
            'reorder',
            'delete',
            'delete_any',
            'force_delete',
            'force_delete_any'
        ];
    }

    public static function form(Form $form): Form
    {
        if ($form->getOperation() == 'edit') {
            // TODO : perbaiki autograding ketika edit karena ada perubahan alur edit

            $record = $form->getRecord();
            self::updateInsidenUnitData($record->unit_id, $record->id);

            return $form->schema([

                Section::make('Detail Insiden')
                    ->description("Detail Insiden")
                    ->collapsible()
                    ->collapsed()
                    ->schema(\App\Filament\Resources\InsidenResource\Forms\DetailInsiden::make()),

                Section::make('Tindakan dan Grading')
                    ->description("Tindakan dan Grading Insiden")
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        ...\App\Filament\Resources\InsidenResource\Forms\TindakanInsiden::make(),
                        ...\App\Filament\Resources\InsidenResource\Forms\GradingInsiden::make()
                    ]),

            ]);
        } else {
            return $form
                ->schema([
                    Wizard::make([


                        Step::make('detail-insiden')
                            ->label('Detail Insiden')
                            ->schema(\App\Filament\Resources\InsidenResource\Forms\DetailInsiden::make())
                            ->afterValidation(fn($state, $set, $get, $livewire) => self::afterValidationStepPasien($state, $set, $get, $livewire)),

                        Step::make('tindakan-pasca-insiden')
                            ->label('Tindakan dan Grading')
                            ->schema([
                                ...\App\Filament\Resources\InsidenResource\Forms\TindakanInsiden::make(),
                                ...\App\Filament\Resources\InsidenResource\Forms\GradingInsiden::make()
                            ])
                            ->afterValidation(fn($state) => self::afterValidationStepTindakanInsiden($state)),
                    ])->extraAlpineAttributes([
                                '@step-pasien.window' => "step='pasien'",
                                '@step-detail-insiden.window' => "step='detail-insiden'",
                                '@step-tindakan-insiden.window' => "step='tindakan-insiden'",
                            ])->submitAction(new HtmlString(Blade::render(<<<BLADE
                    <x-filament::button
                        type="submit"
                        size="sm" >
                        Submit
                    </x-filament::button>
                    BLADE
                                )))->columnSpanFull(),
                ]);
        }
    }

    public static function table(Table $table): Table
    {
        // dd(auth()->user());
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('insiden')
                    ->searchable()
                    ->tooltip(function (Insiden $record) {
                        $diff = $record->created_at->diff($record->tanggal_insiden);
                        $diffFormatted = '';

                        if ($diff->y > 0) {
                            $diffFormatted .= $diff->y . ' tahun ';
                        }

                        if ($diff->m > 0) {
                            $diffFormatted .= $diff->m . ' bulan ';
                        }

                        $diffFormatted .= $diff->d . ' hari ';
                        $diffFormatted .= $diff->h . ' jam ';
                        $diffFormatted .= $diff->i . ' menit';

                        $diffHours = abs($record->created_at->diffInHours($record->tanggal_insiden));

                        return $diffHours >= 24
                            ? 'Dibuat setelah ' . $diffFormatted
                            : null;
                    })->color(
                        fn(Insiden $record) =>
                        abs($record->created_at->diffInHours($record->tanggal_insiden)) >= 24
                        ? 'danger'
                        : null
                    )->limit(35)
                    ->description(function (Insiden $record) {
                        if ($record->pasien) {
                            return "Pasien : " . $record->pasien->nm_pasien;
                        } else {
                            return "Pasien : " . $record->nm_pasien;
                        }
                    }),
                Tables\Columns\TextColumn::make('rca')
                    ->label("RCA")
                    ->searchable()
                    ->view('filament.tables.columns.has-rca'),
                Tables\Columns\TextColumn::make('jenis.alias')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->badge()
                    ->color('gray'),
                Tables\Columns\TextColumn::make('dampak_insiden')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->formatStateUsing(fn(string $state): string => Str::upper($state)),
                Tables\Columns\TextColumn::make('tanggal_insiden')
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->formatStateUsing(fn(string $state): string => \Carbon\Carbon::parse($state)->translatedFormat('D, d M Y'))
                    ->description(fn(Insiden $record) => 'Pukul : ' . $record->waktu_insiden),
                Tables\Columns\TextColumn::make('tempat_kejadian')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false)
                    ->description(fn(Insiden $record) => 'Unit : ' . substr($record->unit->nama_unit, 0, 15) . " . . ."),
                Tables\Columns\TextColumn::make('grading.grading_risiko')
                    ->badge()
                    ->color(fn(Insiden $record) => match ($record->grading->grading_risiko) {
                        'Biru' => 'primary',
                        'Hijau' => 'success',
                        'Kuning' => 'warning',
                        'Merah' => 'danger'
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis')
                    ->options(fn() => \App\Models\JenisInsiden::pluck('alias', 'id')->toArray())
                    ->label('Jenis Insiden'),
                \App\Filament\Resources\InsidenResource\Filters\DampakInsiden::make(),
                \App\Filament\Resources\InsidenResource\Filters\GradingInsiden::make(),
                Tables\Filters\SelectFilter::make('hasRca')
                    ->label('RCA')
                    ->options([
                        'ada' => 'Ada',
                        'tidak' => 'Tidak Ada'
                    ])
                    ->query(function (Builder $query, array $data) {
                        if (empty($data['value'])) {
                            return $query;
                        }

                        if ($data['value'] == 'ada') {
                            return $query->whereHas('rca');
                        } else if ($data['value'] == 'tidak') {
                            return $query->whereDoesntHave('rca');
                        } else {
                            return $query;
                        }
                    }),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->recordAction(Tables\Actions\ViewAction::class)
            ->recordUrl(fn($record): string => InsidenResource::getUrl('view', ['record' => $record]))
            ->headerActions([
                \pxlrbt\FilamentExcel\Actions\Tables\ExportAction::make()
                    ->exports([
                        \pxlrbt\FilamentExcel\Exports\ExcelExport::make()->withColumns(self::getColumnsExport())
                    ])
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\RestoreAction::make()
                    ->after(function (Insiden $record) {
                        $record->grading()->restore();
                    }),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('Investigasi')
                        ->icon('heroicon-o-magnifying-glass-circle')
                        ->url(function (Insiden $record) {
                            $investigasi = \App\Models\InvestigasiSederhana::where('insiden_id', $record->id)->first();
                            return $investigasi
                                ? InvestigasiSederhanaResource::getUrl('edit', ['record' => $investigasi->getKey()])
                                : InvestigasiSederhanaResource::getUrl('create', ['insiden' => $record->id]);
                        })
                        ->disabled(fn(Insiden $record) => !$record->grading),

                    Tables\Actions\Action::make('Update Grading')
                        ->icon('heroicon-o-swatch')
                        ->visible(fn(Insiden $record) => !$record->trashed())
                        ->url(fn(Insiden $record) => InsidenResource::getUrl('update-grading', ['record' => $record])),
                    Tables\Actions\Action::make('rca')
                        ->label(fn(Insiden $record) => $record->rca ? 'Edit RCA' : 'Buat RCA')
                        ->icon('heroicon-o-document-text')
                        ->authorize(function ($record) {
                            if ($record->rca) {
                                return Gate::allows('update_root::cause::analysis', $record->rca);
                            } else {
                                return Gate::allows('create_root::cause::analysis', $record);
                            }
                        })
                        ->url(fn(Insiden $record) => $record->rca ? RootCauseAnalysisResource::getUrl('edit', ['record' => $record->rca, 'insiden' => $record->id]) : RootCauseAnalysisResource::getUrl('create', ['insiden' => $record->id])),

                    Tables\Actions\Action::make('Print')
                        ->icon('heroicon-o-printer')
                        ->url(fn(Insiden $record) => route('insiden.print', ['insiden' => $record->id]), true)
                        ->visible(fn(Insiden $record) => !$record->trashed()),



                    Tables\Actions\DeleteAction::make()
                        ->before(function (Insiden $record, Tables\Actions\DeleteAction $action) {

                            if ($record->rca || $record->investigasi_sederhana) {
                                Notification::make()->warning()
                                    ->title('Peringatan')
                                    ->body('Insiden ini memiliki RCA atau Investigasi Sederhana, sehingga tidak dapat dihapus!')
                                    ->icon('heroicon-s-exclamation-triangle')

                                    ->send();
                                $action->halt();
                                return false;
                            }
                        })
                        ->after(function (Insiden $record) {
                            $record->rca()->delete();
                            $record->grading()->delete();
                        }),
                    Tables\Actions\ForceDeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function (Collection $records, Tables\Actions\DeleteBulkAction $action) {

                            foreach ($records as $record) {
                                if ($record->rca || $record->investigasi_sederhana) {
                                    Notification::make()->warning()
                                        ->title('Peringatan')
                                        ->body('Insiden ini memiliki RCA atau Investigasi Sederhana, sehingga tidak dapat dihapus!')
                                        ->icon('heroicon-s-exclamation-triangle')
                                        ->send();
                                    $action->halt();
                                    return false;
                                }
                            }
                        })
                        ->after(function (Collection $records) {
                            foreach ($records as $record) {
                                $record->rca()->delete();
                                $record->grading()->delete();
                            }
                        }),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
                \pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction::make()
                    ->exports([
                        \pxlrbt\FilamentExcel\Exports\ExcelExport::make()->withColumns(self::getColumnsExport())
                    ])
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    // public static function getRedirectUrlInvestigasi(): string
    // {
    //     $insidenId = request('insiden');

    //     if ($insidenId && $existing = \App\Models\InvestigasiSederhana::where('insiden_id', $insidenId)->first()) {
    //         return static::getUrl('edit', ['record' => $existing->id]);
    //     }

    //     return parent::getRedirectUrlInvestigasi();
    // }

    public static function getEloquentQuery(): Builder
    {
        // $query = parent::getEloquentQuery()
        //     ->with(['pasien.penanggungBiaya', 'jenis', 'unit', 'grading', 'tindakan', 'rca']);
        $query = parent::getEloquentQuery()
            ->with(['pasien', 'jenis', 'unit', 'grading', 'tindakan', 'rca']);

        // Jika user adalah pegawai, batasi data berdasarkan unitnya
        if (auth()->check() && auth()->user()->can('view_only_unit_insiden')) {
            $query->where('unit_id', auth()->user()?->detail?->unit_id);
        }

        return $query->orderBy('tanggal_insiden', 'DESC')->orderBy('waktu_insiden', 'DESC');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInsidens::route('/'),
            'create' => Pages\CreateInsiden::route('/create'),
            'view' => Pages\ViewInsiden::route('/{record}'),
            'edit' => Pages\EditInsiden::route('/{record}/edit'),
            'update-grading' => Pages\UpdateGrading::route('/{record}/update-grading'),
        ];
    }

    public static function getColumnsExport(): array
    {
        return [
            \pxlrbt\FilamentExcel\Columns\Column::make('insiden')
                ->heading('Insiden'),
            \pxlrbt\FilamentExcel\Columns\Column::make('tanggal_insiden')
                ->heading('Tanggal Insiden')
                ->formatStateUsing(fn($state): string => $state->translatedFormat('l, d M Y')),
            \pxlrbt\FilamentExcel\Columns\Column::make('waktu_insiden')
                ->heading('Waktu Insiden'),
            \pxlrbt\FilamentExcel\Columns\Column::make('\n.nama')
                ->heading('Nama Pasien'),
            \pxlrbt\FilamentExcel\Columns\Column::make('tgl_pasien_masuk')
                ->heading('Tanggal Pasien Masuk')
                ->formatStateUsing(fn($state): string => $state->translatedFormat('l, d M Y')),
            \pxlrbt\FilamentExcel\Columns\Column::make('pasien.penanggungBiaya.jenis_penanggung')
                ->heading('Penanggung Biaya'),
            \pxlrbt\FilamentExcel\Columns\Column::make('jenis.alias')
                ->heading('Jenis Insiden'),
            \pxlrbt\FilamentExcel\Columns\Column::make('kronologi'),
            \pxlrbt\FilamentExcel\Columns\Column::make('jenis_pelapor')
                ->heading('Orang Pertama Yang Melaporkan'),
            \pxlrbt\FilamentExcel\Columns\Column::make('korban_insiden')
                ->heading('Korban Insiden'),
            \pxlrbt\FilamentExcel\Columns\Column::make('layanan_insiden')
                ->heading('Insiden Menyangkut Pasien')
                ->formatStateUsing(fn(string $state): string => strtoupper($state)),
            \pxlrbt\FilamentExcel\Columns\Column::make('kasus_insiden')
                ->heading('Kasus Insiden')
                ->formatStateUsing(fn(string $state): string => Str::replace("-", " ", Str::replace(",", ', ', $state))),
            \pxlrbt\FilamentExcel\Columns\Column::make('tempat_kejadian')
                ->heading('Tempat Kejadian'),
            \pxlrbt\FilamentExcel\Columns\Column::make('unit.nama_unit')
                ->heading('Unit'),
            \pxlrbt\FilamentExcel\Columns\Column::make('dampak_insiden')
                ->heading('Dampak Insiden')
                ->formatStateUsing(fn(string $state): string => strtoupper($state)),
            \pxlrbt\FilamentExcel\Columns\Column::make('status_pelapor')
                ->heading('Status Pelapor'),
            // \pxlrbt\FilamentExcel\Columns\Column::make('tindakan.content')
            //     ->formatStateUsing(fn (string $state): string => $state ? "✅" : "❌")
            //     ->heading('Tindakan Pasca Insiden'),
            // \pxlrbt\FilamentExcel\Columns\Column::make('tindakan.oleh')
            //     ->heading('Tindakan Dilakukan Oleh Oleh')
            //     ->formatStateUsing(function (string $state, $record) {
            //         if (in_array($state, ['tim', 'petugas'])) {
            //             return Str::title($state) . " : " . $record->tindakan->detail;
            //         } else {
            //             return Str::title($state);
            //         }
            //     }),
            \pxlrbt\FilamentExcel\Columns\Column::make('grading.grading_risiko')
                ->heading('Grading Risiko'),
            \pxlrbt\FilamentExcel\Columns\Column::make('grading.oleh.name')
                ->heading('Grading Dilakukan Oleh'),
            \pxlrbt\FilamentExcel\Columns\Column::make('created_at')
                ->heading('Diajukan Pada')
                ->formatStateUsing(fn(string $state): string => \Carbon\Carbon::parse($state)->translatedFormat('l, d M Y H:i:s')),
            \pxlrbt\FilamentExcel\Columns\Column::make('oleh.name')
                ->heading('Diajukan Oleh'),
            \pxlrbt\FilamentExcel\Columns\Column::make('updated_at')
                ->heading('Terakhir Diupdate')
                ->formatStateUsing(fn(string $state): string => \Carbon\Carbon::parse($state)->translatedFormat('l, d M Y H:i:s')),
        ];
    }

    public static function afterValidationStepPasien($state, $set, $get, $livewire): void
    {
        $livewire->dispatch('updateAutoGradingState', [
            'jenis_insiden_id' => $state['jenis_insiden_id'],
            'unit_id' => $state['unit_id'],
            'dampak_insiden' => $state['dampak_insiden'],
        ]);

        $set('auto_grading_color', AutoGradingHelper::riskGradingToColor(
            AutoGradingHelper::getRiskGrading(
                AutoGradingHelper::getProbabilityLevel($state['jenis_insiden_id'], $state['unit_id']),
                AutoGradingHelper::getImpactLevel($state['dampak_insiden'])
            )
        ));

        $set('grading_risiko', ucfirst(AutoGradingHelper::riskGradingToColor(
            AutoGradingHelper::getRiskGrading(
                AutoGradingHelper::getProbabilityLevel($state['jenis_insiden_id'], $state['unit_id']),
                AutoGradingHelper::getImpactLevel($state['dampak_insiden'])
            )
        )));

        self::updateInsidenUnitData($state['unit_id']);
    }

    public static function afterValidationStepTindakanInsiden($state): void
    {
        if (Str::lower($state['auto_grading_color']) != Str::lower($state['grading_risiko'])) {
            \Filament\Notifications\Notification::make()
                ->warning()
                ->title('Grading Risiko Tidak Sesuai')
                ->body('Grading Risiko yang diinput tidak sesuai dengan Grading Risiko yang dihasilkan')
                ->actions([
                    \Filament\Notifications\Actions\Action::make('continue')
                        ->label('Lanjutkan')
                        ->button()->close()
                        ->dispatch('step-validasi-dan-kirim-laporan'),
                    \Filament\Notifications\Actions\Action::make('cancel')
                        ->label('Batal')
                        ->color('gray')
                        ->close(),
                ])->persistent()->send();

            throw new Halt();
        }
    }

    // Metode untuk memperbarui data
    public static function updateInsidenUnitData($unitId, $recordId = null)
    {
        if (!$unitId) {
            static::$insidenPadaUnitYangSama = [];
            return;
        }

        $query = Insiden::with(['jenis', 'unit'])
            ->where('unit_id', $unitId)
            ->orderBy('tanggal_insiden', 'DESC')
            ->limit(5);

        if ($recordId) {
            $query->where('id', '!=', $recordId);
        }

        static::$insidenPadaUnitYangSama = $query->get();
    }

    public static function getInsidenPadaUnitYangSama()
    {
        return static::$insidenPadaUnitYangSama;
    }
}
