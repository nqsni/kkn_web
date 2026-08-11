<?php

use App\Http\Controllers\Panitia\ValidasiProyekController;
use App\Http\Controllers\Panitia\PenempatanController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('panitia.dashboard');
})->name('panitia.dashboard');

Route::prefix('validasi-proyek')->name('panitia.validasi-proyek.')->group(function () {
    Route::get('/', [ValidasiProyekController::class, 'index'])->name('index');
    Route::get('/{proyek}', [ValidasiProyekController::class, 'show'])->name('show');
    Route::post('/{proyek}', [ValidasiProyekController::class, 'update'])->name('update');
});

Route::prefix('penempatan')->name('panitia.penempatan.')->group(function () {
    Route::get('/', [PenempatanController::class, 'index'])->name('index');
    Route::post('/{proyek}/assign', [PenempatanController::class, 'assign'])->name('assign');
    Route::post('/{proyek}/reassign', [PenempatanController::class, 'reassign'])->name('reassign');
});