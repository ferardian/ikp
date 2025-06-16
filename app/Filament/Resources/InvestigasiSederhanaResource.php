<?php

namespace App\Filament\Resources;

use App\Filament\Components\InvestigasiSederhanaForm;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use App\Models\InvestigasiSederhana;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\InvestigasiSederhanaResource\Pages;
use App\Filament\Resources\InvestigasiSederhanaResource\RelationManagers;
use App\Filament\Resources\InsidenResource\Forms\InvestigasiSederhanaInsiden;
use App\Filament\Resources\InvestigasiSederhanaResource\Pages\EditInvestigasiSederhana;
use App\Filament\Resources\InvestigasiSederhanaResource\Pages\ListInvestigasiSederhanas;
use App\Filament\Resources\InvestigasiSederhanaResource\Pages\CreateInvestigasiSederhana;
use App\Models\Insiden;
use App\Models\Pasien;
use Dom\Text;
use Filament\Facades\Filament;
use Filament\Tables\Columns\TextColumn;

class InvestigasiSederhanaResource extends Resource
{
    protected static ?string $model = InvestigasiSederhana::class;

    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('insiden_id')
                    ->label('Insiden')
                    ->options(\App\Models\Insiden::all()->pluck('insiden', 'id')),
                ...InvestigasiSederhanaForm::schema(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->columns([
                TextColumn::make()
                // TextColumn::make('insiden.insiden')->label('Insiden')
                //     ->description(fn(InvestigasiSederhana $record) => $record->insiden->pasien->nama)
                //     ->searchable(),
                // TextColumn::make('insiden.unit.nama_unit')->label('Unit'),
                // TextColumn::make('insiden.grading.grading_risiko')->label('Grading')
                //     ->color(fn($state) => match ($state ?? $state->grading_risiko) {
                //         'Biru' => 'primary',
                //         'Hijau' => 'success',
                //         'Kuning' => 'warning',
                //         'Merah' => 'danger',
                //     })->badge()
                //     ->toggleable(),

                // // TextColumn::make('insiden')->label('Grading')
                // //     ->formatStateUsing(fn($state) => $state->grading->grading_risiko),
                // TextColumn::make('insiden')->label('Tanggal')
                //     ->formatStateUsing(fn($state) => $state->tanggal_insiden->translatedFormat('l, d F Y'))
                //     ->description(fn($record) => $record->insiden->waktu_insiden),

            ])
            ->filters([
                //
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
