<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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
        $request->validate([
            'login_input' => 'required|string',
            'password'    => 'required|string',
        ]);

        $fieldType = filter_var($request->login_input, FILTER_VALIDATE_EMAIL) ? 'email' : 'nim';

        $credentials = [
            $fieldType  => $request->login_input,
            'password'  => $request->password,
            // FIX: tidak ada lagi proses aktivasi, tapi is_active tetap
            // dicek di sini sebagai jaga-jaga kalau ada akun lama yang
            // is_active-nya masih 0 dari sebelum perubahan ini.
            'is_active' => 1,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            \App\Models\Auditlog::create([
                'nama_pelaku'  => $user->nama_lengkap ?? $user->name ?? 'System',
                'role_pelaku'  => $user->role ?? '-',
                'modul'        => 'Login',
                'aksi'         => 'LOGIN',
                'id_record'    => $user->id,
                'ip_address'   => request()->ip(),
                'deskripsi'    => 'User berhasil login ke sistem',
            ]);

            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            } else {
                return redirect()->intended('/mahasiswa/dashboard');
            }
        }

        return redirect()->back()->withErrors([
            'login_error' => 'Email/NIM atau password salah.',
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
     * 4. Proses Simpan Data Registrasi (Mahasiswa / Dosen)
     *    FIX: akun langsung aktif (is_active = 1), tidak ada lagi proses
     *    aktivasi via email/n8n. Semua error dikembalikan sebagai JSON
     *    supaya bisa ditangkap SweetAlert di register.blade.php.
     */
    public function register(Request $request)
    {
        $role = $request->input('role', 'mahasiswa');

        // Aturan digit NIM/NUPTK beda tergantung role:
        // mahasiswa -> NIM harus 12 digit
        // dosen     -> NUPTK harus 9 digit
        $nimRule = $role === 'dosen' ? 'digits:16' : 'digits:12';

        $validator = Validator::make($request->all(), [
            'nama_lengkap'  => 'required|string|max:100',
            'nim'           => ['required', 'string', $nimRule, 'unique:users,nim'],
            'email'         => 'required|string|email|max:100|unique:users,email',
            'password'      => 'required|string|min:8|confirmed',
            'program_studi' => $role === 'dosen' ? 'nullable|string|max:100' : 'required|string|max:100',
        ], [
            'nim.required'        => $role === 'dosen' ? 'NUPTK wajib diisi.' : 'NIM wajib diisi.',
            'nim.digits'          => $role === 'dosen' ? 'NUPTK harus 16 digit angka.' : 'NIM harus 12 digit angka.',
            'nim.unique'          => $role === 'dosen' ? 'NUPTK ini sudah terdaftar di sistem.' : 'NIM ini sudah terdaftar di sistem.',
            'email.unique'        => 'Email ini sudah terdaftar di sistem.',
            'email.required'      => 'Email wajib diisi.',
            'email.email'         => 'Format email tidak valid.',
            'password.required'   => 'Password wajib diisi.',
            'password.min'        => 'Password minimal harus 8 karakter.',
            'password.confirmed'  => 'Konfirmasi password tidak cocok.',
            'program_studi.required' => 'Program studi wajib dipilih.',
            'nama_lengkap.required'  => 'Nama wajib diisi.',
        ]);

        // Aturan email khusus domain kampus, dicek manual supaya pesannya jelas
        $email = $request->email;
        if ($email && !str_ends_with($email, '@ipwija.ac.id')) {
            $validator->after(function ($v) {
                $v->errors()->add('email', 'Registrasi ditolak! Anda wajib menggunakan email resmi Universitas IPWIJA (@ipwija.ac.id).');
            });
        }

        if ($validator->fails()) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'message' => $validator->errors()->first(),
                    'errors'  => $validator->errors(),
                ], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Simpan data ke database — FIX: is_active langsung 1, akun aktif
        // begitu daftar, tidak ada proses aktivasi lagi.
        $user = User::create([
            'nama_lengkap'  => $request->nama_lengkap,
            'nim'           => $request->nim,
            'email'         => $email,
            'password'      => Hash::make($request->password),
            'role'          => $role === 'dosen' ? 'dosen' : 'mahasiswa',
            'program_studi' => $request->program_studi,
            'is_active'     => 1,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Registrasi berhasil! Silakan login dengan akun Anda.',
                'redirect' => route('login'),
            ]);
        }

        return redirect('/login')->with('success', 'Registrasi berhasil! Silakan login dengan akun Anda.');
    }

    /**
     * 5. Proses Logout Sesi Pengguna
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            \App\Models\Auditlog::create([
                'nama_pelaku'  => $user->nama_lengkap ?? $user->name ?? 'System',
                'role_pelaku'  => $user->role ?? '-',
                'modul'        => 'Login',
                'aksi'         => 'LOGOUT',
                'id_record'    => $user->id,
                'ip_address'   => request()->ip(),
                'deskripsi'    => 'User berhasil logout dari sistem',
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Berhasil logout!');
    }
}