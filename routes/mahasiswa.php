<?php

use App\Http\Controllers\Mahasiswa\ProyekController;
use App\Http\Controllers\Mahasiswa\WarController;
use App\Http\Controllers\Mahasiswa\ProposalController;
use App\Http\Controllers\Mahasiswa\LogbookController;
use App\Http\Controllers\Mahasiswa\LaporanAkhirController;
use App\Http\Controllers\Mahasiswa\NilaiController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('mahasiswa.dashboard');
})->name('mahasiswa.dashboard');

Route::prefix('proyek')->name('mahasiswa.proyek.')->group(function () {
    Route::get('/', [ProyekController::class, 'index'])->name('index');
    Route::get('/create', [ProyekController::class, 'create'])->name('create');
    Route::post('/', [ProyekController::class, 'store'])->name('store');
    Route::get('/{proyek}', [ProyekController::class, 'show'])->name('show');
});

Route::prefix('war')->name('mahasiswa.war.')->group(function () {
    Route::get('/', [WarController::class, 'index'])->name('index');
    Route::post('/{proyek}/join', [WarController::class, 'join'])->name('join');
});

Route::prefix('proposal')->name('mahasiswa.proposal.')->group(function () {
    Route::get('/', [ProposalController::class, 'index'])->name('index');
    Route::post('/', [ProposalController::class, 'store'])->name('store');
});

Route::prefix('logbook')->name('mahasiswa.logbook.')->group(function () {
    Route::get('/', [LogbookController::class, 'index'])->name('index');
    Route::post('/', [LogbookController::class, 'store'])->name('store');
});

Route::prefix('laporan-akhir')->name('mahasiswa.laporan-akhir.')->group(function () {
    Route::get('/', [LaporanAkhirController::class, 'index'])->name('index');
    Route::post('/', [LaporanAkhirController::class, 'store'])->name('store');
});

Route::get('/nilai', [NilaiController::class, 'index'])->name('mahasiswa.nilai.index');