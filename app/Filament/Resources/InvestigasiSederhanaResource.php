<?php

namespace App\Filament\Resources;

use App\Filament\Components\InvestigasiSederhanaForm;
use App\Filament\Components\ValidasiInvestigasiForm;
use App\Filament\Resources\InsidenResource\Forms\GradingInsiden;
use Filament\Forms;
use App\Models\User;
use Filament\Forms\Components\TextInput;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\InvestigasiSederhana;
use Filament\Forms\Components\Select;

use Illuminate\Database\Eloquent\Builder;

use App\Filament\Resources\InvestigasiSederhanaResource\Pages;
use App\Models\Insiden;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Wizard\Step;
use Filament\Resources\Pages\CreateRecord;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;

use function Laravel\Prompts\search;

class InvestigasiSederhanaResource extends Resource
{
    protected static ?string $model = InvestigasiSederhana::class;

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass-circle';

    protected static string $resource = InvestigasiSederhanaResource::class;

    public static ?Insiden $insiden = null;

    public function mount(): void
    {
        parent::mount();

        $insidenId = Request::get('insiden');

        self::$insiden = Insiden::with([
            'pasien',
            'unit',
            'grading',
            'jenisInsiden',
        ])
            ->find(Request::get('insiden'));
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (self::$insiden) {
            $data['insiden_id'] = self::$insiden->id;
        }

        return $data;
    }

    protected static function getFormDetailSchema($insiden): array
    {
        return [
            Section::make('Detail Insiden')
                ->schema([
                    Grid::make(3)->schema([
                        Placeholder::make('nama_insiden')
                            ->label('Insiden')
                            ->content($insiden->insiden ?? '-'),

                        Placeholder::make('nama')
                            ->label('Pasien')
                            ->content($insiden->pasien->nama ?? '-'),

                        Placeholder::make('jenis_insiden')
                            ->label('Jenis Insiden')
                            ->content($insiden->jenisInsiden->nama_jenis_insiden ?? '-'),

                        Placeholder::make('dampak_insiden')
                            ->label('Dampak Insiden')
                            ->content(ucfirst($insiden->dampak_insiden ?? '-')),

                        Placeholder::make('tempat_kejadian')
                            ->label('Tempat Kejadian')
                            ->content($insiden->tempat_kejadian ?? '-'),

                        Placeholder::make('tanggal_insiden')
                            ->label('Tanggal Insiden')
                            ->content(optional($insiden->tanggal_insiden ?? '-')->format('Y-m-d')),
                    ]),
                ])
        ];
    }

    public static function form(Form|null $form): Form
    {



        // if (blank($form->getModel()) && Request::has('insiden')) {
        // }

        $insidenId = self::getIdInsiden($form);
        $insiden = \App\Models\Insiden::with([
            'pasien',
            'unit',
            'grading',
            'jenisInsiden',
        ])->find($insidenId);

        return $form
            ->schema([
                ...self::getFormDetailSchema($insiden),
                ...InvestigasiSederhanaForm::schema(),
                ...ValidasiInvestigasiForm::schema($form),
                Hidden::make('insiden_id')
                    ->default(fn() => request()->get('insiden'))
                    ->dehydrated(),

            ]);
    }



    public static function getIdInsiden(Form|null $form)
    {
        if (request()->filled('insiden')) {
            return request()->get('insiden');
        }

        if (request()->filled('insiden_id')) {
            return request()->input('insiden_id');
        }

        if (request()->filled('data.insiden_id')) {
            return request()->input('data.insiden_id');
        }

        $livewire = $form?->getLivewire();
        if ($livewire && isset($livewire->data) && is_array($livewire->data) && !empty($livewire->data['insiden_id'])) {
            return $livewire->data['insiden_id'];
        }

        $record = $form?->getRecord();
        if ($record && !empty($record->insiden_id)) {
            return $record->insiden_id;
        }

        $recordRoute = request()->route('record');
        if ($recordRoute) {
            if ($recordRoute instanceof \App\Models\InvestigasiSederhana) {
                return $recordRoute->insiden_id;
            }
            if (is_numeric($recordRoute)) {
                return \App\Models\InvestigasiSederhana::find($recordRoute)?->insiden_id;
            }
        }

        return null;
    }

