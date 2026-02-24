<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard Utama (Auto-switch view via Controller)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Group khusus ADMIN
    Route::prefix('admin')->name('admin.')->group(function () {
        // Kelola Guru
        Route::get('/guru', [DashboardController::class, 'indexGuru'])->name('guru');
        Route::post('/add-guru', [DashboardController::class, 'storeGuru'])->name('storeGuru');
        Route::delete('/guru/{id}', [DashboardController::class, 'destroyGuru'])->name('destroyGuru');
        
        // Profil Admin (Sekarang Aman di dalam Middleware)
        Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
        Route::post('/profile/update', [DashboardController::class, 'profileUpdate'])->name('profile.update');
    });

    // Chat System (Untuk Guru & Murid)
    Route::post('/send-message', [DashboardController::class, 'sendMessage'])->name('chat.send');
    Route::delete('/chat/{id}', [DashboardController::class, 'destroy'])->name('chat.destroy');

    // Profile Bawaan Laravel (Bisa lo pake buat role Murid/User umum)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';