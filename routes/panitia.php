<?php

use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return 'Halo Panitia!';
})->name('panitia.dashboard');