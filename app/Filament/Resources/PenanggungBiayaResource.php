<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenanggungBiayaResource\Pages;
use App\Filament\Resources\PenanggungBiayaResource\RelationManagers;
use App\Models\PenanggungBiaya;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PenanggungBiayaResource extends Resource
{
    protected static ?string $model = PenanggungBiaya::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make($form->getOperation() == 'create' ? 'Buat Penanggung Biaya' : 'Ubah Penanggung Biaya')
                    ->description($form->getOperation() == 'create' ? 'Silahkan isi form berikut untuk membuat penanggung biaya baru' : 'Silahkan isi form berikut untuk mengubah penanggung biaya')
                    ->schema([
                        Forms\Components\TextInput::make('jenis_penanggung')
                            ->label('Penanggung Biaya')
                            ->required()
                            ->placeholder('Masukkan nama penanggung biaya'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('jenis_penanggung')
                    ->label('Penanggung Biaya')
                    ->searchable()
                    ->sortable(),

                // created_at column
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Edit')->visible(function ($record) {
                    return !$record->trashed();
                }),
                Tables\Actions\RestoreAction::make()->label('Restore'),
                Tables\Actions\DeleteAction::make()->label('Delete'),
                Tables\Actions\ForceDeleteAction::make()->label('Hapus Permanen'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
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
            'index'  => Pages\ListPenanggungBiayas::route('/'),
            // 'create' => Pages\CreatePenanggungBiaya::route('/create'),
            // 'edit'   => Pages\EditPenanggungBiaya::route('/{record}/edit'),
        ];
    }

    public static function isModal(): bool
    {
        return true;
    }
}
