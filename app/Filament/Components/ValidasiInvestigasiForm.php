<?php

namespace App\Filament\Components;

use Filament\Forms\Form;
use Coolsam\SignaturePad\Forms\Components\Fields\SignaturePad;
use Doctrine\DBAL\Schema\View;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\View as ComponentsView;

class ValidasiInvestigasiForm
{
    public static function schema(Form|null $form): array
    {

        return [
            Grid::make(2)
                ->schema([
                    ComponentsView::make('livewire.signature-create-sign')

                        ->viewData(fn($record) => [
                            'signature' => $record?->insiden?->created_sign,
                            'signatured_by' => $record?->insiden?->oleh?->name,
                        ]),
                    ComponentsView::make('livewire.signature-recieve-sign')
                        ->viewData(fn($record) => [
                            'recieve_signature' => $record?->insiden?->received_sign,
                            'recieve_signature_by' => $record?->insiden?->penerima?->name,
                        ]),
                    SignaturePad::make('created_sign')
                        ->label('Tanda Tangan Pembuat Laporan')
                        ->backgroundColor('white') // Set the background color in case you want to download to jpeg
                        ->penColor('black') // Set the pen color
                        ->strokeMinDistance(2.0) // set the minimum stroke distance (the default works fine)
                        ->strokeMaxWidth(2.5) // set the max width of the pen stroke
                        ->strokeMinWidth(1.0) // set the minimum width of the pen stroke
                        ->strokeDotSize(2.0) // set the stroke dot size.
                        ->hideDownloadButtons() // In case you don't want to show the download buttons on the pad, you can hide them by setting this option.
                        ->displayTemplate(false)
                        ->view('vendor.signature-pad.signature-pad')
                        ->default(fn($record) => $record?->insiden?->received_sign)
                        ->required(),

                    SignaturePad::make('received_sign')
                        ->label('Tanda Tangan Penerima laporan')
                        ->backgroundColor('white') // Set the background color in case you want to download to jpeg
                        ->penColor('black') // Set the pen color
                        ->strokeMinDistance(2.0) // set the minimum stroke distance (the default works fine)
                        ->strokeMaxWidth(2.5) // set the max width of the pen stroke
                        ->strokeMinWidth(1.0) // set the minimum width of the pen stroke
                        ->strokeDotSize(2.0) // set the stroke dot size.
                        ->hideDownloadButtons() // In case you don't want to show the download buttons on the pad, you can hide them by setting this option.
                        ->displayTemplate(false)
                        ->view('vendor.signature-pad.signature-pad')
                        ->default(fn($record) => $record?->insiden?->created_sign)
                        ->required(),


                    // PEMBUAT LAPORAN
                    Hidden::make('created_by')
                        ->dehydrated()
                        ->formatStateUsing(fn($state) => $state ?? auth()->id()),

                    // PENERIMA LAPORAN
                    Hidden::make('received_by')
                        ->dehydrated()
                        ->formatStateUsing(fn($state) => $state ?? auth()->id()),

                    Hidden::make('received_at')
                        ->dehydrated()
                        ->formatStateUsing(fn($state) => $state ?? now()->toDateTimeString()),
                ])
        ];
    }
}
