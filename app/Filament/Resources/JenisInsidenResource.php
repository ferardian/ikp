<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JenisInsidenResource\Pages;
use App\Models\JenisInsiden;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JenisInsidenResource extends Resource
{
    protected static ?string $model = JenisInsiden::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-stack';

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
                Tables\Columns\TextColumn::make('nama_jenis_insiden')
                    ->label('Jenis Insiden')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('alias')
                    ->label('Alias')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordAction(null)
            ->recordUrl(null)
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
            'index'  => Pages\ListJenisInsidens::route('/'),
            'create' => Pages\CreateJenisInsiden::route('/create'),
            'edit'   => Pages\EditJenisInsiden::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }
}
