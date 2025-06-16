<?php

namespace App\Filament\Resources\InsidenResource\Filters;

use Filament\Tables\Filters\SelectFilter;

class DampakInsiden
{
    public static function make()
    {
        return SelectFilter::make('dampak_insiden')
            ->options([
                'tidak signifikan' => 'Tidak Signifikan',
                'minor' => 'Minor',
                'moderat' => 'Moderat',
                'mayor' => 'Mayor',
                'katastropik' => 'Katastropik',
            ])
            ->label('Dampak Insiden');
    }
}
