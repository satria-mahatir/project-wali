<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman Landing Page
Route::get('/', function () {
    return view('welcome');
});

// Grup Route yang Wajib Login (Auth)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard Utama (Logic pemisah Admin/Guru/Murid ada di Controller)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Komunikasi (Chat)
    Route::post('/send-message', [DashboardController::class, 'sendMessage'])->name('chat.send');
    Route::delete('/chat/{id}', [DashboardController::class, 'destroy'])->name('chat.destroy');

    // Khusus Manajemen Guru (Akses Admin Only)
    Route::get('/admin/guru', [DashboardController::class, 'indexGuru'])->name('admin.guru');
    Route::post('/admin/add-guru', [DashboardController::class, 'storeGuru'])->name('admin.storeGuru');
    Route::delete('/admin/guru/{id}', [DashboardController::class, 'destroyGuru'])->name('admin.destroyGuru');

    // Profile Settings bawaan Laravel Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';