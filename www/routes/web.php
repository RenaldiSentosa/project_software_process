<?php

use Illuminate\Support\Facades\Route;

// ==========================================
// Halaman Utama / Landing Page
// ==========================================
Route::view('/', 'welcome');


// ==========================================
// MODUL AUTENTIKASI (LOGIN, REGISTER, LOGOUT)
// ==========================================

// 1. LOGIN
Route::view('/login', 'login')->name('login');
Route::post('/login', function () {
    // Dummy: Jika user klik login, langsung lempar ke dashboard mahasiswa (sesuai folder lo)
    return redirect()->route('dashboard_mahasiswa');
});

// 2. REGISTER
Route::view('/register', 'register')->name('register');
Route::post('/register', function () {
    return redirect()->route('login')->with('success', 'Registrasi berhasil (Dummy)!');
});

// 3. LOGOUT
Route::post('/logout', function () {
    return redirect()->route('login');
})->name('logout');


// ==========================================
// MODUL FITUR UTAMA UMUM / POLOSAN
// (Sudah diarahkan ke folder mahasiswa agar tidak eror View Not Found)
// ==========================================
Route::view('/dashboard', 'mahasiswa.dashboard')->name('dashboard');
Route::view('/katalog', 'mahasiswa.katalog')->name('katalog');
Route::view('/keranjang', 'mahasiswa.keranjang')->name('keranjang');
Route::view('/peminjaman', 'mahasiswa.peminjaman')->name('peminjaman'); 
Route::view('/profil', 'mahasiswa.profil')->name('profil'); 


// ==========================================
// MODUL TRANSAKSI UMUM
// ==========================================
Route::put('/profil/update', function () {
    return redirect()->route('profil')->with('success', 'Profil berhasil diperbarui (Dummy)!');
})->name('profil.update');

Route::post('/peminjaman/store', function () {
    return redirect()->route('peminjaman');
})->name('peminjaman.store');


// ==========================================
// MODUL KHUSUS MAHASISWA (URl dengan prefix /mahasiswa/...)
// ==========================================
Route::prefix('mahasiswa')->group(function () {
    Route::view('/dashboard', 'mahasiswa.dashboard')->name('dashboard_mahasiswa');
    Route::view('/katalog', 'mahasiswa.katalog')->name('katalog_mahasiswa');
    Route::view('/keranjang', 'mahasiswa.keranjang')->name('keranjang_mahasiswa');
    Route::view('/peminjaman', 'mahasiswa.peminjaman')->name('peminjaman_mahasiswa'); 
    Route::view('/profil', 'mahasiswa.profil')->name('profil_mahasiswa'); 
});


// ==========================================
// MODUL KHUSUS ADMIN / DOSEN (URL dengan prefix /admin/...)
// ==========================================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
    Route::view('/manajemen-alat', 'admin.manajemen-alat')->name('manajemen_alat');
    Route::view('/peminjaman', 'admin.peminjaman')->name('peminjaman');
    Route::view('/manajemen-barang', 'admin.manajemen-barang')->name('manajemen_barang');
    Route::view('/laporan', 'admin.laporan')->name('laporan');
    Route::view('/audit-trail', 'admin.audit-trail')->name('audit_trail');
    Route::view('/manajemen-user', 'admin.manajemen-user')->name('manajemen_user');
});

use App\Http\Controllers\BorrowingController;

// Route untuk menampilkan Form Peminjaman Alat
Route::get('/peminjaman/baru', [BorrowingController::class, 'create'])->name('peminjaman.create');

// Route untuk memproses Submit data Form Peminjaman
Route::post('/peminjaman/simpan', [BorrowingController::class, 'store'])->name('peminjaman.store');

use App\Http\Controllers\AuthController;

// Route untuk Halaman Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.proses');

// Route untuk Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route untuk Halaman Register
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.proses');