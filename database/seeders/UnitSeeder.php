<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // ======================================== Unit
        $units = [
            'Casemix',
            'Farmasi',
            'Radiologi',
            'Nifas',
            'Gizi',
            'Kamar Operasi',
            'Patologi',
            'Laundry',
            'Laboratorium',
            'Persalinan',
            'Perinatologi',
            "UGD / IGD",
            "Poliklinik",
            "Rekam Medis",
            "Keuangan Dan Akuntansi",
            "Sistem Informasi Dan Teknologi",
            "IPSRS",
            "VK"
        ];

        sort($units);

        foreach ($units as $unit) {
            \App\Models\Unit::create(['nama_unit' => $unit]);
        }
    }
}
