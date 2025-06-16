<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Pasien;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PasienResource\Pages;
use Filament\Infolists\Infolist;

class PasienResource extends Resource
{
    protected static ?string $model = Pasien::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $navigationLabel = 'Pasien';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                \Filament\Forms\Components\Section::make('Informasi Pasien')
                    ->description('Masukkan data pasien dengan lengkap.')
                    ->schema(\App\Filament\Resources\PasienResource\Forms\Detail::make($form)),

                \Filament\Forms\Components\Section::make('Kontak Pasien')
                    ->description('Masukkan data kontak pasien.')
                    ->schema(\App\Filament\Resources\PasienResource\Forms\Kontak::make($form)),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            \Filament\Infolists\Components\Section::make("Detail Pasien")
                ->description("Informasi detail pasien")
                ->columns([
                    'md' => 2,
                ])
                ->schema([
                    \Filament\Infolists\Components\TextEntry::make('nama')->label('Nama'),
                    \Filament\Infolists\Components\TextEntry::make('nik')->label('NIK')->badge()->color('gray'),
                    \Filament\Infolists\Components\TextEntry::make('no_rekam_medis')->label('Rekam Medis')->badge(),
                    \Filament\Infolists\Components\TextEntry::make('jenis_kelamin')
                        ->label('Jenis Kelamin')
                        ->formatStateUsing(fn($state) => $state === 'L' ? 'Laki-laki' : 'Perempuan'),
                    \Filament\Infolists\Components\TextEntry::make('tempat_lahir')->label('Tempat Lahir'),
                    \Filament\Infolists\Components\TextEntry::make('tanggal_lahir')->label('Tanggal Lahir')
                        ->dateTime('D, d F Y'),
                ])->headerActions([
                    \Filament\Infolists\Components\Actions\Action::make('edit')
                        ->label('Edit')
                        ->url(fn($record) => PasienResource::getUrl('edit', ['record' => $record]))
                        ->modal(),
                ]),

            \Filament\Infolists\Components\Section::make("Kontak Pasien")
                ->description("Informasi detail pasien")
                ->columns([
                        'md' => 2,
                ])
                ->schema([
                    \Filament\Infolists\Components\TextEntry::make('no_telp')->label('No. Telepon'),
                    \Filament\Infolists\Components\TextEntry::make('alamat')->label('Alamat'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->view('filament.tables.columns.name-with-gender'),

                // add columns to show Penanggung Biaya
                Tables\Columns\TextColumn::make('penanggungBiaya.jenis_penanggung')
                    ->label('Penanggung Biaya')
                    ->badge()
                    ->color(function (string $state): string {
                        $state = strtolower($state); // Ubah ke lowercase untuk pencocokan lebih fleksibel

                        if (str_contains($state, 'bpjs')) {
                            return 'success';
                        } elseif (str_contains($state, 'jamkesda')) {
                            return 'primary';
                        } elseif (str_contains($state, 'umum') || str_contains($state, 'pribadi')) {
                            return 'gray';
                        } elseif (str_contains($state, 'asuransi')) {
                            return 'warning';
                        } elseif (str_contains($state, 'pemerintah')) {
                            return 'info';
                        } elseif (str_contains($state, 'perusahaan')) {
                            return 'danger';
                        } else {
                            return 'gray'; // Default jika tidak ada yang cocok
                        }
                    })
                    ->sortable()
                    ->searchable()
                    ->toggleable(),


                Tables\Columns\TextColumn::make('nik')
                    ->label('NIK')
                    ->badge()
                    ->copyable()
                    ->color("gray")
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('no_rekam_medis')
                    ->label('Rekam Medis')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->view('components.kbd'),

                Tables\Columns\TextColumn::make('tanggal_lahir')
                    ->label('Tanggal Lahir')
                    ->date('D, d F Y')
                    ->description(function ($record) {
                        return $record->tanggal_lahir
                            ? Carbon::parse($record->tanggal_lahir)->diff(Carbon::now())->format('%y tahun, %m bulan, %d hari')
                            : 'Tanggal lahir tidak diketahui';
                    })
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->url(fn($record) => "mailto:{$record->email}")
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('no_telp')
                    ->label('No. Telepon')
                    ->searchable()
                    ->sortable()
                    ->url(fn($record) => "tel:{$record->no_telp}")
                    ->toggleable(),

            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),

                Tables\Filters\SelectFilter::make('penanggung_biaya_id')
                    ->label("Penanggung Biaya")
                    ->options(\App\Models\PenanggungBiaya::pluck('jenis_penanggung', 'id')->toArray())
                    ->searchable()
                    ->placeholder('Pilih Penanggung Biaya'),


                Tables\Filters\SelectFilter::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ])
                    ->placeholder('Pilih jenis kelamin'),

                Tables\Filters\SelectFilter::make('kelompok_usia')
                    ->label('Kelompok Usia')
                    ->options([
                        '0-5' => '0-5 tahun',
                        '6-12' => '6-12 tahun',
                        '13-18' => '13-18 tahun',
                        '19-30' => '19-30 tahun',
                        '31-45' => '31-45 tahun',
                        '46-60' => '46-60 tahun',
                        '61-75' => '61-75 tahun',
                        '>75' => '> 75 tahun', // Tambahkan opsi ini
                    ])
                    ->query(function ($query, $data) {
                        if (!$data || $data['value'] === null) {
                            return $query;
                        }

                        if ($data['value'] === '>75') {
                            // Usia lebih dari 75 tahun
                            return $query->where('tanggal_lahir', '<=', Carbon::now()->subYears(75));
                        }

                        $range = explode('-', $data['value']);
                        $minAge = (int) $range[0];
                        $maxAge = (int) $range[1];

                        return $query->whereBetween('tanggal_lahir', [
                            Carbon::now()->subYears($maxAge),
                            Carbon::now()->subYears($minAge),
                        ]);
                    })
                    ->placeholder('Pilih kelompok usia')


            ])
            ->recordAction(Tables\Actions\ViewAction::class)
            ->recordUrl(fn($record): string => PasienResource::getUrl('view', ['record' => $record]))
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['penanggungBiaya']);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPasiens::route('/'),
            'create' => Pages\CreatePasien::route('/create'),
            'view'   => Pages\ViewPasien::route('/{record}'),
            'edit'   => Pages\EditPasien::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): string|array|null
    {
        $count = static::getModel()::count();
        // use the color : primary, warning, danger, success for 0
        if ($count == 0) {
            return 'success';
        } elseif ($count > 0 && $count <= 5) {
            return 'primary';
        } elseif ($count > 5 && $count <= 10) {
            return 'warning';
        } elseif ($count > 10) {
            return 'danger';
        } else {
            return 'gray';
        }
    }

    public static function isModal(): bool
    {
        return true;
    }
}
