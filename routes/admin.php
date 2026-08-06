<?php

use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return 'Halo Admin!';
})->name('admin.dashboard');