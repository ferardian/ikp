<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisInsidenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenisInsiden = [
            [
                "alias" => "KPC",
                "nama_jenis_insiden" =>  "Kejadian Potensial Cedera",
            ],
            [
                "alias" => "KNC",
                "nama_jenis_insiden" =>  "Kejadian Nyaris Cedera",
            ],
            [
                "alias" => "KTC",
                "nama_jenis_insiden" =>  "Kejadian Tidak Cedera",
            ],
            [
                "alias" => "KTD",
                "nama_jenis_insiden" =>  "Kejadian Tidak Diharapkan",
            ],
            [
                "alias" => "SENTINEL",
                "nama_jenis_insiden" =>  "Kejadian Sentinel"
            ],
        ];

        foreach ($jenisInsiden as $jenisInsiden) {
            \App\Models\JenisInsiden::create($jenisInsiden);
        }
    }
}
