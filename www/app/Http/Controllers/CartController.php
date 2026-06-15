<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tool;

class CartController extends Controller
{
    // Menampilkan halaman keranjang dengan data dari session
    public function index()
    {
        $cart = session()->get('cart', []);

        return view('mahasiswa.keranjang', compact('cart'));
    }

    // Menambahkan item ke keranjang session
    public function store(Request $request)
    {
        $request->validate([
            'alat_id' => 'required|exists:tools,id',
        ]);

        $alat = Tool::findOrFail($request->alat_id);

        // Cek stok sebelum ditambah
        if ($alat->stok_tersedia <= 0) {
            return redirect()->back()->with('error', 'Stok alat tidak tersedia!');
        }

        $cart = session()->get('cart', []);

        // Kalau sudah ada di keranjang, skip (tidak double)
        if (isset($cart[$alat->id])) {
            return redirect()->back()->with('error', 'Alat sudah ada di keranjang!');
        }

        $cart[$alat->id] = [
            'nama_alat'     => $alat->nama_alat,
            'kategori'      => $alat->kategori,
            'foto_alat'     => $alat->foto_alat,
            'stok_tersedia' => $alat->stok_tersedia,
            'jumlah_unit'   => 1,
        ];

        session()->put('cart', $cart);

        return redirect()->back()->with('success', "{$alat->nama_alat} berhasil ditambahkan ke keranjang!");
    }

    // Menghapus item dari keranjang session
    public function destroy(string $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Alat berhasil dihapus dari keranjang!');
        }

        return redirect()->back()->with('error', 'Item tidak ditemukan atau gagal dihapus.');
    }
}