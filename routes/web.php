<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\CourrierController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LayoutController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Archive
Route::middleware('auth')->group(function () {
    Route::get('/archive', [ArchiveController::class, 'archive'])->name('archive');
    Route::post('/archive/{courrier}', [ArchiveController::class, 'store'])->name('archive.store');
    Route::delete('/archive/{archive}', [ArchiveController::class, 'destroy'])->name('archive.destroy');
});

// Courrier

Route::middleware('auth')->group(function () {
    Route::get('/courrier', [CourrierController::class, 'index'])->name('courrier');
    Route::get('/ajouter', [CourrierController::class, 'create'])->name('ajouter');
    Route::post('/courrier/store', [CourrierController::class, 'store'])->name('courrier.store');

//      Route::get('/courrier/{courrier}', [CourrierController::class, 'show'])->name('courriers.show');
    Route::get('/courrier/{courrier}/edit', [CourrierController::class, 'edit'])->name('courriers.edit');
//      Route::put('/courrier/{courrier}', [CourrierController::class, 'update'])->name('courriers.update');
//      Route::delete('/courrier/{courrier}', [CourrierController::class, 'destroy'])->name('courriers.destroy');

 });

// Layout
Route::get('custom', [LayoutController::class, 'layout'])->name('layout');
Route::get('/ajouter', [LayoutController::class, 'ajouter'])->name('ajouter');

require __DIR__.'/auth.php';