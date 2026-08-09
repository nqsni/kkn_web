<?php

use Illuminate\Support\Facades\Route;

Route::get('/dashboard', function () {
    return view('panitia.dashboard');
})->name('panitia.dashboard');