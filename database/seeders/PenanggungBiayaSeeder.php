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
        $penanggungBiaya = [
            'BPJS Kesehatan',
            'Jamkesda',
            'Umum / Pribadi',
            'Asuransi Swasta',
            'Pemerintah',
            'Perusahaan',
            'Lain-Lain'
        ];

        foreach ($penanggungBiaya as $biaya) {
            \App\Models\PenanggungBiaya::create(['jenis_penanggung' => $biaya]);
        }
    }
}
