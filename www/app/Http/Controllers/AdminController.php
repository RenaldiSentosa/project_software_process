<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tool;
use App\Models\Item;
use App\Models\Borrowing;
use App\Models\User;
use App\Models\Auditlog;
use App\Services\N8NWebhookService;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalAlat = Tool::count();
        $peminjamanAktif = Borrowing::whereIn('status', ['Menunggu', 'Disetujui'])->count();
        $rendahStok = Tool::where('stok_tersedia', '<', 5)->count();
        $rendahStokBulanIni = Tool::where('stok_tersedia', '<', 5)->whereMonth('updated_at', now()->month)->count();
        
        $totalMahasiswa = User::where('role', 'mahasiswa')->count();
        $alatBaruBulanIni = Tool::whereMonth('created_at', now()->month)->count();
        $peminjamanBulanIni = Borrowing::whereMonth('created_at', now()->month)->count();
        $mahasiswaBaruBulanIni = User::where('role', 'mahasiswa')->whereMonth('created_at', now()->month)->count();

        $statusFilter = request('status', 'Semua');
        $query = Borrowing::with('mahasiswa', 'items.tool')->orderBy('created_at', 'desc');
        
        if ($statusFilter == 'Menunggu') {
            $query->where('status', 'Menunggu');
        } elseif ($statusFilter == 'Aktif') {
            $query->whereIn('status', ['Diproses', 'Disetujui', 'Dipinjam']);
        } elseif ($statusFilter == 'Selesai') {
            $query->whereIn('status', ['Selesai', 'Dikembalikan', 'Ditolak']);
        }

        $permintaanData = $query->take(5)->get();
        
        $peminjamanList = $permintaanData->map(function($p) {
            $alat_nama = $p->items->first()->tool->nama_alat ?? 'Multiple/Tidak Diketahui';
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

        $aktivitasTerbaru = Auditlog::orderBy('created_at', 'desc')->take(5)->get()->map(function($log) {
            $pesan = $log->aksi . ' ' . $log->modul;
            
            if ($log->modul == 'Manajemen Alat') {
                $alat = \App\Models\Tool::find($log->id_record);
                $nama_alat = $alat ? $alat->nama_alat : 'Alat tidak diketahui';
                if ($log->aksi == 'CREATE') {
                    $pesan = "menambah alat '$nama_alat'";
                } elseif ($log->aksi == 'UPDATE') {
                    $pesan = "memperbarui alat '$nama_alat'";
                } elseif ($log->aksi == 'DELETE') {
                    $pesan = "menghapus alat";
                }
            } elseif ($log->modul == 'Manajemen Barang') {
                $barang = \App\Models\Item::find($log->id_record);
                $nama_barang = $barang ? $barang->nama_barang : 'Barang tidak diketahui';
                if ($log->aksi == 'CREATE') {
                    $pesan = "menambah barang '$nama_barang'";
                } elseif ($log->aksi == 'UPDATE') {
                    $pesan = "memperbarui barang '$nama_barang'";
                } elseif ($log->aksi == 'DELETE') {
                    $pesan = "menghapus barang";
                }
            }

            return [
                'nama' => $log->nama_pelaku ?? 'System',
                'pesan' => $pesan,
                'waktu' => $log->created_at ? $log->created_at->diffForHumans() : 'Baru saja'
            ];
        });

        $stokRendahList = Tool::where('stok_tersedia', '<', 5)->take(4)->get()->map(function($tool) {
            $persentase = $tool->stok_total > 0 ? round(($tool->stok_tersedia / $tool->stok_total) * 100) : 0;
            return [
                'nama' => $tool->nama_alat,
                'kategori' => $tool->kategori ?? 'Umum',
                'lokasi' => $tool->lokasi ?? 'Lab',
                'stok' => $tool->stok_tersedia,
                'max_stok' => $tool->stok_total,
                'satuan' => 'Unit',
                'persentase' => $persentase
            ];
        });

        return view('admin.dashboard', compact(
            'totalAlat', 'peminjamanAktif', 'rendahStok', 'totalMahasiswa',
            'alatBaruBulanIni', 'peminjamanBulanIni', 'mahasiswaBaruBulanIni', 'rendahStokBulanIni',
            'aktivitasTerbaru', 'stokRendahList', 'peminjamanList', 'statusFilter'
        ));
    }

    public function manajemenAlat()
    {
        $statusTersedia = Tool::where('status_alat', 'Tersedia')->count();
        $statusDipinjam = Tool::where('status_alat', 'Dipinjam')->count();
        $statusRusak = Tool::where('status_alat', 'Rusak')->count();
        $statusPerbaikan = Tool::where('status_alat', 'Dalam Perbaikan')->count();
        
        $alatList = Tool::paginate(10);

        return view('admin.manajemen-alat', compact('alatList', 'statusTersedia', 'statusDipinjam', 'statusRusak', 'statusPerbaikan'));
    }

    public function peminjaman()
    {
        $borrowings = Borrowing::with('mahasiswa', 'items.tool')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.peminjaman', compact('borrowings'));
    }

    public function manajemenBarang()
    {
        $items = Item::paginate(10);
        return view('admin.manajemen-barang', compact('items'));
    }

    public function laporan(Request $request)
    {
        $totalPeminjaman = \App\Models\Borrowing::count();
        $peminjamanBulanIni = \App\Models\Borrowing::whereMonth('created_at', now()->month)->count();
        
        $peminjamanAktif = \App\Models\Borrowing::whereIn('status', ['Dipinjam', 'Menunggu'])->count();
        $peminjamanMenungguBulanIni = \App\Models\Borrowing::whereIn('status', ['Dipinjam', 'Menunggu'])->whereMonth('created_at', now()->month)->count();
        
        $alatRusak = \App\Models\Item::where('kondisi', '!=', 'Baik')->count();
        $alatRusakBulanIni = \App\Models\Item::where('kondisi', '!=', 'Baik')->whereMonth('updated_at', now()->month)->count();
        
        $totalMahasiswa = \App\Models\User::where('role', 'mahasiswa')->count();
        $mahasiswaBaruBulanIni = \App\Models\User::where('role', 'mahasiswa')->whereMonth('created_at', now()->month)->count();

        $alatSeringDipinjam = \Illuminate\Support\Facades\DB::table('borrowing_items')
            ->join('tools', 'borrowing_items.tool_id', '=', 'tools.id')
            ->select('tools.nama_alat', \Illuminate\Support\Facades\DB::raw('SUM(borrowing_items.jumlah_unit) as total'))
            ->groupBy('tools.id', 'tools.nama_alat')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        $queryPeminjaman = \App\Models\Borrowing::with('mahasiswa', 'items.tool')->orderBy('created_at', 'desc');
        
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $queryPeminjaman->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }
        $rekapPeminjaman = $queryPeminjaman->get();

        $inventarisList = \App\Models\Item::all();
        $mutasiList = \App\Models\ItemMutation::with('item')->orderBy('created_at', 'desc')->get();
        $rekapMahasiswa = \App\Models\User::where('role', 'Mahasiswa')->withCount([
            'borrowings as total_pengajuan',
            'borrowings as menunggu' => function($query) { $query->where('status', 'Menunggu'); },
            'borrowings as disetujui' => function($query) { $query->where('status', 'Disetujui'); },
            'borrowings as dipinjam' => function($query) { $query->whereIn('status', ['Diproses', 'Dipinjam']); },
            'borrowings as ditolak' => function($query) { $query->where('status', 'Ditolak'); },
        ])->get();

        return view('admin.laporan', compact(
            'totalPeminjaman', 'peminjamanBulanIni', 'peminjamanAktif', 'peminjamanMenungguBulanIni',
            'alatRusak', 'alatRusakBulanIni', 'totalMahasiswa', 'mahasiswaBaruBulanIni', 'alatSeringDipinjam',
            'rekapPeminjaman', 'inventarisList', 'mutasiList', 'rekapMahasiswa'
        ));
    }

    public function auditTrail()
    {
        $logs = Auditlog::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.audit-trail', compact('logs'));
    }

    public function manajemenUser()
    {
        $users = User::paginate(10);
        return view('admin.manajemen-user', compact('users'));
    }

    public function approvePeminjaman($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->status = 'Disetujui';
        $borrowing->diproses_oleh = auth()->id();
        $borrowing->tgl_diproses = now();
        $borrowing->save();
        
        Auditlog::create([
            'nama_pelaku' => auth()->user()->nama_lengkap ?? auth()->user()->name ?? 'Admin',
            'role_pelaku' => auth()->user()->role ?? 'Admin',
            'modul' => 'Peminjaman',
            'aksi' => 'APPROVE',
            'id_record' => $id
        ]);
        
        N8NWebhookService::sendBorrowingEvent('borrowing.approved', $borrowing);
        
        return redirect()->back()->with('success', 'Peminjaman berhasil disetujui.');
    }

    public function rejectPeminjaman(Request $request, $id)
    {
        $request->validate([
            'catatan_admin' => 'required|string|max:1000'
        ], [
            'catatan_admin.required' => 'Catatan penolakan wajib diisi.'
        ]);

        $borrowing = Borrowing::findOrFail($id);
        $borrowing->status = 'Ditolak';
        $borrowing->diproses_oleh = auth()->id();
        $borrowing->tgl_diproses = now();
        $borrowing->catatan_admin = $request->catatan_admin;
        $borrowing->save();
        
        foreach($borrowing->items as $item) {
            $tool = $item->tool;
            if($tool) {
                $tool->stok_tersedia += $item->jumlah_unit;
                $tool->save();
            }
        }
        
        Auditlog::create([
            'nama_pelaku' => auth()->user()->nama_lengkap ?? auth()->user()->name ?? 'Admin',
            'role_pelaku' => auth()->user()->role ?? 'Admin',
            'modul' => 'Peminjaman',
            'aksi' => 'REJECT',
            'id_record' => $id
        ]);
        
        N8NWebhookService::sendBorrowingEvent('borrowing.rejected', $borrowing);
        
        return redirect()->back()->with('success', 'Peminjaman telah ditolak.');
    }

    public function borrowPeminjaman($id)
    {
        $borrowing = Borrowing::findOrFail($id);
        $borrowing->status = 'Dipinjam';
        $borrowing->save();
        
        Auditlog::create([
            'nama_pelaku' => auth()->user()->nama_lengkap ?? auth()->user()->name ?? 'Admin',
            'role_pelaku' => auth()->user()->role ?? 'Admin',
            'modul' => 'Peminjaman',
            'aksi' => 'UPDATE',
            'id_record' => $id
        ]);
        
        return redirect()->back()->with('success', 'Status peminjaman diubah menjadi Dipinjam.');
    }

    public function returnPeminjaman(Request $request, $id)
    {
        $borrowing = Borrowing::with('items.tool')->findOrFail($id);
        $borrowing->status = 'Dikembalikan';
        $borrowing->tgl_pengembalian_aktual = now();
        $borrowing->save();
        
        $kondisiArray = $request->input('kondisi', []);

        foreach($borrowing->items as $item) {
            $tool = $item->tool;
            $kondisi = $kondisiArray[$item->id] ?? 'Baik';
            
            $item->kondisi_saat_kembali = $kondisi;
            $item->save();

            if($tool) {
                if ($kondisi === 'Baik') {
                    $tool->stok_tersedia += $item->jumlah_unit;
                } else if ($kondisi === 'Rusak Ringan' || $kondisi === 'Rusak Berat') {
                    $tool->stok_total -= $item->jumlah_unit;
                }
                $tool->save();
            }
        }
        
        Auditlog::create([
            'nama_pelaku' => auth()->user()->nama_lengkap ?? auth()->user()->name ?? 'Admin',
            'role_pelaku' => auth()->user()->role ?? 'Admin',
            'modul' => 'Peminjaman',
            'aksi' => 'UPDATE',
            'id_record' => $id
        ]);
        
        N8NWebhookService::sendBorrowingEvent('borrowing.returned', $borrowing);
        
        return redirect()->back()->with('success', 'Alat berhasil dikembalikan dan stok diperbarui.');
    }

    public function storeAlat(Request $request)
    {
        $data = $request->validate([
            'kode_alat' => 'required|string|max:50',
            'nama_alat' => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'stok_total' => 'required|integer|min:0',
            'status_alat' => 'required|string',
            'lokasi' => 'required|string|max:100',
        ]);
        
        $data['stok_tersedia'] = $data['stok_total'];

        $tool = Tool::create($data);

        Auditlog::create([
            'nama_pelaku' => auth()->user()->nama_lengkap ?? auth()->user()->name ?? 'Admin',
            'role_pelaku' => auth()->user()->role ?? 'Admin',
            'modul' => 'Manajemen Alat',
            'aksi' => 'CREATE',
            'id_record' => $tool->id
        ]);

        return redirect()->back()->with('success', 'Alat berhasil ditambahkan.');
    }

    public function updateAlat(Request $request, $id)
    {
        $tool = Tool::findOrFail($id);
        
        $data = $request->validate([
            'nama_alat' => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'stok_total' => 'required|integer|min:0',
            'status_alat' => 'required|string',
            'lokasi' => 'required|string|max:100',
        ]);

        $diffStok = $data['stok_total'] - $tool->stok_total;
        $data['stok_tersedia'] = $tool->stok_tersedia + $diffStok;

        $tool->update($data);

        Auditlog::create([
            'nama_pelaku' => auth()->user()->nama_lengkap ?? auth()->user()->name ?? 'Admin',
            'role_pelaku' => auth()->user()->role ?? 'Admin',
            'modul' => 'Manajemen Alat',
            'aksi' => 'UPDATE',
            'id_record' => $id
        ]);

        return redirect()->back()->with('success', 'Alat berhasil diperbarui.');
    }

    public function destroyAlat($id)
    {
        $tool = Tool::findOrFail($id);
        $tool->delete();

        Auditlog::create([
            'nama_pelaku' => auth()->user()->nama_lengkap ?? auth()->user()->name ?? 'Admin',
            'role_pelaku' => auth()->user()->role ?? 'Admin',
            'modul' => 'Manajemen Alat',
            'aksi' => 'DELETE',
            'id_record' => $id
        ]);

        return redirect()->back()->with('success', 'Alat berhasil dihapus.');
    }

    public function storeBarang(Request $request)
    {
        $data = $request->validate([
            'kode_barang' => 'required|string|max:50',
            'nama_barang' => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string|max:20',
            'kondisi' => 'required|string',
            'lokasi' => 'required|string|max:100',
        ]);

        $item = Item::create($data);

        Auditlog::create([
            'nama_pelaku' => auth()->user()->nama_lengkap ?? auth()->user()->name ?? 'Admin',
            'role_pelaku' => auth()->user()->role ?? 'Admin',
            'modul' => 'Manajemen Barang',
            'aksi' => 'CREATE',
            'id_record' => $item->id
        ]);

        return redirect()->back()->with('success', 'Barang berhasil ditambahkan.');
    }

    public function updateBarang(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        
        $data = $request->validate([
            'nama_barang' => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string|max:20',
            'kondisi' => 'required|string',
            'lokasi' => 'required|string|max:100',
        ]);

        $item->update($data);

        Auditlog::create([
            'nama_pelaku' => auth()->user()->nama_lengkap ?? auth()->user()->name ?? 'Admin',
            'role_pelaku' => auth()->user()->role ?? 'Admin',
            'modul' => 'Manajemen Barang',
            'aksi' => 'UPDATE',
            'id_record' => $id
        ]);

        return redirect()->back()->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroyBarang($id)
    {
        $item = Item::findOrFail($id);
        $item->delete();

        Auditlog::create([
            'nama_pelaku' => auth()->user()->nama_lengkap ?? auth()->user()->name ?? 'Admin',
            'role_pelaku' => auth()->user()->role ?? 'Admin',
            'modul' => 'Manajemen Barang',
            'aksi' => 'DELETE',
            'id_record' => $id
        ]);

        return redirect()->back()->with('success', 'Barang berhasil dihapus.');
    }

    public function mutasiStok(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        
        $request->validate([
            'tipe_mutasi' => 'required|in:masuk,keluar',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string'
        ]);

        if ($request->tipe_mutasi == 'keluar' && $item->stok < $request->jumlah) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi untuk dikeluarkan.');
        }

        $stok_sebelum = $item->stok;

        if ($request->tipe_mutasi == 'masuk') {
            $item->stok += $request->jumlah;
        } else {
            $item->stok -= $request->jumlah;
        }
        
        $item->save();

        \App\Models\ItemMutation::create([
            'item_id' => $item->id,
            'tipe_mutasi' => ucfirst($request->tipe_mutasi),
            'jumlah' => $request->jumlah,
            'stok_sebelum' => $stok_sebelum,
            'stok_sesudah' => $item->stok,
            'keterangan' => $request->keterangan,
            'dilakukan_oleh' => auth()->id()
        ]);

        Auditlog::create([
            'nama_pelaku' => auth()->user()->nama_lengkap ?? auth()->user()->name ?? 'Admin',
            'role_pelaku' => auth()->user()->role ?? 'Admin',
            'modul' => 'Manajemen Barang',
            'aksi' => 'Mutasi Stok ' . ucfirst($request->tipe_mutasi),
            'id_record' => $id
        ]);

        return redirect()->back()->with('success', 'Mutasi stok berhasil.');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:Admin,Mahasiswa',
            'nim' => 'nullable|string',
            'ProgramStudi' => 'nullable|string'
        ]);

        $user = User::create([
            'name' => $request->name,
            'nama_lengkap' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => strtolower($request->role),
            'nim' => $request->nim,
            'program_studi' => $request->ProgramStudi,
            'is_active' => $request->has('is_active') ? 1 : 0
        ]);

        Auditlog::create([
            'nama_pelaku' => auth()->user()->nama_lengkap ?? auth()->user()->name ?? 'Admin',
            'role_pelaku' => auth()->user()->role ?? 'Admin',
            'modul' => 'Manajemen User',
            'aksi' => 'CREATE',
            'id_record' => $user->id
        ]);

        return redirect()->back()->with('success', 'User berhasil ditambahkan.');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'role' => 'required|in:Admin,Mahasiswa',
            'nim' => 'nullable|string',
            'ProgramStudi' => 'nullable|string'
        ]);

        $user->update([
            'name' => $request->name,
            'nama_lengkap' => $request->name,
            'email' => $request->email,
            'role' => strtolower($request->role),
            'nim' => $request->nim,
            'program_studi' => $request->ProgramStudi,
            'is_active' => $request->has('is_active') ? 1 : 0
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => \Illuminate\Support\Facades\Hash::make($request->password)]);
        }

        Auditlog::create([
            'nama_pelaku' => auth()->user()->nama_lengkap ?? auth()->user()->name ?? 'Admin',
            'role_pelaku' => auth()->user()->role ?? 'Admin',
            'modul' => 'Manajemen User',
            'aksi' => 'UPDATE',
            'id_record' => $id
        ]);

        return redirect()->back()->with('success', 'Data user berhasil diperbarui.');
    }
}