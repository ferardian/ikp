<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Jabatan;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\JabatanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\JabatanResource\RelationManagers;

class JabatanResource extends Resource
{
    protected static ?string $model = Jabatan::class;

    protected static ?string $navigationIcon = 'heroicon-o-bookmark-square';

    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make($form->getOperation() == 'create' ? 'Buat Jabatan' : 'Ubah Jabatan')
                    ->description($form->getOperation() == 'create' ? 'Silahkan isi form berikut untuk membuat jabatan baru' : 'Silahkan isi form berikut untuk mengubah jabatan')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Jabatan')
                            ->required()
                            ->placeholder('Masukkan nama jabatan')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $set('kode', Str::slug($state));
                            }), // Generate kode otomatis

                        Forms\Components\TextInput::make('kode')
                            ->label('Kode')
                            ->required()
                            ->readOnly()
                            ->dehydrated()
                            ->placeholder('Masukkan kode jabatan'),

                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->placeholder('Masukkan deskripsi jabatan')
                            ->rows(3),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Jabatan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('kode')
                    ->label('Kode')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('gray'),
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
            'index' => Pages\ListJabatans::route('/'),
            'create' => Pages\CreateJabatan::route('/create'),
            'edit' => Pages\EditJabatan::route('/{record}/edit'),
        ];
    }
}
