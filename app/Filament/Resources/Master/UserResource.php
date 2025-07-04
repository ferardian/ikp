<?php

namespace App\Filament\Resources\Master;

use App\Filament\Resources\Master\UserResource\Pages;
use App\Filament\Resources\Master\UserResource\RelationManagers;
use App\Models\MasterPegawai;
use App\Models\MasterPetugas;
use App\Models\MasterUser;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\DB;

class UserResource extends Resource
{
    protected static ?string $model = MasterPetugas::class;
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
                Tables\Columns\TextColumn::make('nip')->label('NIK')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('nama')->label('Nama')
                    ->searchable()->sortable()
                    ->description(fn(MasterPetugas $petugas) => $petugas->jabatan?->nm_jbtn),
                Tables\Columns\TextColumn::make('tgl_lahir')->label('Tgl. Lahir')
                    ->state(function ($record) {
                        return \Carbon\Carbon::parse($record->tgl_lahir)->format('d F Y');
                    }),
                Tables\Columns\TextColumn::make('pegawai.nik')
                    ->label('Sinkron')
                    ->formatStateUsing(fn($state) => "<span style='display:none'>$state</span>")
                    ->icon(
                        fn($state) =>
                        \App\Models\User::where('username', $state)->exists()
                        ? 'heroicon-s-check-circle'
                        : 'heroicon-s-x-circle'
                    )
                    ->color(
                        fn($state) =>
                        \App\Models\User::where('username', $state)->exists()
                        ? 'success'
                        : 'danger'
                    )
                    ->html(),
                Tables\Columns\TextColumn::make('status')->label('Status')
                    ->formatStateUsing(fn($state) => $state == '1' ? 'Aktif' : 'Tidak Aktif')
                    ->alignCenter()
                    ->color(fn($state): string => match ($state) {
                        '1' => 'success',
                        '0' => 'danger',
                    })->badge(),
            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                Action::make('sync')->label('Sinkronisasi')
                    ->icon('heroicon-m-key')->color('warning')
                    ->icon('heroicon-m-key')
                    ->visible(fn($record) => !\App\Models\User::where(['username' => $record->pegawai->nik])->exists() && $record->status == '1')
                    ->url(fn($record) => route('app.pegawai.sinkron', ['nik' => $record])),
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
            // 'petugas' => \App\Models\MasterPetugas::class,
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

    public static function canCreate(): bool
    {
        return false;
    }


}
