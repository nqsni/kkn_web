<?php

use App\Http\Controllers\Admin\DataMasterController;
use App\Http\Controllers\Admin\RubrikPenilaianController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PeriodeController;
use App\Http\Controllers\Admin\AkunController;
use App\Http\Controllers\Admin\KapasitasController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::prefix('periode')->name('admin.periode.')->group(function () {
    Route::get('/', [PeriodeController::class, 'index'])->name('index');
    Route::get('/create', [PeriodeController::class, 'create'])->name('create');
    Route::post('/', [PeriodeController::class, 'store'])->name('store');
    Route::patch('/{periode}/status', [PeriodeController::class, 'updateStatus'])->name('update-status');

    Route::prefix('{periode}/akun')->name('akun.')->group(function () {
        Route::get('/', [AkunController::class, 'index'])->name('index');
        Route::post('/baru', [AkunController::class, 'storeNew'])->name('store-new');
        Route::post('/existing', [AkunController::class, 'storeExisting'])->name('store-existing');
        Route::delete('/{user}', [AkunController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('{periode}/kapasitas')->name('kapasitas.')->group(function () {
        Route::get('/', [KapasitasController::class, 'index'])->name('index');
        Route::patch('/{proyek}/kuota', [KapasitasController::class, 'updateKuota'])->name('update-kuota');
        Route::post('/{proyek}/rilis', [KapasitasController::class, 'rilis'])->name('rilis');
    });
});

Route::prefix('data-master')->name('admin.data-master.')->group(function () {
    Route::get('/', [DataMasterController::class, 'index'])->name('index');
    Route::post('/', [DataMasterController::class, 'store'])->name('store');
    Route::delete('/{dataMaster}', [DataMasterController::class, 'destroy'])->name('destroy');
});

Route::prefix('rubrik-penilaian')->name('admin.rubrik-penilaian.')->group(function () {
    Route::get('/', [RubrikPenilaianController::class, 'index'])->name('index');
    Route::post('/', [RubrikPenilaianController::class, 'store'])->name('store');
    Route::patch('/{rubrikPenilaian}', [RubrikPenilaianController::class, 'update'])->name('update');
    Route::delete('/{rubrikPenilaian}', [RubrikPenilaianController::class, 'destroy'])->name('destroy');
});

Route::prefix('users')->name('admin.users.')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::patch('/{user}/role', [UserController::class, 'updateRole'])->name('update-role');
});