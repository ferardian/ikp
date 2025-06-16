<?php

namespace App\Filament\Resources\InsidenResource\Filters;

use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class GradingInsiden
{
    public static function make()
    {
        return SelectFilter::make('grading')
            ->label('Grading Risiko')
            ->options([
                'Biru' => 'Biru',
                'Hijau' => 'Hijau',
                'Kuning' => 'Kuning',
                'Merah' => 'Merah',
                'Belum Ada' => 'Belum Grade'
            ])
            ->query(function ($query, $data) {
                if (!$data || !$data['value']) {
                    return $query;
                }

                if ($data['value'] === 'Belum Ada') {
                    return $query->doesntHave('grading');
                }

                $query->whereHas('grading', function (Builder $query) use ($data) {
                    $query->where('grading_risiko', $data['value']);
                });
            });
    }
}
