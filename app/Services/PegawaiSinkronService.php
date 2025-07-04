<?php

namespace App\Services;

use App\Models\Jabatan;
use App\Models\MasterUser;
use App\Models\MasterPegawai;
use App\Models\Unit;
use App\Models\User;
use App\Models\UserDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PegawaiSinkronService
{
    public function handle(string $id): User
    {
        return DB::transaction(function () use ($id) {
            $pegawai = MasterPegawai::with(['dprtmn', 'petugas.jabatan'])->findOrFail($id);

            $passwordDecrypted = MasterUser::getPasswordDecryptedById($id)->first()->passwd;
            $unit = Unit::whereByName($pegawai->dprtmn->nama)->first();
            $jabatan = Jabatan::whereByName($pegawai->petugas->jabatan->nm_jbtn)->first();

            $user = User::create([
                'name' => $pegawai->nama,
                'username' => $id,
                'email' => Str::random(10) . '@mail.com',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make($passwordDecrypted),
                'remember_token' => Str::random(32),
            ]);

            UserDetail::create([
                'user_id' => $user->id,
                'passwordDecrypted' => $passwordDecrypted,
                'unit_id' => $unit->id ?? 999,
                'jabatan_id' => $jabatan->id ?? 999,
                'departemen' => $pegawai->dprtmn->nama,
            ]);

            return $user;
        });
    }
}