    // public static function canCreate(): bool
    // {

    //     return request()->has('insiden') && request()->get('insiden');
    // }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('insiden.insiden')->label('Insiden')
                    ->limit(35)
                    ->description(function (InvestigasiSederhana $record) {
                        if ($record->insiden?->pasien) {
                            return "Pasien : " . $record->insiden?->pasien?->nm_pasien;
                        } else {
                            return "Pasien : " . $record->insiden?->nm_pasien;
                        }
                    })
                    ->searchable()
                    ->sortable(),
                IconColumn::make('lengkap')->label('Lengkap')
                    ->icon(fn($state) => match ($state) {
                        'lengkap' => 'heroicon-s-check-circle',
                        'belum' => 'heroicon-s-x-circle',
                    })->color(fn($state) => match ($state) {
                        'lengkap' => 'success',
                        'belum' => 'danger',
                    })->sortable(),
                TextColumn::make('insiden.unit.nama_unit')->label('Unit')
                    ->sortable(),
                TextColumn::make('insiden.grading.grading_risiko')->label('Grading')
                    ->default('Belum')
                    ->color(fn($state) => match ($state ?? $state->grading_risiko) {
                        'Biru' => 'primary',
                        'Hijau' => 'success',
                        'Kuning' => 'warning',
                        'Merah' => 'danger',
                        'Belum' => 'gray',
                    })
                    ->badge()
                    ->sortable(),
                TextColumn::make('tanggal_tindakan')->label('Tgl. Tindakan')
                    ->formatStateUsing(fn($state) => $state->translatedFormat('d F Y'))
                    ->tooltip(function (InvestigasiSederhana $record) {
                        $tanggal_mulai = \Carbon\Carbon::parse($record->tanggal_selesai)->translatedFormat('d F Y');
                        $tanggal_selesai = \Carbon\Carbon::parse($record->tanggal_selesai)->translatedFormat('d F Y');
                        return "Mulai $tanggal_mulai, Selesai $tanggal_selesai";
                    })->sortable(),
                TextColumn::make('investigasi_lanjut')->label('Lanjut')
                    ->color(fn($state) => match ($state) {
                        'ya' => 'success',
                        'tidak' => 'danger',
                    })->badge()
                    ->formatStateUsing(fn($state) => $state == 'ya' ? 'Ya' : 'Tidak')
                    ->sortable(),

                TextColumn::make('created_at')->label('Tgl. Dibuat')

                    ->formatStateUsing(fn($state) => $state->translatedFormat('d F Y'))
                    ->description(fn($record) => $record->insiden->waktu_insiden)
                    ->sortable(),

            ])
            ->filters([
                // \App\Filament\Resources\InsidenResource\Filters\GradingInsiden::make()
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('rca')
                        ->label(fn(InvestigasiSederhana $record) => $record->insiden->rca ? 'Edit RCA' : 'Buat RCA')
                        ->icon('heroicon-o-document-text')
                        ->authorize(function ($record) {
                            if ($record->rca) {
                                return Gate::allows('update_root::cause::analysis', $record->insiden->rca);
                            } else {
                                return Gate::allows('create_root::cause::analysis', $record->insiden);
                            }
                        })
                        ->url(fn(InvestigasiSederhana $record) => $record->insiden->rca ? RootCauseAnalysisResource::getUrl('edit', ['record' => $record->insiden->rca, 'insiden' => $record->id]) : RootCauseAnalysisResource::getUrl('create', ['insiden' => $record->id])),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInvestigasiSederhanas::route('/'),
            'create' => Pages\CreateInvestigasiSederhana::route('/create'),
            'edit' => Pages\EditInvestigasiSederhana::route('/{record}/edit'),
        ];
    }
}
