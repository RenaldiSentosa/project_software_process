<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tool;
use App\Models\Borrowing;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::id();
        
        $total_peminjaman = Borrowing::where('mahasiswa_id', $userId)->count();
        $total_menunggu = Borrowing::where('mahasiswa_id', $userId)->where('status', 'Menunggu')->count();
        $total_dipinjam = Borrowing::where('mahasiswa_id', $userId)->whereIn('status', ['Diproses', 'Dipinjam'])->count();
        $total_selesai = Borrowing::where('mahasiswa_id', $userId)->whereIn('status', ['Dikembalikan', 'Selesai'])->count();

        $peminjaman = Borrowing::with('items.tool')
            ->where('mahasiswa_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function($p) {
                return (object) [
                    'id' => str_pad($p->id, 4, '0', STR_PAD_LEFT),
                    'keperluan' => $p->kegiatan,
                    'items_count' => $p->items->count(),
                    'tanggal_pinjam' => \Carbon\Carbon::parse($p->tgl_rencana_pinjam)->format('Y-m-d'),
                    'tanggal_kembali' => \Carbon\Carbon::parse($p->tgl_rencana_kembali)->format('Y-m-d'),
                    'status' => $p->status
                ];
            });

        return view('mahasiswa.dashboard', compact('total_peminjaman', 'total_menunggu', 'total_dipinjam', 'total_selesai', 'peminjaman'));
    }

    public function katalog(Request $request)
    {
        $query = Tool::query();
        
        if ($request->has('q') && trim($request->q) != '') {
            $q = trim($request->q);
            $query->where(function($query) use ($q) {
                $query->where('nama_alat', 'like', '%' . $q . '%')
                      ->orWhere('kode_alat', 'like', '%' . $q . '%');
            });
        }
        
        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        $tools = $query->paginate(12)->withQueryString();
        
        $kategoriList = Tool::select('kategori')->distinct()->pluck('kategori')->filter();

        return view('mahasiswa.katalog', compact('tools', 'kategoriList'));
    }
}