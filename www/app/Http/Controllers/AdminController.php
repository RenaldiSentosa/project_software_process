<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tool;
use App\Models\Item;
use App\Models\Borrowing;
use App\Models\User;
use App\Models\Auditlog;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalAlat = Tool::count();
        $peminjamanAktif = Borrowing::whereIn('status', ['Menunggu', 'Disetujui'])->count();
        $rendahStok = Tool::where('stok_tersedia', '<', 5)->count();
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();
        
        $permintaanData = Borrowing::with('mahasiswa', 'borrowingItems.tool')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        $peminjamanList = $permintaanData->map(function($p) {
            $alat_nama = $p->borrowingItems->first()->tool->nama_alat ?? 'Multiple/Tidak Diketahui';
            return [
                'uid' => 'PJM-' . str_pad($p->id, 4, '0', STR_PAD_LEFT),
                'mhs_nama' => $p->mahasiswa->nama_lengkap ?? $p->mahasiswa->name,
                'mhs_nim' => $p->mahasiswa->nim ?? '-',
                'jurusan' => $p->mahasiswa->program_studi ?? '-',
                'alat_nama' => $alat_nama,
                'tgl_mulai' => \Carbon\Carbon::parse($p->tgl_rencana_pinjam)->format('d M Y'),
                'tgl_selesai' => \Carbon\Carbon::parse($p->tgl_rencana_kembali)->format('d M Y'),
                'status' => $p->status
            ];
        });

        // Mock data for aktivitas terbaru and stok rendah until fully implemented
        $aktivitasTerbaru = [];
        $stokRendahList = [];

        return view('admin.dashboard', compact('totalAlat', 'peminjamanAktif', 'rendahStok', 'totalMahasiswa', 'aktivitasTerbaru', 'stokRendahList', 'peminjamanList'));
    }

    public function manajemenAlat()
    {
        $tools = Tool::all();
        
        $statusTersedia = Tool::where('status_alat', 'Tersedia')->count();
        $statusDipinjam = Tool::where('status_alat', 'Dipinjam')->count();
        $statusRusak = Tool::where('status_alat', 'Rusak')->count();
        $statusPerbaikan = Tool::where('status_alat', 'Dalam Perbaikan')->count();
        
        // Pass to the view, we can also alias $tools to $alatList for the view
        $alatList = $tools;

        return view('admin.manajemen-alat', compact('alatList', 'statusTersedia', 'statusDipinjam', 'statusRusak', 'statusPerbaikan'));
    }

    public function peminjaman()
    {
        $borrowings = Borrowing::with('mahasiswa', 'borrowingItems.tool')->orderBy('created_at', 'desc')->get();
        return view('admin.peminjaman', compact('borrowings'));
    }

    public function manajemenBarang()
    {
        $items = Item::all();
        return view('admin.manajemen-barang', compact('items'));
    }

    public function laporan()
    {
        return view('admin.laporan');
    }

    public function auditTrail()
    {
        $logs = Auditlog::orderBy('created_at', 'desc')->get();
        return view('admin.audit-trail', compact('logs'));
    }

    public function manajemenUser()
    {
        $users = User::all();
        return view('admin.manajemen-user', compact('users'));
    }
}
