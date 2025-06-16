<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PegawaiResource\Pages;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;

class PegawaiResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?string $breadcrumb = 'Pegawai';

    protected static ?string $navigationLabel = 'Pegawai';

    public static function getPermissionPrefixes(): array
    {
        return [
            'view', 'view_any',
            'create', 'update',
            'restore', 'restore_any',
            'replicate', 'reorder',
            'delete', 'delete_any',
            'force_delete', 'force_delete_any',
            'change_role', 'change_password',
        ];
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Fieldset::make('Acount Detail')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Name')
                            ->required(),

                        Forms\Components\TextInput::make('username')
                            ->label(fn($record) => $form->getOperation() === 'edit' && $record->exists ? 'Username (Tidak bisa diubah)' : 'Username')
                            ->unique(ignoreRecord: true)
                            ->readOnly(fn($record) => $form->getOperation() === 'edit' && $record->exists)
                            ->live()
                            ->required(),

                        Forms\Components\TextInput::make('email')
                            ->label('Email'),

                        Forms\Components\Select::make('roles')
                            ->label('Role')
                            ->relationship('roles', 'name')
                            ->options(\Spatie\Permission\Models\Role::pluck('name', 'id')->toArray())
                            ->preload()
                            ->required(),

                        Forms\Components\Checkbox::make('email_verified_at')
                            ->label('Verified')
                            ->default(false),
                    ]),

                // password and confirm_password only for create operation
                Forms\Components\Fieldset::make('Password')
                    ->schema([
                        Forms\Components\TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->required()
                            ->dehydrated(fn($state) => filled($state))
                            ->dehydrateStateUsing(fn($state) => Hash::make($state))
                            ->required(fn(string $context): bool => $context === 'create')
                            ->validationMessages([
                                'required' => 'Password tidak boleh kosong',
                            ]),

                        Forms\Components\TextInput::make('confirm_password')
                            ->label('Confirm Password')
                            ->password()
                            ->required(fn(string $context): bool => $context === 'create')
                            ->same('password')
                            ->validationMessages([
                                'same' => 'Password dan Confirm Password harus sama',
                            ]),
                    ]),

                Forms\Components\Fieldset::make('Personal Information')
                    ->relationship('detail', 'detail')
                    ->schema([
                        Forms\Components\Select::make('jabatan_id')
                            ->label('Jabatan')
                            ->relationship('jabatan', 'nama')
                            ->searchable()
                            ->preload()
                            ->required(),

                        Forms\Components\Select::make('unit_id')
                            ->label('Unit')
                            ->relationship('unit', 'nama_unit')
                            ->searchable()
                            ->preload()
                            ->required(),

                        // no_hp from relation detail
                        Forms\Components\TextInput::make('no_hp')
                            ->label('No. HP')
                            ->required(),

                        Forms\Components\TextInput::make('departemen')
                            ->label('Departemen')
                            ->required(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->description(function ($record) {
                        return 'Unit : ' . $record->detail->unit->nama_unit;
                    })
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('username')
                    ->label('Username')
                    ->view('components.kbd')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Role')
                    ->badge()
                    ->color(function (string $state): string {
                        $state = strtolower($state); // Ubah ke lowercase untuk pencocokan lebih fleksibel

                        if (str_contains($state, 'admin')) {
                            return 'danger';
                        } elseif (str_contains($state, 'komite') || str_contains($state, 'mutu')) {
                            return 'primary';
                        } else {
                            return 'gray'; // Default jika tidak ada yang cocok
                        }
                    })
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->url(fn($record) => "mailto:{$record->email}")
                    ->sortable(),

                Tables\Columns\TextColumn::make('detail.unit.nama_unit')
                    ->label('Unit')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('detail.jabatan.nama')
                    ->label('Jabatan')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('detail.departemen')
                    ->label('Departemen')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Filter Jabatan
                Tables\Filters\SelectFilter::make('jabatan_id')
                    ->label('Jabatan')
                    ->options(\App\Models\Jabatan::pluck('nama', 'id')->toArray()) // Ambil opsi dari Jabatan
                    ->searchable()
                    ->query(function (Builder $query, $data) {
                        if (!$data['value']) {
                            return $query;
                        }

                        return $query->whereHas('detail', function ($q) use ($data) {
                            $q->where('jabatan_id', $data['value']);
                        });
                    })
                    ->placeholder('Pilih Jabatan'),

                // Filter Unit
                Tables\Filters\SelectFilter::make('unit_id')
                    ->label('Unit')
                    ->options(\App\Models\Unit::pluck('nama_unit', 'id')->toArray()) // Ambil opsi dari Unit
                    ->searchable()
                    ->query(function (Builder $query, $data) {
                        if (!$data['value']) {
                            return $query;
                        }

                        return $query->whereHas('detail', function ($q) use ($data) {
                            $q->where('unit_id', $data['value']);
                        });
                    })
                    ->placeholder('Pilih Unit'),

                Tables\Filters\TrashedFilter::make(),

                Tables\Filters\SelectFilter::make('roles')
                    ->label('Role')
                    ->options(\Spatie\Permission\Models\Role::pluck('name', 'name')->toArray()) // Pastikan format array yang benar
                    ->searchable()
                    ->query(function (Builder $query, $data) {
                        if (!$data['value']) {
                            return $query;
                        }

                        return $query->whereHas('roles', function ($q) use ($data) {
                            $q->where('name', $data['value']);
                        });
                    })
                    ->placeholder('Pilih Role'),

                Tables\Filters\SelectFilter::make('email')
                    ->label('Email')
                    ->options([
                        '1' => 'Ada Email',
                        '0' => 'Tidak Ada Email',
                    ])
                    ->query(function (Builder $query, $data) {
                        if ($data['value'] === '1') {
                            return $query->whereNotNull('email');
                        } elseif ($data['value'] === '0') {
                            return $query->whereNull('email');
                        }

                        return $query;
                    })
                    ->placeholder('Pilih Email'),

                // has username
                Tables\Filters\SelectFilter::make('username')
                    ->label('Username')
                    ->options([
                        '1' => 'Ada Username',
                        '0' => 'Tidak Ada Username',
                    ])
                    ->query(function (Builder $query, $data) {
                        if ($data['value'] === '1') {
                            return $query->whereNotNull('username');
                        } elseif ($data['value'] === '0') {
                            return $query->whereNull('username');
                        }

                        return $query;
                    })
                    ->placeholder('Pilih Username'),

            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Edit')->visible(function ($record) {
                    return !$record->trashed();
                }),

                Tables\Actions\RestoreAction::make()->label('Restore'),

                Tables\Actions\ActionGroup::make([
                    // Change Role action
                    \App\Filament\Resources\PegawaiResource\Actions\ChangeRoleAction::make(),

                    // Change Password action
                    \App\Filament\Resources\PegawaiResource\Actions\ChangePasswordAction::make(),

                    Tables\Actions\DeleteAction::make()->label('Delete')
                        ->visible(function ($record) {
                            // Ambil semua role user dalam bentuk array string
                            $userRoles = $record->roles->pluck('name');

                            // Cek apakah ada role yang mengandung kata "admin"
                            if ($userRoles->contains(fn($role) => str_contains(strtolower($role), 'admin'))) {
                                // Hitung jumlah user yang memiliki role dengan kata "admin"
                                $adminCount = User::whereHas('roles', function ($q) {
                                    $q->where('name', 'like', '%admin%');
                                })->count();

                                // Jika hanya ada 1 admin, sembunyikan tombol hapus
                                return $adminCount > 1;
                            }

                            return true; // Jika bukan admin, tombol hapus tetap muncul
                        }),

                    // Tables\Actions\ForceDeleteAction::make()->label('Hapus Permanen'),
                ])
                    ->label("More Actions"),
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
            'index' => Pages\ListPegawais::route('/'),
            // 'create' => Pages\CreatePegawai::route('/create'),
            // 'edit' => Pages\EditPegawai::route('/{record}/edit'),
        ];
    }

    public static function isModal(): bool
    {
        return true;
    }
}
