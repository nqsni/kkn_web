<?php

use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return 'Halo Dosen!';
})->name('dosen.dashboard');