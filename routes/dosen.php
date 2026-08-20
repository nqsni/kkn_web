<?php

use App\Http\Controllers\Dosen\ValidasiProposalController;
use App\Http\Controllers\Dosen\PenilaianLogbookController;
use App\Http\Controllers\Dosen\PenilaianLaporanController;
use App\Http\Controllers\Dosen\PenilaianAkhirController;
use App\Http\Controllers\Dosen\ProyekController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dosen.dashboard');
})->name('dosen.dashboard');

Route::prefix('proyek')->name('dosen.proyek.')->group(function () {
    Route::get('/', [ProyekController::class, 'index'])->name('index');
    Route::get('/create', [ProyekController::class, 'create'])->name('create');
    Route::post('/', [ProyekController::class, 'store'])->name('store');
    Route::get('/{proyek}', [ProyekController::class, 'show'])->name('show');
    Route::delete('/{proyek}', [ProyekController::class, 'destroy'])->name('destroy');
});

Route::prefix('validasi-proposal')->name('dosen.validasi-proposal.')->group(function () {
    Route::get('/', [ValidasiProposalController::class, 'index'])->name('index');
    Route::get('/{proposal}', [ValidasiProposalController::class, 'show'])->name('show');
    Route::post('/{proposal}', [ValidasiProposalController::class, 'update'])->name('update');
});

Route::prefix('penilaian-logbook')->name('dosen.penilaian-logbook.')->group(function () {
    Route::get('/', [PenilaianLogbookController::class, 'index'])->name('index');
    Route::get('/{logbook}/edit', [PenilaianLogbookController::class, 'edit'])->name('edit');
    Route::post('/{logbook}', [PenilaianLogbookController::class, 'update'])->name('update');
});

Route::prefix('penilaian-laporan')->name('dosen.penilaian-laporan.')->group(function () {
    Route::get('/', [PenilaianLaporanController::class, 'index'])->name('index');
    Route::get('/{laporan}/edit', [PenilaianLaporanController::class, 'edit'])->name('edit');
    Route::post('/{laporan}', [PenilaianLaporanController::class, 'update'])->name('update');
});

Route::prefix('penilaian-akhir')->name('dosen.penilaian-akhir.')->group(function () {
    Route::get('/', [PenilaianAkhirController::class, 'index'])->name('index');
    Route::get('/{proyek}/edit', [PenilaianAkhirController::class, 'edit'])->name('edit');
    Route::post('/{proyek}', [PenilaianAkhirController::class, 'update'])->name('update');
});