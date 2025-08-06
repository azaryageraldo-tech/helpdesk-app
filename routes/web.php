<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\Admin\TicketController as AdminTicketController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ReportController;

// Alihkan halaman utama ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
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

    // Rute untuk Notifikasi
    Route::get('/notifications', [NotificationController::class, 'fetch'])->name('notifications.fetch');
    Route::post('/notifications/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
});

// Grup Route KHUSUS untuk Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Rute Aksi Tiket
    Route::post('/tickets/{ticket}/status', [AdminTicketController::class, 'updateStatus'])->name('tickets.updateStatus');
    Route::post('/tickets/{ticket}/assign', [AdminTicketController::class, 'assignTicket'])->name('tickets.assign');

    // Resource Route untuk Manajemen
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);

    // Rute Laporan
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});

// File rute otentikasi dari Breeze
require __DIR__.'/auth.php';
