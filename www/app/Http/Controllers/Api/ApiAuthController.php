<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use App\Models\User;

class ApiAuthController extends Controller
{
    /**
     * 1. API Login
     * Endpoint: POST /api/v1/auth/login
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
            'is_active' => 1
        ];

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email/NIM atau password salah, atau akun belum aktif.'
            ], 401);
        }

        $user = User::where($fieldType, $request->login_input)->firstOrFail();
        
        // Hapus token lama agar satu device saja (opsional, tergantung kebijakan, kita buat multiple token allowed)
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil',
            'data' => [
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer'
            ]
        ]);
    }

    /**
     * 2. API Register
     * Endpoint: POST /api/v1/auth/register
     */
    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap'  => 'required|string|max:100',
            'nim'           => 'required|string|max:20|unique:users,nim',
            'email'         => 'required|string|email|max:100|unique:users,email',
            'password'      => 'required|string|min:6|confirmed',
            'program_studi' => 'required|string|max:100',
        ]);

        // Tidak ada validasi domain email lagi

        $user = User::create([
            'nama_lengkap'  => $request->nama_lengkap,
            'nim'           => $request->nim,
            'email'         => $request->email,
            'password'      => bcrypt($request->password),
            'role'          => 'mahasiswa',
            'program_studi' => $request->program_studi,
            'is_active'     => 0,
        ]);

        try {
            Http::post(env('N8N_WEBHOOK_URL', 'http://n8n:5678/webhook/registrasi'), [
                'nama_lengkap'  => $user->nama_lengkap,
                'nim'           => $user->nim,
                'email'         => $user->email,
                'program_studi' => $user->program_studi,
                'status'        => 'pendaftaran_baru'
            ]);
        } catch (\Exception $e) {
            // Abaikan jika N8N tidak merespons
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Registrasi berhasil. Menunggu aktivasi.'
        ], 201);
    }

    /**
     * 3. API Logout
     * Endpoint: POST /api/v1/auth/logout
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logout berhasil, token telah dihapus.'
        ]);
    }

    /**
     * 4. API Get User Profile
     * Endpoint: GET /api/v1/auth/me
     */
    public function me(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'data' => $request->user()
        ]);
    }
}
