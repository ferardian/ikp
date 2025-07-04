<?php

use App\Models\MasterPegawai;
use App\Models\MasterPetugas;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;




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

Route::get('/pegawai/sinkron', function () {
    $id = Request::get('nik');
    $pegawai = MasterPegawai::with(['dprtmn', 'petugas.jabatan'])->find($id);
    $passwordDecrypted = \App\Models\MasterUser::getPasswordDecryptedById($id)->first()->passwd;
    $unit = \App\Models\Unit::whereByName($pegawai->dprtmn->nama)->first();
    $jabatan = \App\Models\Jabatan::whereByName($pegawai->petugas->jabatan->nm_jbtn)->first();
    DB::beginTransaction();

    try {

        $user = \App\Models\User::create([
            'name' => $pegawai->nama,
            'username' => $id,
            'email' => \Illuminate\Support\Str::random(10) . '@mail.com',
            'email_verified_at' => \Carbon\Carbon::now(),
            'password' => \Illuminate\Support\Facades\Hash::make($passwordDecrypted),
            'remember_token' => \Illuminate\Support\Str::random(32),
        ]);


        $valueForDetail = [
            'user_id' => $user->id,
            'passwordDecrypted' => $passwordDecrypted,
            'unit_id' => $unit->id ?? 999,
            'jabatan_id' => $jabatan->id ?? 999,
            'departemen' => $pegawai->dprtmn->nama,
        ];
        \App\Models\UserDetail::create($valueForDetail);
        DB::commit();
        Notification::make()
            ->title("Berhasil Sinkron User $user->name")
            ->success()
            ->duration(5000)
            ->send();
        return redirect()->back();
    } catch (\Exception $e) {
        DB::rollback();
        Notification::make()
            ->title("Tidak Dapat Melakukan Sinkron User $user->name")
            ->danger()
            ->duration(5000)
            ->send();
        return redirect()->back();
    }






})->name('app.pegawai.sinkron');




// foreach ($master as $key => $value) {

// $decryptedPassword = DB::connection('mysql2')
//     ->table('user')
//     ->selectRaw("AES_DECRYPT(password, ?) as passwd", [config('database.aes_keys.password')])
//     ->whereRaw("id_user = AES_ENCRYPT(?, ?)", [$value->nik, config('database.aes_keys.id_user')])
//     ->value('passwd');
