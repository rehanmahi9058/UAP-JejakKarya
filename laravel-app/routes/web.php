<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

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

Route::middleware('auth')->group(function () {
    Route::get('katalog', [\App\Http\Controllers\KatalogController::class, 'index'])->name('katalog.index');
    Route::get('katalog/{id}', [\App\Http\Controllers\KatalogController::class, 'show'])->name('katalog.show');
});

Route::middleware('auth')->group(function () {
    Route::get('mentor/portofolio', [\App\Http\Controllers\PortofolioMentorController::class, 'index'])->name('mentor.portofolio.index');
    Route::get('mentor/portofolio/create', [\App\Http\Controllers\PortofolioMentorController::class, 'create'])->name('mentor.portofolio.create');
    Route::post('mentor/portofolio', [\App\Http\Controllers\PortofolioMentorController::class, 'store'])->name('mentor.portofolio.store');
    Route::get('mentor/portofolio/{entri}/edit', [\App\Http\Controllers\PortofolioMentorController::class, 'edit'])->name('mentor.portofolio.edit');
    Route::put('mentor/portofolio/{entri}', [\App\Http\Controllers\PortofolioMentorController::class, 'update'])->name('mentor.portofolio.update');
    Route::delete('mentor/portofolio/{entri}', [\App\Http\Controllers\PortofolioMentorController::class, 'destroy'])->name('mentor.portofolio.destroy');
    Route::patch('mentor/portofolio/{entri}/terbit', [\App\Http\Controllers\PortofolioMentorController::class, 'terbit'])->name('mentor.portofolio.terbit');
});

Route::get('portofolio/{mentor}', [\App\Http\Controllers\PortofolioPublikController::class, 'index'])->name('portofolio.publik.index');
Route::get('portofolio/{mentor}/{entri}', [\App\Http\Controllers\PortofolioPublikController::class, 'show'])->name('portofolio.publik.show');

Route::middleware('auth')->group(function () {
    // Sisi pengguna: lihat slot tersedia milik satu mentor
    Route::get('katalog/{id}/slot', [\App\Http\Controllers\SlotMentoringController::class, 'tersedia'])->name('katalog.slot');

    // Sisi mentor: kelola slot milik sendiri
    Route::get('mentor/slot', [\App\Http\Controllers\SlotMentoringController::class, 'index'])->name('mentor.slot.index');
    Route::get('mentor/slot/create', [\App\Http\Controllers\SlotMentoringController::class, 'create'])->name('mentor.slot.create');
    Route::post('mentor/slot', [\App\Http\Controllers\SlotMentoringController::class, 'store'])->name('mentor.slot.store');
    Route::get('mentor/slot/{slot}/edit', [\App\Http\Controllers\SlotMentoringController::class, 'edit'])->name('mentor.slot.edit');
    Route::put('mentor/slot/{slot}', [\App\Http\Controllers\SlotMentoringController::class, 'update'])->name('mentor.slot.update');
    Route::delete('mentor/slot/{slot}', [\App\Http\Controllers\SlotMentoringController::class, 'destroy'])->name('mentor.slot.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('sesi', [\App\Http\Controllers\SesiMentoringController::class, 'index'])->name('sesi.index');
    Route::post('slot/{slot}/pesan', [\App\Http\Controllers\SesiMentoringController::class, 'store'])->name('sesi.store');
    Route::get('sesi/{sesi}', [\App\Http\Controllers\SesiMentoringController::class, 'show'])->name('sesi.show');
    Route::patch('sesi/{sesi}/batal', [\App\Http\Controllers\SesiMentoringController::class, 'batal'])->name('sesi.batal');
    Route::patch('sesi/{sesi}/konfirmasi', [\App\Http\Controllers\SesiMentoringController::class, 'konfirmasi'])->name('sesi.konfirmasi');
    Route::patch('sesi/{sesi}/selesai', [\App\Http\Controllers\SesiMentoringController::class, 'selesai'])->name('sesi.selesai');
});