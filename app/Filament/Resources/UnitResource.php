<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Unit;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\UnitResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\UnitResource\RelationManagers;

class UnitResource extends Resource
{
    protected static ?string $model = Unit::class;

    protected static ?string $navigationLabel = 'Unit Kerja';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $breadcrumb = 'Unit Kerja';

    protected static ?string $navigationIcon = 'heroicon-o-tag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make($form->getOperation() == 'create' ? 'Buat Unit Kerja' : 'Ubah Unit Kerja')
                    ->description($form->getOperation() == 'create' ? 'Silahkan isi form berikut untuk membuat unit kerja baru' : 'Silahkan isi form berikut untuk mengubah unit kerja')
                    ->schema([
                        Forms\Components\TextInput::make('nama_unit')
                            ->label('Nama Unit')
                            ->required()
                            ->placeholder('Masukkan nama unit'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_unit')
                    ->label('Nama Unit')
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
            'index'  => Pages\ListUnits::route('/'),
            // 'create' => Pages\CreateUnit::route('/create'),
            // 'edit'   => Pages\EditUnit::route('/{record}/edit'),
        ];
    }

    public static function isModal(): bool
    {
        return true;
    }
}
