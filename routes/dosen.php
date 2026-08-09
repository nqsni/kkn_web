<?php

use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('dosen.dashboard');
})->name('dosen.dashboard');
