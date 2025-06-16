<?php

namespace App\Filament\Resources\PasienResource\Forms;

use App\Models\Pasien;
use Filament\Forms\Form;

class Kontak
{
    public static function make(Form|null $form): array
    {
        return  [
            \Filament\Forms\Components\Grid::make(2)
                ->schema([
                    \Filament\Forms\Components\TextInput::make('no_telp')
                        ->label('No. Telepon')
                        ->tel()
                        ->placeholder('628xxxxxx')
                        ->maxLength(15),

                    \Filament\Forms\Components\TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->maxLength(255)
                        ->placeholder('example@gmail.com'),
                ]),

            \Filament\Forms\Components\Textarea::make('alamat')
                ->label('Alamat')
                ->maxLength(500)
                ->rows(3),
        ];
    }
}
