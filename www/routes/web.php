<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

// =========================================================================
// 1. HALAMAN UTAMA
// =========================================================================
Route::redirect('/', '/login');

// =========================================================================
// 2. MODUL AUTENTIKASI (GUEST)
// =========================================================================
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.proses');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// =========================================================================
// 3. MODUL PROSES & TRANSAKSI (PROTECTED)
// =========================================================================
Route::middleware(['auth'])->group(function () {

    // Profil Update & Upload Foto
    Route::put('/profil/update', [UserController::class, 'updatePassword'])->name('profil.update'); // ← pakai controller
    Route::put('/profil/foto', [UserController::class, 'updateFoto'])->name('profil.foto');         // ← tambahan baru

    // Transaksi Peminjaman
    Route::get('/peminjaman/baru', [BorrowingController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman/simpan', [BorrowingController::class, 'store'])->name('peminjaman.store');
    Route::delete('/keranjang/hapus/{id}', [CartController::class, 'destroy'])->name('keranjang.hapus');

    // =====================================================================
    // 4. AREA MAHASISWA
    // =====================================================================
    Route::view('/dashboard', 'mahasiswa.dashboard')->name('dashboard');
    Route::view('/katalog', 'mahasiswa.katalog')->name('katalog');
    Route::get('/keranjang', [CartController::class, 'index'])->name('keranjang');
    Route::get('/peminjaman', [BorrowingController::class, 'index'])->name('peminjaman');
    Route::get('/peminjaman/detail/{id}', [BorrowingController::class, 'show'])->name('peminjaman.detail');

    Route::get('/profil', [UserController::class, 'index'])->name('profil');

    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::view('/dashboard', 'mahasiswa.dashboard')->name('dashboard');
        Route::view('/katalog', 'mahasiswa.katalog')->name('katalog');
        Route::get('/keranjang', [CartController::class, 'index'])->name('keranjang');
        Route::get('/peminjaman', [BorrowingController::class, 'index'])->name('peminjaman');
        Route::get('/profil', [UserController::class, 'index'])->name('profil');
    });

    // =====================================================================
    // 5. AREA ADMIN / DOSEN
    // =====================================================================
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/manajemen-alat', [AdminController::class, 'manajemenAlat'])->name('manajemen_alat');
        Route::get('/peminjaman', [AdminController::class, 'peminjaman'])->name('peminjaman');
        Route::get('/manajemen-barang', [AdminController::class, 'manajemenBarang'])->name('manajemen_barang');
        Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');
        Route::get('/audit-trail', [AdminController::class, 'auditTrail'])->name('audit_trail');
        Route::get('/manajemen-user', [AdminController::class, 'manajemenUser'])->name('manajemen_user');
    });
});