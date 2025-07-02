<?php

namespace App\Filament\Resources;

use App\Filament\Resources\Pasien2Resource\Pages;
use App\Filament\Resources\Pasien2Resource\RelationManagers;
use App\Models\Pasien2;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class Pasien2Resource extends Resource
{
    protected static ?string $model = Pasien2::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

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
                //
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
            'index' => Pages\ListPasien2s::route('/'),
            'create' => Pages\CreatePasien2::route('/create'),
            'edit' => Pages\EditPasien2::route('/{record}/edit'),
        ];
    }
}
