<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PasienMasterResource\Pages;
use App\Filament\Resources\PasienMasterResource\RelationManagers;
use App\Models\PasienMaster;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PasienMasterResource extends Resource
{
    protected static ?string $model = PasienMaster::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no_rkm_medis')->label('No. RM')->sortable()->searchable(),
                TextColumn::make('nm_pasien')->label('Nama Pasien')->sortable()->searchable(),
                TextColumn::make('no_ktp')->label('NIK'),
                TextColumn::make('tgl_lahir')->label('Tgl. Lahir')->date(),
                TextColumn::make('jk')->label('Jenis Kelamin'),
                TextColumn::make('kd_pj')->label('Pembiayaan'),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPasienMasters::route('/'),
            'create' => Pages\CreatePasienMaster::route('/create'),
            'edit' => Pages\EditPasienMaster::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

}
