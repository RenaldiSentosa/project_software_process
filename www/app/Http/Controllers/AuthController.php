<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * 1. Tampilkan Halaman Login
     */
    public function showLogin()
    {
        // Pastikan file berada di resources/views/login.blade.php
        return view('login');
    }

    /**
     * 2. Proses Validasi & Autentikasi Login (Mendukung Email / NIM)
     */
    public function login(Request $request)
    {
        // Validasi input dari form login
        $request->validate([
            'login_input' => 'required|string',
            'password'    => 'required|string',
        ]);

        // Cek apakah yang diinput itu format email atau string NIM biasa
        $fieldType = filter_var($request->login_input, FILTER_VALIDATE_EMAIL) ? 'email' : 'nim';

        // Susun data kredensial untuk dicocokkan ke database
        $credentials = [
            $fieldType  => $request->login_input,
            'password'   => $request->password,
            'is_active'  => 1 // Akun wajib berstatus aktif (1)
        ];

        // Lakukan proses percobaan login
        if (Auth::attempt($credentials)) {
            // Jika sukses, amankan session user
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Redirect otomatis berdasarkan role user di database abang
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } else {
                return redirect()->intended('/peminjaman/baru');
            }
        }

        // Jika gagal (salah password/email/nim atau akun nonaktif), balikkan ke halaman login dengan error
        return redirect()->back()->withErrors([
            'login_error' => 'Email/NIM atau password salah, atau akun Anda dinonaktifkan.',
        ])->withInput($request->except('password'));
    }

    /**
     * 3. Tampilkan Halaman Register
     */
    public function showRegister()
    {
        // Pastikan file berada di resources/views/register.blade.php
        return view('register');
    }

    /**
     * 4. Proses Simpan Data Registrasi Mahasiswa Baru
     */
    public function register(Request $request)
    {
        // Validasi input form registrasi
        $request->validate([
            'nama_lengkap'  => 'required|string|max:100',
            'nim'           => 'required|string|max:20|unique:users,nim',
            'email'         => 'required|string|email|max:100|unique:users,email',
            'password'      => 'required|string|min:6|confirmed', // Wajib klop dengan password_confirmation
            'program_studi' => 'required|string|max:100',
        ], [
            // Kustomisasi pesan error bahasa Indonesia biar user paham
            'nim.unique' => 'NIM ini sudah terdaftar di sistem.',
            'email.unique' => 'Email ini sudah terdaftar di sistem.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal harus 6 karakter.',
        ]);

        // Simpan data mahasiswa baru menggunakan Model User bawaan Laravel
        User::create([
            'nama_lengkap'  => $request->nama_lengkap,
            'nim'           => $request->nim,
            'email'         => $request->email,
            'password'      => bcrypt($request->password), // Enkripsi password sebelum masuk DB
            'role'          => 'mahasiswa', // Otomatis mendaftar sebagai role mahasiswa
            'program_studi' => $request->program_studi,
            'is_active'     => 1, // Langsung kita set aktif biar bisa langsung login
        ]);

        // Setelah sukses, lempar ke halaman login disertai alert sukses hijau
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login menggunakan NIM atau Email Anda.');
    }

    /**
     * 5. Proses Logout Sesi Pengguna
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        // Bersihkan dan hancurkan session lama biar aman dari pembajakan session
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login')->with('success', 'Berhasil logout!');
    }
}