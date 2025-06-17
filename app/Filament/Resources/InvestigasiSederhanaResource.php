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
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
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

    public static function form(Form $form): Form
    {
        $insiden_id = Request::get('insiden');



        $insiden = \App\Models\Insiden::with([
            'pasien',
            'unit',
            'grading'
        ])->find($insiden_id);


        return $form

            ->schema([
                Section::make('Detail Insiden')
                    ->disabled()
                    ->schema(
                        [
                            Grid::make(3)->schema([
                                TextInput::make('insiden_id')
                                    ->label('Insiden')
                                    ->default($insiden->insiden)
                                    ->disabled(),

                                TextInput::make('nama')
                                    ->default($insiden->pasien->nama)
                                    ->label('Pasien'),

                                DatePicker::make('tanggal_insiden')

                                    ->default($insiden->tanggal_insiden)
                                    ->label('Tanggal Insiden'),
                            ])
                        ]
                    ),

                // ->disabled(),
                ...InvestigasiSederhanaForm::schema(),

            ]);
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
                TextColumn::make('insiden')->label('Tanggal')
                    ->formatStateUsing(fn($state) => $state->tanggal_insiden->translatedFormat('l, d F Y'))
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
