<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('mahasiswa.profil', compact('user'));
    }

    // Ganti password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'nullable|min:8|confirmed',
        ]);

        // Kalau password tidak diisi, langsung balik
        if (!$request->filled('password')) {
            return back()->with('success', 'Tidak ada perubahan.');
        }

        /** @var User $user */
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password berhasil diperbarui.');
    }

    // Upload foto profil
    public function updateFoto(Request $request)
    {
        $request->validate([
            'foto_profil' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        /** @var User $user */
        $user = Auth::user();

        if ($user->foto_profil) {
            Storage::disk('public')->delete($user->foto_profil);
        }

        $path = $request->file('foto_profil')->store('foto_profil', 'public');

        $user->foto_profil = $path;
        $user->save();

        return back()->with('success', 'Foto profil berhasil diperbarui.');
    }
}