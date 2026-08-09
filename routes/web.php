<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:mahasiswa'])
    ->prefix('mahasiswa')
    ->group(base_path('routes/mahasiswa.php'));

Route::middleware(['auth', 'role:dosen_pembimbing'])
    ->prefix('dosen')
    ->group(base_path('routes/dosen.php'));

Route::middleware(['auth', 'role:panitia_kkn'])
    ->prefix('panitia')
    ->group(base_path('routes/panitia.php'));

Route::middleware(['auth', 'role:super_admin'])
    ->prefix('admin')
    ->group(base_path('routes/admin.php'));

require __DIR__.'/auth.php';