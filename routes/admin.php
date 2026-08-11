<?php

use App\Http\Controllers\Admin\DataMasterController;
use App\Http\Controllers\Admin\RubrikPenilaianController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

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