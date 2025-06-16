<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
            'unit_id' => \App\Models\Unit::where('nama_unit', 'Sistem Informasi Dan Teknologi')->first()->id,
            'jabatan_id' => \App\Models\Jabatan::where('nama', 'Kepala Unit Sistem Informasi Dan Teknologi')->first()->id,
            'departemen' => 'Sistem Informasi Dan Teknologi',
        ]);

        // artisan call command php artisan shield:super-admin --user=1 --panel=app
        \Illuminate\Support\Facades\Artisan::call('shield:super-admin', [
            '--user' => $admin->id,
            '--panel' => 'app',
        ]);


        \App\Models\User::factory(10)->create()->each(function ($user) {
            \App\Models\UserDetail::create([
                'user_id' => $user->id,
                'unit_id' => \App\Models\Unit::inRandomOrder()->first()->id,
                'jabatan_id' => \App\Models\Jabatan::inRandomOrder()->first()->id,
                'departemen' => \App\Models\Unit::inRandomOrder()->first()->nama_unit,
            ]);
        });
    }
}
