<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\CategoryController; 

// Rute Halaman Awal
Route::get('/', function () {
    return view('welcome');
});

// Rute Dashboard 
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');


// Grup Rute yang memerlukan Login
Route::middleware('auth')->group(function () {
    // Rute untuk Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rute untuk Tiket (bisa diakses User dan Admin)
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');
    
    // Rute untuk menyimpan balasan
    Route::post('/tickets/{ticket}/replies', [ReplyController::class, 'store'])->name('replies.store');
});

// Grup Route KHUSUS untuk Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Rute untuk mengubah status tiket
    Route::post('/tickets/{ticket}/status', [AdminTicketController::class, 'updateStatus'])->name('tickets.updateStatus');

    // Resource Route untuk Manajemen User
    Route::resource('users', UserController::class);
    // Resource Route untuk Manajemen Kategori
    Route::resource('categories', CategoryController::class); 
});

// File rute otentikasi dari Breeze
require __DIR__.'/auth.php';