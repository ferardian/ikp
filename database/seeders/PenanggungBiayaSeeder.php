<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenanggungBiayaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Change to aarray
        $penanggungBiaya = [
            'BPJS KESEHATAN / NON PBI',
            'PRUDENTIAL',
            'UMUM',
            'BPJS KESEHATAN / PBI',
            'UMUM/BPJS [Jangan dipakai]',
            'JAMPERSAL',
            'PBI',
        ];
        foreach ($penanggungBiaya as $biaya) {
            \App\Models\PenanggungBiaya::create(['jenis_penanggung' => $biaya]);
        }
    }
}
