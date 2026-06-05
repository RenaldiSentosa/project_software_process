<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // <-- TAMBAHKAN BARIS INI BIAR GA ERROR

class CartController extends Controller
{
    // Menampilkan halaman keranjang dengan data dari session
    public function index()
    {
        // Mengambil data session bernama 'cart', jika kosong berikan array kosong
        $cart = session()->get('cart', []); 
        
        return view('mahasiswa.keranjang', compact('cart'));
    }

    // Menghapus item dari keranjang session
    public function destroy(string $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart); // Simpan kembali struktur data terbaru ke session
            return redirect()->back()->with('success', 'Alat berhasil dihapus dari keranjang!');
        }

        return redirect()->back()->with('error', 'Item tidak ditemukan atau gagal dihapus.');
    }
}