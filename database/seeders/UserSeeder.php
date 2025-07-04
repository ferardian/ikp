<?php

namespace Database\Seeders;

use App\Models\MasterPegawai;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // administrator as super admin
        $admin = \App\Models\User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@mail.com',
            'email_verified_at' => now(),
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'remember_token' => \Illuminate\Support\Str::random(32),
        ]);

        \App\Models\UserDetail::create([
            'user_id' => $admin->id,
            'unit_id' => \App\Models\Unit::where('nama_unit', 'SISTEM INFORMASI TEKNOLOGI')->first()->id,
            'jabatan_id' => \App\Models\Jabatan::where('nama', 'IT')->first()->id,
            'departemen' => 'SISTEM INFORMASI TEKNOLOGI',
        ]);

        // artisan call command php artisan shield:super-admin --user=1 --panel=app
        \Illuminate\Support\Facades\Artisan::call('shield:super-admin', [
            '--user' => $admin->id,
            '--panel' => 'app',
        ]);


        $master = MasterPegawai::with(['dprtmn', 'petugas.jabatan'])->where('nik', '!=', 'Admin')->whereHas('petugas', function ($query) {
            $query->where('status', '1');
        })->get();

        foreach ($master as $key => $value) {

            $decryptedPassword = \App\Models\MasterUser::getPasswordDecryptedById($value->nik)
                ->first()?->passwd;

            $user = \App\Models\User::create([
                'name' => $value->nama,
                'username' => $value->nik,
                //give random email
                'email' => \Illuminate\Support\Str::random(10) . '@mail.com',
                'email_verified_at' => now(),
                'password' => \Illuminate\Support\Facades\Hash::make($decryptedPassword),
                'remember_token' => \Illuminate\Support\Str::random(32),
            ]);

            $unit_id = \App\Models\Unit::where('nama_unit', $value->dprtmn->nama)->first();
            $jabatan_id = \App\Models\Jabatan::where('nama', $value->petugas->jabatan->nm_jbtn)->first();
            \App\Models\UserDetail::create([
                'user_id' => $user->id,
                'unit_id' => $unit_id->id ?? 999,
                'jabatan_id' => $jabatan_id->id ?? 999,
                'departemen' => $value->dprtmn->nama,
            ]);
        }
        // \App\Models\User::factory(10)->create()->each(function ($user) {

        // });
    }
}
