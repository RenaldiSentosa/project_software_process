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
    // 4. AREA MAHASISWA & DOSEN
    // =====================================================================
    Route::get('/dashboard', [\App\Http\Controllers\MahasiswaController::class, 'dashboard'])->name('dashboard');
    Route::get('/katalog', [\App\Http\Controllers\MahasiswaController::class, 'katalog'])->name('katalog');
    Route::get('/keranjang', [CartController::class, 'index'])->name('keranjang');
    Route::get('/peminjaman', [BorrowingController::class, 'index'])->name('peminjaman');
    Route::get('/peminjaman/detail/{id}', [BorrowingController::class, 'show'])->name('peminjaman.detail');

    Route::get('/profil', [UserController::class, 'index'])->name('profil');
    Route::put('/profil/update', [UserController::class, 'updatePassword'])->name('profil.update');
    Route::put('/profil/foto', [UserController::class, 'updateFoto'])->name('profil.foto');

    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\MahasiswaController::class, 'dashboard'])->name('dashboard');
        Route::get('/katalog', [\App\Http\Controllers\MahasiswaController::class, 'katalog'])->name('katalog');
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
        Route::post('/manajemen-alat', [AdminController::class, 'storeAlat'])->name('manajemen_alat.store');
        Route::put('/manajemen-alat/{id}', [AdminController::class, 'updateAlat'])->name('manajemen_alat.update');
        Route::delete('/manajemen-alat/{id}', [AdminController::class, 'destroyAlat'])->name('manajemen_alat.destroy');

        Route::get('/peminjaman', [AdminController::class, 'peminjaman'])->name('peminjaman');
        Route::post('/peminjaman/{id}/approve', [AdminController::class, 'approvePeminjaman'])->name('peminjaman.approve');
        Route::post('/peminjaman/{id}/reject', [AdminController::class, 'rejectPeminjaman'])->name('peminjaman.reject');
        Route::post('/peminjaman/{id}/borrow', [AdminController::class, 'borrowPeminjaman'])->name('peminjaman.borrow');
        Route::post('/peminjaman/{id}/return', [AdminController::class, 'returnPeminjaman'])->name('peminjaman.return');

        Route::get('/manajemen-barang', [AdminController::class, 'manajemenBarang'])->name('manajemen_barang');
        Route::post('/manajemen-barang', [AdminController::class, 'storeBarang'])->name('manajemen_barang.store');
        Route::put('/manajemen-barang/{id}', [AdminController::class, 'updateBarang'])->name('manajemen_barang.update');
        Route::delete('/manajemen-barang/{id}', [AdminController::class, 'destroyBarang'])->name('manajemen_barang.destroy');
        Route::post('/manajemen-barang/{id}/mutasi', [AdminController::class, 'mutasiStok'])->name('manajemen_barang.mutasi');
        Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');
        Route::get('/audit-trail', [AdminController::class, 'auditTrail'])->name('audit_trail');
        Route::get('/manajemen-user', [AdminController::class, 'manajemenUser'])->name('manajemen_user');
        Route::post('/manajemen-user', [AdminController::class, 'storeUser'])->name('manajemen_user.store');
        Route::put('/manajemen-user/{id}', [AdminController::class, 'updateUser'])->name('manajemen_user.update');
    });
});