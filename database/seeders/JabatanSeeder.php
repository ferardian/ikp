<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jabatans = [
            'Direktur',
            'Wakil Direktur',
            'Administrasi Umum',
            'Analis',
            'Apoteker',
            'Asisten Apoteker',
            'Asisten Manajer',
            'Bidan',
            'Binroh',
            'Cleaning Service',
            'Dokter',
            'Dokter Spesialis',
            'Farmasi',
            'Gizi',
            'IPSRS',
            'IT',
            'Kepala Ruang Gizi',
            'Kepala Ruang Nifas',
            'Kepala Ruang OK',
            'Kepala Ruang Peri',
            'Kepala Ruang Poli',
            'Kepala Ruang UGD',
            'Kepala Ruang VK',
            'Keuangan',
            'Lab',
            'Manajer',
            'Nifas',
            'Pekarya',
            'Pendaftaran',
            'Perawat',
            'Radiografer',
            'Rekam Medis',
            'Sanitarian',
            'Satpam/Penjaga Malam',
            'Teknisi',
            'Teknisi Elektromedik',
        ];

        foreach ($jabatans as $jabatan) {
            \App\Models\Jabatan::create([
                'kode' => \Illuminate\Support\Str::slug($jabatan),
                'nama' => $jabatan,
                'deskripsi' => "Jabatan $jabatan"
            ]);
        }



        $units = \App\Models\Unit::all();
        foreach ($units as $key => $value) {
            $jabatan = \App\Models\Jabatan::where('nama', "Kepala Unit $value->nama_unit")->first();
            if (!$jabatan) {
                \App\Models\Jabatan::create([
                    'kode' => \Illuminate\Support\Str::slug("Kepala Unit $value->nama_unit"),
                    'nama' => "Kepala Unit $value->nama_unit",
                    'deskripsi' => "Jabatan Kepala Unit $value->nama_unit"
                ]);
            }
        }

        \App\Models\Jabatan::create([
            'id' => 999,
            'kode' => \Illuminate\Support\Str::slug('Lain-lain'),
            'nama' => 'Lain-lain',
            'deskripsi' => "Jabatan $jabatan"
        ]);
    }
}
