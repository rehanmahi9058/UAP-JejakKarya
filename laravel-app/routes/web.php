<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\BerandaController::class, 'index'])->name('beranda');

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::resource('peta-karier', \App\Http\Controllers\RencanaKarierController::class)
        ->parameters(['peta-karier' => 'rencana']);

    Route::post('peta-karier/{rencana}/langkah', [\App\Http\Controllers\RencanaKarierController::class, 'tambahLangkah'])
        ->name('peta-karier.langkah.store');
    Route::patch('langkah/{langkah}', [\App\Http\Controllers\RencanaKarierController::class, 'toggleLangkah'])
        ->name('peta-karier.langkah.toggle');
    Route::delete('langkah/{langkah}', [\App\Http\Controllers\RencanaKarierController::class, 'hapusLangkah'])
        ->name('peta-karier.langkah.destroy');
});

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('profil', [\App\Http\Controllers\ProfilPenggunaController::class, 'edit'])->name('profil.edit');
    Route::put('profil', [\App\Http\Controllers\ProfilPenggunaController::class, 'update'])->name('profil.update');
});

Route::get('katalog', [\App\Http\Controllers\KatalogController::class, 'index'])->name('katalog.index');

Route::middleware('auth')->group(function () {
    Route::get('katalog/{id}', [\App\Http\Controllers\KatalogController::class, 'show'])->name('katalog.show');
});

Route::middleware(['auth', \App\Http\Middleware\AdminSaja::class])
    ->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [\App\Http\Controllers\AdminController::class, 'index'])->name('index');
        Route::patch('mentor/{id}/verifikasi', [\App\Http\Controllers\AdminController::class, 'verifikasi'])->name('mentor.verifikasi');
        Route::patch('mentor/{id}/cabut', [\App\Http\Controllers\AdminController::class, 'cabutVerifikasi'])->name('mentor.cabut');
        Route::patch('akun/{user}/toggle', [\App\Http\Controllers\AdminController::class, 'toggleAkun'])->name('akun.toggle');
    });