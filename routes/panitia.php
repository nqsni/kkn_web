<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PanitiaController;

Route::get('/dashboard', [PanitiaController::class, 'dashboard'])->name('panitia.dashboard');
Route::get('/validasi/proyek', [PanitiaController::class, 'validasiProyek'])->name('panitia.validasi.proyek');
Route::get('/validasi/proposal', [PanitiaController::class, 'validasiProposal'])->name('panitia.validasi.proposal');
Route::get('/nilai', [PanitiaController::class, 'lihatNilai'])->name('panitia.lihat.nilai');
Route::get('/profile', [PanitiaController::class, 'profile'])->name('panitia.profile');