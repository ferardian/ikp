<?php

use App\Models\MasterPegawai;
use App\Models\MasterPetugas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;


Route::get('/test', function () {
    $master = MasterPegawai::with(['dprtmn', 'petugas.jabatan'])->where('nik', '!=', 'Admin')->whereHas('petugas', function ($query) {
        $query->where('status', '1');
    })->get();

    foreach ($master as $key => $value) {
        $petugas[] = $value->petugas;
        // $decryptedPassword = DB::connection('mysql2')
        //     ->table('user')
        //     ->selectRaw("AES_DECRYPT(password, ?) as passwd", [config('database.aes_keys.password')])
        //     ->whereRaw("id_user = AES_ENCRYPT(?, ?)", [$value->id_user, config('database.aes_keys.id_user')])
        //     ->value('passwd');
        $unit[] = \App\Models\Unit::where('nama_unit', $value->dprtmn->nama)->first()?->id;
        $jabatan[] = \App\Models\Jabatan::where('nama', $value)->first();
        // $user = \App\Models\User::create([
        //     'name' => $value->nama,
        //     'username' => $value->nik,
        //     //give random email
        //     'email' => \Illuminate\Support\Str::random(10) . '@mail.com',
        //     'email_verified_at' => now(),
        //     'password' => \Illuminate\Support\Facades\Hash::make($decryptedPassword),
        //     'remember_token' => \Illuminate\Support\Str::random(32),
        // ]);
        // \App\Models\UserDetail::create([
        //     'user_id' => $user->id,
        //     'unit_id' => \App\Models\Unit::where('nama_unit', $value->dprtmn->nama)->first()->id,
        //     'jabatan_id' => \App\Models\Jabatan::where('nama', $value->petugas->jabatan->nm_jabatan)->first()->id,
        //     'departemen' => $value->dprtmn->nama,
        // ]);
    }

    return ['PETUGSA' => $petugas, 'JABATAN' => $jabatan];



});

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

//print insiden
Route::prefix('app/insiden')->middleware(['web'])->group(function () {
    Route::get('{insiden}/print', [\App\Http\Controllers\PDFController::class, 'print'])->name('insiden.print');
});

Route::prefix('app/rca')->middleware(['web'])->group(function () {
    Route::get('/fishbone/render', [\App\Http\Controllers\RCAFishboneController::class, 'render'])->name('rca.fishbone.render');
    Route::get('{rca}/fishbone', [\App\Http\Controllers\RCAFishboneController::class, 'fishbone'])->name('rca.fishbone');
});

Route::prefix('ikp')->group(function () {
    Route::get('/', function () {
        return redirect('/app');
    });

    Route::get('{any}', function () {
        return redirect('/app');
    })->where('any', '.*');
});




// foreach ($master as $key => $value) {

// $decryptedPassword = DB::connection('mysql2')
//     ->table('user')
//     ->selectRaw("AES_DECRYPT(password, ?) as passwd", [config('database.aes_keys.password')])
//     ->whereRaw("id_user = AES_ENCRYPT(?, ?)", [$value->nik, config('database.aes_keys.id_user')])
//     ->value('passwd');
