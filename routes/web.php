<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstrukturController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PicController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| File ini mengatur semua route utama berdasarkan role & permission.
| Gunakan middleware 'auth' agar hanya user login yang bisa mengaksesnya.
|
*/

// Halaman utama (welcome page)
Route::get('/', function () {
    return view('welcome');
});

// ===================== ADMIN =====================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Contoh proteksi permission: hanya admin yang bisa kelola pengguna
    Route::get('/admin/users', [AdminController::class, 'manageUsers'])
        ->name('admin.users')
        ->middleware('permission:manage-users');

    Route::post('/admin/users/{id}/assign', [App\Http\Controllers\AdminController::class, 'assignRole'])
        ->name('admin.users.assign')
        ->middleware('permission:manage-users');
});

// ===================== INSTRUKTUR =====================
Route::middleware(['auth', 'role:instruktur'])->group(function () {
    Route::get('/instruktur/dashboard', [InstrukturController::class, 'index'])
        ->name('instruktur.dashboard');
});

// ===================== SISWA =====================
Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/siswa/dashboard', [SiswaController::class, 'index'])->name('siswa.dashboard');
});

// ===================== PIC =====================
Route::middleware(['auth', 'role:pic'])->group(function () {
    Route::get('/pic/dashboard', [PicController::class, 'index'])->name('pic.dashboard');
});

// Default auth routes (bawaan Laravel Breeze / Jetstream)
require __DIR__ . '/auth.php';
