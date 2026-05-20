<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        // Guru
        Route::get('/guru', [DashboardController::class, 'indexGuru'])->name('guru');
        Route::post('/add-guru', [DashboardController::class, 'storeGuru'])->name('storeGuru');
        Route::delete('/guru/{id}', [DashboardController::class, 'destroyGuru'])->name('destroyGuru');
        
        // Murid & Import Excel
        Route::post('/add-murid', [DashboardController::class, 'storeMurid'])->name('storeMurid');
        Route::delete('/murid/{id}', [DashboardController::class, 'destroyMurid'])->name('destroyMurid');
        Route::post('/import-murid', [DashboardController::class, 'importMurid'])->name('importMurid');
        
        // Profil
        Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
        Route::post('/profile/update', [DashboardController::class, 'profileUpdate'])->name('profile.update');
    });

    Route::post('/send-message', [DashboardController::class, 'sendMessage'])->name('chat.send');
    Route::delete('/chat/{id}', [DashboardController::class, 'destroy'])->name('chat.destroy');

    Route::get('/profile-settings', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile-settings', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile-settings', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';