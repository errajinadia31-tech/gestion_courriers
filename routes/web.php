<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\CourrierController;
use App\Http\Controllers\CourrierPrintController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\LayoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransmissionController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

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
    // Liste des archives
    Route::get('/archive', [ArchiveController::class, 'index'])->name('archive');

    // Archiver un courrier
    Route::put('/courrier/{courrier}/archive', [ArchiveController::class, 'archive'])->name('courrier.archive');

    // Supprimer une archive
    Route::delete('/archive/{archive}', [ArchiveController::class, 'destroy'])->name('archive.destroy');
});
// Courrier
Route::middleware('auth')->group(function () {

    
    Route::get('/courrier', [CourrierController::class, 'index'])->name('courrier');

    Route::get('create', [CourrierController::class, 'create'])->name('courrier.create');

   
    Route::post('/courrier', [CourrierController::class, 'store'])->name('courrier.store');

Route::get('/courrier/{courrier}', [CourrierController::class, 'show'])->name('show.view');

Route::delete('/courrier/{id}', [CourrierController::class, 'destroy'])->name('courrier.destroy');

Route::get('/courrier/{id}/edit', [CourrierController::class, 'edit'])->name('courrier.edit');

Route::put('/courrier/{id}', [CourrierController::class, 'update'])->name('courrier.update');
});

// Layout
Route::get('custom', [LayoutController::class, 'layout'])->name('layout');
Route::get('/ajouter', [CourrierController::class, 'ajouter'])->name('ajouter');

//  Archive
Route::put('/courrier/{courrier}/archive', [ArchiveController::class, 'archive'])
    ->name('courrier.archive');
Route::put('/courrier/{courrier}/restore', [ArchiveController::class, 'restore'])->name('courrier.restore');
Route::delete('/archive/{archive}', [ArchiveController::class, 'destroy'])->name('archive.destroy');

Route::middleware('auth')->group(function () {
Route::get('/transmissions', [TransmissionController::class, 'list'])->name('transmissions.list');
    Route::get('/transmissions/create', [TransmissionController::class, 'create'])->name('transmissions.create');
    Route::post('/transmissions', [TransmissionController::class, 'store'])->name('transmissions.store');
    Route::delete('/transmissions/{transmission}', [TransmissionController::class, 'destroy'])->name('transmissions.destroy');
});


// send mail
Route::get('/email', [EmailController::class, 'sendEmail'])->name('email');

Route::get('/print/{id}', [CourrierPrintController::class, 'print'])->name('print');
Route::get('/download/{id}', [CourrierPrintController::class, 'download'])->name('courrier.download');

require __DIR__.'/auth.php';