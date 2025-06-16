<?php

namespace App\Filament\Widgets;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TopUnitInsiden extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        // Pendekatan 1: Gunakan subquery
        $query = \App\Models\Insiden::select('unit_id', \DB::raw('count(*) as total'))
            ->groupBy('unit_id')
            ->orderBy('total', 'desc')
            ->take(5);

        return $table
            ->query($query)
            ->columns([
                TextColumn::make('unit.nama_unit')->label('Nama'),
                TextColumn::make('total')->label('Total Insiden'),
            ])
            ->defaultPaginationPageOption(5)
            ->recordUrl(null);
    }


    // Alternatively, you can add this method to provide string keys
    public function getTableRecordKey($record): string
    {
        return (string) $record->unit_id;
    }
}
