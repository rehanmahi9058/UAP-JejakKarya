<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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
