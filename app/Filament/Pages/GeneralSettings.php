<?php

namespace App\Filament\Pages;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class GeneralSettings extends SettingsPage
{
    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 3;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make("Pengaturan Umum")
                    ->description("Pengaturan umum aplikasi")
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Aplikasi')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('faskes')
                            ->label('Nama Faskes')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('address')
                            ->label('Alamat Aplikasi')
                            ->rows(5),

                        Forms\Components\Textarea::make('about')
                            ->label('Tentang Aplikasi')
                            ->rows(5),

                        Forms\Components\FileUpload::make('logo')
                            ->label('Logo Aplikasi')
                            ->visibility('public')
                            ->directory('images')
                            ->acceptedFileTypes(['image/jpg', 'image/jpeg', 'image/png']),

                        Forms\Components\FileUpload::make('juknis')
                            ->label('Juknis Aplikasi')
                            ->directory('juknis')
                            ->visibility('public')
                            ->acceptedFileTypes(['application/pdf']),

                        // boolean named show_logo
                        Forms\Components\Radio::make('show_logo')
                            ->label('Tampilkan Logo')
                            ->options([
                                '1' => 'Ya',
                                '0' => 'Tidak',
                            ])
                            ->default('1')
                            ->inline()
                            ->required(),
                    ])
            ]);
    }
}
