<?php

namespace App\Filament\Resources\Master;

use App\Filament\Resources\Master\PegawaiMasterResource\Pages;
use App\Filament\Resources\Master\PegawaiMasterResource\RelationManagers;
use App\Models\MasterPegawai;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PegawaiMasterResource extends Resource
{
    protected static ?string $model = MasterPegawai::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPegawaiMasters::route('/'),
            'create' => Pages\CreatePegawaiMaster::route('/create'),
            'edit' => Pages\EditPegawaiMaster::route('/{record}/edit'),
        ];
    }
}
