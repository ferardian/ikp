<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Grading;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Pages\Actions\EditAction;
use Filament\Forms\Components\Fieldset;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\GradingResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\GradingResource\RelationManagers;
use App\Filament\Resources\GradingResource\Pages\EditGrading;
use App\Filament\Resources\GradingResource\Pages\ListGradings;
use App\Filament\Resources\GradingResource\Pages\CreateGrading;
use App\Filament\Resources\InsidenResource\Forms\TindakanInsiden;
use App\Livewire\AutoGrading2;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Livewire;

class GradingResource extends Resource
{
    protected static ?string $model = Grading::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Data Insiden Awal')
                    ->relationship('insiden')
                    ->schema([
                        // ... your jenis_insiden_id, unit_id, dampak_insiden fields should be here
                        // e.g.,
                        TextInput::make('jenis_insiden_id')->reactive()->readOnly(),
                        TextInput::make('unit_id')->reactive()->readOnly(),
                        TextInput::make('dampak_insiden')->reactive()->readOnly(),
                    ])->hidden(),
                Section::make('Tindakan dan Grading')
                    ->description("Tindakan dan Grading Insiden")
                    ->schema([
                        ...TindakanInsiden::make(),
                        Livewire::make(AutoGrading2::class, function ($state, callable $set) {
                            return [
                                'jenis_insiden_id' => $state['insiden']['jenis_insiden_id'],
                                'unit_id' => $state['insiden']['unit_id'],
                                'dampak_insiden' => $state['insiden']['dampak_insiden'],
                            ];
                        }),
                        Fieldset::make('Grading Risiko')
                            // ->relationship('grading')
                            ->columns(1)
                            ->schema([
                                Radio::make('grading_risiko')
                                    ->label('Grading Risiko')
                                    ->options([
                                        'Biru' => 'Biru',
                                        'Hijau' => 'Hijau',
                                        'Kuning' => 'Kuning',
                                        'Merah' => 'Merah',
                                    ])
                                    ->inline()
                                    ->view('filament.inputs.grading-radio')
                                    // custom required validation message
                                    ->validationMessages([
                                        'required' => ':attribute harus dipilih',
                                    ])
                                    ->required(),

                                Hidden::make('created_by')
                                    ->dehydrated()
                                    ->formatStateUsing(fn($state) => $state ?? auth()->id()),
                            ]),

                        // input hidden
                        TextInput::make('auto_grading_color')
                            ->reactive()
                            ->hidden()
                            ->dehydrated()
                            ->readOnly(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('insiden.jenis_pelapor')->label('Pelapor'),
                Tables\Columns\TextColumn::make('insiden.unit.nama_unit')->label('Unit'),
                Tables\Columns\TextColumn::make('insiden.insiden')->label('Insiden'),
                Tables\Columns\TextColumn::make('insiden.tindakan.oleh')->label('Diterima'),
                Tables\Columns\TextColumn::make('insiden.tindakan.content')->label('Tidakan')->html(),
                Tables\Columns\TextColumn::make('grading_risiko')->label('Grading')
                    ->badge()
                    ->color(fn(Grading $record) => match ($record->grading_risiko) {
                        'Biru' => 'primary',
                        'Hijau' => 'success',
                        'Kuning' => 'warning',
                        'Merah' => 'danger'
                    }),
                Tables\Columns\TextColumn::make('keterangan')->label('Keterangan'),

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
            'index' => Pages\ListGradings::route('/'),
            'create' => Pages\CreateGrading::route('/create'),
            'edit' => Pages\EditGrading::route('/{record}/edit'),
        ];
    }
}
