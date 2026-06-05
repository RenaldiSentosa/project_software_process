<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // Mengambil data user yang sedang login
        $user = Auth::user();

        // Mengirim data ke view mahasiswa.profil
        return view('mahasiswa.profil', compact('user'));
    }
}