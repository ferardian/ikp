<?php

namespace App\Filament\Resources\PegawaiResource\Actions;

use Filament\Tables\Actions\Action;
use Filament\Forms;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class ChangePasswordAction
{
    public static function make(
        string $modalTitle = 'Ubah Password',
        string $modalDescription = 'Isi form berikut untuk mengubah password.',
        string $successMessage = 'Password berhasil diubah!'
    ): Action {
        return Action::make('change-password')
            ->label($modalTitle)
            ->modalDescription($modalDescription)
            ->icon('heroicon-o-lock-closed')
            ->authorize(fn ($record) => Gate::allows('change_password', $record))
            ->form([
                Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->password()
                    ->required()
                    ->dehydrated(fn($state) => filled($state))
                    // ->dehydrateStateUsing(fn($state) => Hash::make($state))
                    ->validationMessages([
                        'required' => 'Password tidak boleh kosong',
                    ]),

                Forms\Components\TextInput::make('confirm_password')
                    ->label('Confirm Password')
                    ->password()
                    ->required()
                    ->same('password')
                    ->validationMessages([
                        'same' => 'Password dan Confirm Password harus sama',
                    ]),
            ])
            ->action(function (array $data, $record) use ($successMessage) {
                try {
                    $record->update([
                        'password' => Hash::make($data['password']),
                    ]);

                    // Notifikasi sukses
                    \Filament\Notifications\Notification::make()
                        ->title($successMessage)
                        ->success()
                        ->send();
                } catch (\Exception $e) {
                    // Notifikasi error
                    \Filament\Notifications\Notification::make()
                        ->title('Gagal mengubah password')
                        ->body($e->getMessage()) // Menampilkan pesan error
                        ->danger()
                        ->send();
                }
            })
            ->successNotificationTitle($successMessage)
            ->modal();
    }
}
