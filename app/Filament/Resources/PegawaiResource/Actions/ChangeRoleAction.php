<?php

namespace App\Filament\Resources\PegawaiResource\Actions;

use Filament\Tables\Actions\Action;
use Filament\Forms;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class ChangeRoleAction
{
    public static function make(
        string $modalTitle = 'Ubah Role Pengguna',
        string $modalDescription = 'Pilih role baru untuk pengguna ini.',
        string $successMessage = 'Role pengguna berhasil diperbarui!'
    ): Action {
        return Action::make('change-role')
            ->label('Ubah Role')
            ->modalHeading($modalTitle)
            ->modalDescription($modalDescription)
            ->icon('heroicon-o-cursor-arrow-rays')
            ->form([
                Forms\Components\Select::make('role')
                    ->label('Role Baru')
                    ->options(Role::pluck('name', 'name')->toArray())
                    ->searchable()
                    ->required(),
            ])
            ->authorize(fn ($record) => Gate::allows('change_password', $record))
            ->action(function (array $data, $record) use ($successMessage) {
                try {
                    $curentRole = $record->roles->pluck('name');

                    if ($curentRole->contains(fn($role) => str_contains(strtolower($role), 'admin'))) {
                        // Hitung jumlah user yang memiliki role dengan kata "admin"
                        $adminCount = \App\Models\User::whereHas('roles', function ($q) {
                            $q->where('name', 'like', '%admin%');
                        })->count();

                        if ($adminCount === 1) {
                            throw new \Exception('Tidak dapat menghapus role admin karena hanya ada 1 user dengan role admin.');
                        }
                    }

                    // Hapus semua role lama & set role baru
                    $record->syncRoles([$data['role']]);

                    // Notifikasi sukses
                    \Filament\Notifications\Notification::make()
                        ->title($successMessage)
                        ->success()
                        ->send();
                } catch (\Exception $e) {
                    // Notifikasi error
                    \Filament\Notifications\Notification::make()
                        ->title('Gagal mengubah role pengguna')
                        ->body($e->getMessage()) // Menampilkan pesan error
                        ->danger()
                        ->send();
                }
            })
            ->successNotificationTitle($successMessage)
            ->modal();
    }
}
