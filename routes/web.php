<?php

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
