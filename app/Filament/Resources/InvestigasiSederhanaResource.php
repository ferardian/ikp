<?php

namespace App\Filament\Resources;

use App\Filament\Components\InvestigasiSederhanaForm;
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
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Date;
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
        if (self::$nsiden) {
            $data['insiden_id'] = self::$nsiden->id;
        }

        return $data;
    }

    protected static function getFormDetailSchema(): array
    {
        return array_filter([
            self::$insiden ? Section::make('Detail Insiden')
                ->schema([
                    Grid::make(3)->schema([
                        Placeholder::make('nama_insiden')
                            ->label('Insiden')
                            ->content(self::$nsiden->insiden ?? '-'),

                        Placeholder::make('nama')
                            ->label('Pasien')
                            ->content(self::$nsiden->pasien->nama ?? '-'),

                        Placeholder::make('jenis_insiden')
                            ->label('Jenis Insiden')
                            ->content(self::$nsiden->jenisInsiden->nama_jenis_insiden ?? '-'),

                        Placeholder::make('dampak_insiden')
                            ->label('Dampak Insiden')
                            ->content(ucfirst(self::$nsiden->dampak_insiden ?? '-')),

                        Placeholder::make('tempat_kejadian')
                            ->label('Tempat Kejadian')
                            ->content(self::$nsiden->tempat_kejadian ?? '-'),

                        Placeholder::make('tanggal_insiden')
                            ->label('Tanggal Insiden')
                            ->content(optional(self::$nsiden->tanggal_insiden)->format('Y-m-d')),
                    ]),
                ]) : null,


        ]);
    }

    public static function form(Form $form): Form
    {
        // $insiden = null;

        // if (blank($form->getModel()) && Request::has('insiden')) {
        //     $insiden = \App\Models\Insiden::with([
        //         'pasien',
        //         'unit',
        //         'grading',
        //         'jenisInsiden',
        //     ])->find(Request::get('insiden'));
        // }

        return $form
            ->schema([
                ...self::getFormDetailSchema(),
                ...InvestigasiSederhanaForm::schema(),
            ]);
    }

    public static function getIdInsiden()
    {
        return Request::has('insiden');
    }

    public static function canCreate(): bool
    {

        if (!self::getIdInsiden()) {
            return false;
        }

        return true;
    }

    public static function table(Table $table): Table
    {
        return $table

            ->columns([

                TextColumn::make('insiden.insiden')->label('Insiden')
                    ->description(fn(InvestigasiSederhana $record) => $record->insiden->pasien->nama)
                    ->searchable(),
                IconColumn::make('lengkap')->label('Lengkap')
                    ->icon(fn($state) => match ($state) {
                        'lengkap' => 'heroicon-s-check-circle',
                        'belum' => 'heroicon-s-x-circle',
                    })->color(fn($state) => match ($state) {
                        'lengkap' => 'success',
                        'belum' => 'danger',
                    }),
                TextColumn::make('insiden.unit.nama_unit')->label('Unit'),
                TextColumn::make('insiden.grading.grading_risiko')->label('Grading')
                    ->default('Belum')
                    ->color(fn($state) => match ($state ?? $state->grading_risiko) {
                        'Biru' => 'primary',
                        'Hijau' => 'success',
                        'Kuning' => 'warning',
                        'Merah' => 'danger',
                        'Belum' => 'gray',
                    })
                    ->badge(),
                TextColumn::make('tanggal_tindakan')->label('Tgl. Tindakan')
                    ->formatStateUsing(fn($state) => $state->translatedFormat('l, d F Y')),
                TextColumn::make('investigasi_lanjut')->label('Lanjut')
                    ->color(fn($state) => match ($state) {
                        'ya' => 'success',
                        'tidak' => 'danger',
                    })->badge()
                    ->formatStateUsing(fn($state) => $state == 'ya' ? 'Ya' : 'Tidak'),

                TextColumn::make('created_at')->label('Tgl. Dibuat')

                    ->formatStateUsing(fn($state) => $state->translatedFormat('l, d F Y'))
                    ->description(fn($record) => $record->insiden->waktu_insiden),

            ])
            ->filters([
                // \App\Filament\Resources\InsidenResource\Filters\GradingInsiden::make()
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
