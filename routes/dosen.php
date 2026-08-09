<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DosenController;

// Rute ini otomatis menggunakan prefix '/dosen' dan dilindungi middleware di web.php
Route::get('/dashboard', [DosenController::class, 'dashboard'])->name('dosen.dashboard');
Route::get('/pengajuan/proyek', [DosenController::class, 'pengajuanProyek'])->name('dosen.pengajuan.proyek');
Route::get('/pengajuan/validasi', [DosenController::class, 'validasiProposal'])->name('dosen.validasi.proposal');
Route::get('/penilaian', [DosenController::class, 'penilaian'])->name('dosen.penilaian');
Route::get('/profile', [DosenController::class, 'profile'])->name('dosen.profile');