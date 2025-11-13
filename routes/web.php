<?php

use App\Http\Controllers\KontrakKelasController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\InstrukturController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\PicController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;

// ===================== HALAMAN UTAMA =====================
Route::get('/', function () {
    return view('welcome');
});

// ===================== PROFILE =====================
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// ===================== ADMIN =====================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/users', [AdminController::class, 'manageUsers'])
        ->name('admin.users')
        ->middleware('permission:manage-users');

    Route::get('/admin/users/create', [AdminController::class, 'create'])
        ->name('admin.create')
        ->middleware('permission:manage-users');

    Route::post('/admin/users/store', [AdminController::class, 'store'])
        ->name('admin.store')
        ->middleware('permission:manage-users');

    Route::get('/admin/users/{id}/edit', [AdminController::class, 'edit'])
        ->name('admin.users.edit')
        ->middleware('permission:manage-users');

    Route::put('/admin/users/{id}/update', [AdminController::class, 'update'])
        ->name('admin.users.update')
        ->middleware('permission:manage-users');

    Route::get('/admin/users/{id}/show', [AdminController::class, 'show'])
        ->name('admin.users.show')
        ->middleware('permission:manage-users');

    Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser'])
        ->name('admin.users.delete')
        ->middleware('permission:manage-users');

    Route::post('/admin/users/{id}/assign', [AdminController::class, 'assignRole'])
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

// ===================== UNIVERSAL REDIRECT =====================
Route::middleware(['auth'])->get('/dashboard', function () {
    $user = Auth::user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('instruktur')) {
        return redirect()->route('instruktur.dashboard');
    } elseif ($user->hasRole('siswa')) {
        return redirect()->route('siswa.dashboard');
    } elseif ($user->hasRole('pic')) {
        return redirect()->route('pic.dashboard');
    }

    return abort(403, 'Role tidak dikenali.');
})->name('dashboard');

// ===================== AUTH =====================
require __DIR__ . '/auth.php';
