<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http; // <--- WAJIB ADA: Untuk menembak Webhook ke n8n
use App\Models\User;

class AuthController extends Controller
{
    /**
     * 1. Tampilkan Halaman Login
     */
    public function showLogin()
    {
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
            'is_active'  => 1 // Akun wajib berstatus aktif (1) setelah divalidasi n8n
        ];

        // Lakukan proses percobaan login
        if (Auth::attempt($credentials)) {
            // Jika sukses, amankan session user
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Redirect otomatis berdasarkan role user di database
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } else {
                return redirect()->intended('/mahasiswa/dashboard');
            }
        }

        // Jika gagal (salah password/email/nim atau akun nonaktif belum divalidasi n8n), balikkan ke halaman login
        return redirect()->back()->withErrors([
            'login_error' => 'Email/NIM atau password salah, atau akun Anda belum diaktifkan oleh sistem kampus.',
        ])->withInput($request->except('password'));
    }

    /**
     * 3. Tampilkan Halaman Register
     */
    public function showRegister()
    {
        return view('register');
    }

    /**
     * 4. Proses Simpan Data Registrasi Mahasiswa Baru (Eksklusif @ipwija.ac.id & Terhubung n8n)
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
            // Kustomisasi pesan error bahasa Indonesia
            'nim.unique' => 'NIM ini sudah terdaftar di sistem.',
            'email.unique' => 'Email ini sudah terdaftar di sistem.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal harus 6 karakter.',
        ]);

        $email = $request->email;

        // 🔥 SATPAM DOMAIN: Hanya menerima email berakhiran @ipwija.ac.id
        if (!str_ends_with($email, '@ipwija.ac.id')) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['email' => 'Registrasi ditolak! Anda wajib menggunakan email resmi Universitas IPWIJA (@ipwija.ac.id).']);
        }

        // Simpan data ke database dengan status PENDING (is_active = 0)
        $user = User::create([
            'nama_lengkap'  => $request->nama_lengkap,
            'nim'           => $request->nim,
            'email'         => $email,
            'password'      => Hash::make($request->password), // Enkripsi password standar Laravel
            'role'          => 'mahasiswa', // Otomatis mendaftar sebagai mahasiswa
            'program_studi' => $request->program_studi,
            'is_active'     => 0, // Set 0: Menunggu n8n memproses aktivasi via email
        ]);

        // 🚀 SEBAR DATA KE WEBHOOK n8n
        try {
            Http::post('URL_WEBHOOK_N8N_ABANG_DISINI', [
                'nama_lengkap'  => $user->nama_lengkap,
                'nim'           => $user->nim,
                'email'         => $user->email,
                'program_studi' => $user->program_studi,
                'status'        => 'pendaftaran_baru'
            ]);
        } catch (\Exception $e) {
            // Logger opsional: mencegah aplikasi crash jika server n8n belum dinyalakan/down saat testing
        }

        // Setelah sukses, arahkan kembali ke halaman login
        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan cek inbox email @ipwija.ac.id Anda untuk instruksi aktivasi akun.');
    }

    /**
     * 5. Proses Logout Sesi Pengguna
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        // Bersihkan dan hancurkan session lama biar aman
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login')->with('success', 'Berhasil logout!');
    }
}