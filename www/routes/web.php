<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MahasiswaController;

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

    // Profil
    Route::get('/profil', [UserController::class, 'index'])->name('profil');
    Route::put('/profil/update', [UserController::class, 'updatePassword'])->name('profil.update');
    Route::put('/profil/foto', [UserController::class, 'updateFoto'])->name('profil.foto');

    // Keranjang
    Route::get('/keranjang', [CartController::class, 'index'])->name('keranjang');
    Route::post('/keranjang/tambah', [CartController::class, 'store'])->name('keranjang.store');
    Route::put('/keranjang/update/{id}', [CartController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/hapus/{id}', [CartController::class, 'destroy'])->name('keranjang.hapus');

    // Peminjaman
    Route::get('/peminjaman', [BorrowingController::class, 'index'])->name('peminjaman');
    Route::get('/peminjaman/baru', [BorrowingController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman/simpan', [BorrowingController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman/detail/{id}', [BorrowingController::class, 'show'])->name('peminjaman.detail');

    // =====================================================================
    // 4. AREA MAHASISWA & DOSEN
    // =====================================================================
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect('/admin/dashboard');
        }
        return redirect('/mahasiswa/dashboard');
    })->name('dashboard');
    Route::get('/katalog', function (\Illuminate\Http\Request $request) {
        return redirect('/mahasiswa/katalog' . ($request->getQueryString() ? '?' . $request->getQueryString() : ''));
    })->name('katalog');

    Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
        Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])->name('dashboard');
        Route::get('/katalog-alat', function (\Illuminate\Http\Request $request) {
            return redirect('/mahasiswa/katalog' . ($request->getQueryString() ? '?' . $request->getQueryString() : ''));
        });
        Route::get('/katalog', [MahasiswaController::class, 'katalog'])->name('katalog');
        Route::get('/keranjang', [CartController::class, 'index'])->name('keranjang');
        Route::get('/peminjaman', [BorrowingController::class, 'index'])->name('peminjaman');
        Route::get('/profil', [UserController::class, 'index'])->name('profil');
    });

    // =====================================================================
    // 5. AREA ADMIN / DOSEN
    // =====================================================================
    Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

        Route::get('/manajemen-alat', [AdminController::class, 'manajemenAlat'])->name('manajemen_alat');
        Route::post('/manajemen-alat', [AdminController::class, 'storeAlat'])->name('manajemen_alat.store');
        Route::put('/manajemen-alat/{id}', [AdminController::class, 'updateAlat'])->name('manajemen_alat.update');
        Route::delete('/manajemen-alat/{id}', [AdminController::class, 'destroyAlat'])->name('manajemen_alat.destroy');
        Route::patch('/manajemen-alat/{id}/nonaktifkan', [AdminController::class, 'nonaktifkanAlat'])->name('manajemen_alat.nonaktifkan');
        Route::patch('/manajemen-alat/{id}/aktifkan', [AdminController::class, 'aktifkanAlat'])->name('manajemen_alat.aktifkan');

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

        // ── Laporan ──────────────────────────────────────────────────────
        Route::get('/laporan', [AdminController::class, 'laporan'])->name('laporan');
        Route::get('/laporan/export', [AdminController::class, 'exportLaporan'])->name('laporan.export');
        // ─────────────────────────────────────────────────────────────────

        // ── Audit Trail ──────────────────────────────────────────────────
        Route::get('/audit-trail', [AdminController::class, 'auditTrail'])->name('audit_trail');
        Route::get('/audit-trail/export', [AdminController::class, 'exportAuditTrail'])->name('audit_trail.export');
        // ─────────────────────────────────────────────────────────────────

        Route::get('/manajemen-user', [AdminController::class, 'manajemenUser'])->name('manajemen_user');
        Route::post('/manajemen-user', [AdminController::class, 'storeUser'])->name('manajemen_user.store');
        Route::put('/manajemen-user/{id}', [AdminController::class, 'updateUser'])->name('manajemen_user.update');
        Route::patch('/manajemen-user/{id}/toggle-status', [AdminController::class, 'toggleStatusUser'])->name('manajemen_user.toggle_status');
    });
});