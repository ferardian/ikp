<?php

namespace App\Filament\Resources\Master;

use App\Filament\Resources\Master\UserResource\Pages;
use App\Filament\Resources\Master\UserResource\RelationManagers;
use App\Models\MasterPegawai;
use App\Models\MasterUser;
use Filament\Forms;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class UserResource extends Resource
{
    protected static ?string $model = \App\Models\MasterUser::class;
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
        // $query = MasterUser::first();
        // dd($query->username);
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('username')->label('Username'),
                Tables\Columns\TextColumn::make('pegawai.nama')->label('Nama')
                    ->getStateUsing(fn($record) => MasterPegawai::find($record->username)?->nama),
                Tables\Columns\TextColumn::make('pegawai.jbtn')->label('Jabatan')
                    ->getStateUsing(fn($record) => MasterPegawai::find($record->username)?->jbtn),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ]);
        // ->bulkActions([
        //     Tables\Actions\BulkActionGroup::make([
        //         Tables\Actions\DeleteBulkAction::make(),
        //     ]),
        // ]);
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
            'index' => Pages\ListUsers::route('/'),
            // 'create' => Pages\CreateUser::route('/create'),
            // 'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->selectRaw("*, CAST(AES_DECRYPT(id_user, 'nur') AS CHAR) as username");

    }

}
