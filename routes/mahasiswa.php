<?php

use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return 'Halo Mahasiswa!';
})->name('mahasiswa.dashboard');