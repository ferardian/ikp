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

        // change bellow to array value this
        $units = [
            'ADMIN',
            'AKUNTANSI DAN PERBENDAHARAAN',
            'ANAK',
            'CASEMIX',
            'DIKLAT & KESEKRETARIATAN',
            'DIREKSI',
            'DOKTER SPESIALIS',
            'DOKTER UMUM',
            'FARMASI',
            'FARMASI RAWAT INAP',
            'FARMASI RAWAT JALAN',
            'FRONT OFFICE',
            'GIZI',
            'HCU',
            'HUMAS',
            'ICU/NICU/PICU',
            'IPCN',
            'IPSRS',
            'KAMAR OPERASI',
            'KEUANGAN DAN ANGGARAN',
            'KOMITE PMKP',
            'LABORAT',
            'LAUNDRY & CSSD',
            'LOGISTIK',
            'MANAJEMEN',
            'NIFAS',
            'ORIENTASI MEDIS',
            'ORIENTASI NON MEDIS',
            'PERINATOLOGI',
            'POLI',
            'PONEK',
            'PUBLIC RELATION',
            'RADIOLOGI',
            'REKAM MEDIS',
            'RUANG SITI KHADIJAH',
            'SATPAM',
            'SDI & PEMBINAAN ROHANI',
            'SISTEM INFORMASI TEKNOLOGI',
            'TEKNISI',
            'UGD & HCU',
            'VK',
        ];

        sort($units);

        foreach ($units as $unit) {
            \App\Models\Unit::create(['nama_unit' => $unit]);
        }
        \App\Models\Unit::create(['nama_unit' => 'LAIN-LAIN', 'id' => 999]);
    }
}
