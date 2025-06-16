<?php

namespace App\Helpers;

use Carbon\Carbon;

class UsiaHelper
{
    public static function kelompokUsiaData()
    {
        return [
            1 => "0 - 1 Bulan",
            2 => "> 1 Bulan - 1 Tahun",
            3 => "> 1 Tahun - 5 Tahun",
            4 => "> 5 Tahun - 15 Tahun",
            5 => "> 15 Tahun - 30 Tahun",
            6 => "> 30 Tahun - 65 Tahun",
            7 => "> 65 Tahun"
        ];
    }

    public static function getKelompokUsia(Carbon $tanggal_lahir)
    {
        $usia_tahun = $tanggal_lahir->diffInYears(Carbon::now());
        $usia_bulan = $tanggal_lahir->diffInMonths(Carbon::now());

        if ($usia_bulan <= 1) {
            return 1; // 0-1 Bulan
        } elseif ($usia_bulan > 1 && $usia_tahun < 1) {
            return 2; // >1 Bulan - 1 Tahun
        } elseif ($usia_tahun >= 1 && $usia_tahun < 5) {
            return 3; // >1 Tahun - 5 Tahun
        } elseif ($usia_tahun >= 5 && $usia_tahun < 15) {
            return 4; // >5 Tahun - 15 Tahun
        } elseif ($usia_tahun >= 15 && $usia_tahun < 30) {
            return 5; // >15 Tahun - 30 Tahun
        } elseif ($usia_tahun >= 30 && $usia_tahun < 65) {
            return 6; // >30 Tahun - 65 Tahun
        } elseif ($usia_tahun >= 65) {
            return 7; // >65 Tahun
        }

        return null; // fallback jika data tidak sesuai
    }
}