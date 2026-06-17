<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tool;
use App\Models\Borrowing;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Menampilkan halaman keranjang dengan data dari session
    public function index()
    {
        $cart = session()->get('cart', []);

        $userId = Auth::id() ?? 2;

        // Cek apakah mahasiswa masih memiliki peminjaman aktif/menunggu
        $activeBorrowing = Borrowing::where('mahasiswa_id', $userId)
            ->whereIn('status', ['Menunggu', 'Disetujui', 'Dipinjam'])
            ->exists();

        return view('mahasiswa.keranjang', compact('cart', 'activeBorrowing'));
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
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Stok alat tidak tersedia!'], 422);
            }
            return redirect()->back()->with('error', 'Stok alat tidak tersedia!');
        }

        $cart = session()->get('cart', []);

        // Kalau sudah ada di keranjang, skip (tidak double)
        if (isset($cart[$alat->id])) {
            if ($request->wantsJson()) {
                return response()->json(['message' => 'Alat sudah ada di keranjang!'], 422);
            }
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

        if ($request->wantsJson()) {
            return response()->json([
                'message' => "{$alat->nama_alat} berhasil ditambahkan ke keranjang!",
                'alat_id' => $alat->id,
            ]);
        }

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