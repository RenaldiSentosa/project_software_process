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
    // =========================================================================
    // HELPER PRIVAT — buat Auditlog::create lebih ringkas & konsisten
    // =========================================================================

    /**
     * Simpan satu entri audit log.
     *
     * @param string      $aksi        Aksi (CREATE, UPDATE, DELETE, APPROVE, REJECT, LOGIN, LOGOUT, EXPORT)
     * @param string      $modul       Nama modul
     * @param int|string|null $idRecord ID record yang terpengaruh
     * @param string|null $deskripsi   Kalimat narasi aktivitas (tampil di modal detail)
     * @param array|null  $before      Data sebelum perubahan   (key-value)
     * @param array|null  $after       Data sesudah perubahan   (key-value)
     */
    private function log(
        string $aksi,
        string $modul,
        $idRecord    = null,
        ?string $deskripsi = null,
        ?array $before = null,
        ?array $after  = null
    ): void {
        Auditlog::create([
            'nama_pelaku'  => auth()->user()->nama_lengkap ?? auth()->user()->name ?? 'System',
            'role_pelaku'  => auth()->user()->role ?? '-',
            'modul'        => $modul,
            'aksi'         => $aksi,
            'id_record'    => $idRecord,
            'ip_address'   => request()->ip(),
            'deskripsi'    => $deskripsi,
            'data_sebelum' => $before,
            'data_sesudah' => $after,
        ]);
    }

    // =========================================================================
    // DASHBOARD
    // =========================================================================

    public function dashboard()
    {
        $totalAlat = Tool::count();
        $peminjamanAktif = Borrowing::whereIn('status', ['Menunggu', 'Disetujui'])->count();
        $rendahStok = Item::whereColumn('stok', '<=', 'stok_minimum')->count();
        $rendahStokBulanIni = Item::whereColumn('stok', '<=', 'stok_minimum')->whereMonth('updated_at', now()->month)->count();

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

        $peminjamanList = $permintaanData->map(function ($p) {
            $alat_nama = $p->items->first()->tool->nama_alat ?? 'Multiple/Tidak Diketahui';
            return [
                'uid'        => 'PJM-' . str_pad($p->id, 4, '0', STR_PAD_LEFT),
                'mhs_nama'   => $p->mahasiswa->nama_lengkap ?? $p->mahasiswa->name,
                'mhs_nim'    => $p->mahasiswa->nim ?? '-',
                'jurusan'    => $p->mahasiswa->program_studi ?? '-',
                'alat_nama'  => $alat_nama,
                'tgl_mulai'  => \Carbon\Carbon::parse($p->tgl_rencana_pinjam)->format('d M Y'),
                'tgl_selesai'=> \Carbon\Carbon::parse($p->tgl_rencana_kembali)->format('d M Y'),
                'status'     => $p->status,
            ];
        });

        $aktivitasTerbaru = Auditlog::orderBy('created_at', 'desc')->take(5)->get()->map(function ($log) {
            $pesan = $log->deskripsi ?? ($log->aksi . ' ' . $log->modul);

            if (!$log->deskripsi) {
                if ($log->modul == 'Manajemen Alat') {
                    $alat = \App\Models\Tool::find($log->id_record);
                    $nama_alat = $alat ? $alat->nama_alat : 'Alat tidak diketahui';
                    if ($log->aksi == 'CREATE')      $pesan = "Menambah alat '{$nama_alat}'";
                    elseif ($log->aksi == 'UPDATE')  $pesan = "Memperbarui alat '{$nama_alat}'";
                    elseif ($log->aksi == 'DELETE')  $pesan = "Menghapus alat";
                } elseif ($log->modul == 'Manajemen Barang') {
                    $barang = \App\Models\Item::find($log->id_record);
                    $nama_barang = $barang ? $barang->nama_barang : 'Barang tidak diketahui';
                    if ($log->aksi == 'CREATE')      $pesan = "Menambah barang '{$nama_barang}'";
                    elseif ($log->aksi == 'UPDATE')  $pesan = "Memperbarui barang '{$nama_barang}'";
                    elseif ($log->aksi == 'DELETE')  $pesan = "Menghapus barang";
                }
            }

            return [
                'nama'  => $log->nama_pelaku ?? 'System',
                'pesan' => $pesan,
                'waktu' => $log->created_at ? $log->created_at->diffForHumans() : 'Baru saja',
            ];
        });

        $stokRendahList = Item::whereColumn('stok', '<=', 'stok_minimum')->take(4)->get()->map(function ($item) {
            $persentase = $item->stok_minimum > 0
                ? round(($item->stok / $item->stok_minimum) * 100)
                : 0;
            return [
                'nama'      => $item->nama_barang,
                'kategori'  => $item->kategori ?? 'Umum',
                'lokasi'    => $item->lokasi ?? 'Lab',
                'stok'      => $item->stok,
                'max_stok'  => $item->stok_minimum,
                'satuan'    => $item->satuan ?? 'pcs',
                'persentase'=> $persentase,
            ];
        });

        return view('admin.dashboard', compact(
            'totalAlat', 'peminjamanAktif', 'rendahStok', 'totalMahasiswa',
            'alatBaruBulanIni', 'peminjamanBulanIni', 'mahasiswaBaruBulanIni', 'rendahStokBulanIni',
            'aktivitasTerbaru', 'stokRendahList', 'peminjamanList', 'statusFilter'
        ));
    }

    // =========================================================================
    // MANAJEMEN ALAT
    // =========================================================================

    public function manajemenAlat(Request $request)
    {
        $statusTersedia  = Tool::where('status_alat', 'Tersedia')->count();
        $statusDipinjam  = Tool::where('status_alat', 'Dipinjam')->count();
        $statusRusak     = Tool::where('status_alat', 'Rusak')->count();
        $statusPerbaikan = Tool::where('status_alat', 'Dalam Perbaikan')->count();

        $query = Tool::query();

        if ($request->has('q') && $request->q != '') {
            $query->where('nama_alat', 'like', '%' . $request->q . '%')
                  ->orWhere('kode_alat', 'like', '%' . $request->q . '%');
        }

        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        if ($request->has('status') && $request->status != '') {
            $query->where('status_alat', $request->status);
        }

        $alatList = $query->paginate(10);

        return view('admin.manajemen-alat', compact(
            'alatList', 'statusTersedia', 'statusDipinjam', 'statusRusak', 'statusPerbaikan'
        ));
    }

    public function storeAlat(Request $request)
    {
        $data = $request->validate([
            'kode_alat'  => 'required|string|max:50',
            'nama_alat'  => 'required|string|max:100',
            'kategori'   => 'required|string|max:50',
            'deskripsi'  => 'nullable|string',
            'stok_total' => 'required|integer|min:0',
            'status_alat'=> 'required|string',
            'lokasi'     => 'required|string|max:100',
            'foto'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto_alat'] = $request->file('foto')->store('alat', 'public');
        }

        $data['stok_tersedia'] = $data['stok_total'];
        if (in_array($data['status_alat'], ['Rusak', 'Dalam Perbaikan'])) {
            $data['stok_tersedia'] = 0;
        }

        $tool = Tool::create($data);

        $this->log(
            'CREATE', 'Manajemen Alat', $tool->id,
            "Menambah alat baru '{$tool->nama_alat}'",
            null,
            ['nama_alat' => $tool->nama_alat, 'stok' => $tool->stok_total, 'status' => $tool->status_alat]
        );

        return redirect()->back()->with('success', 'Alat berhasil ditambahkan.');
    }

    public function updateAlat(Request $request, $id)
    {
        $tool = Tool::findOrFail($id);

        $data = $request->validate([
            'nama_alat'  => 'required|string|max:100',
            'kategori'   => 'required|string|max:50',
            'deskripsi'  => 'nullable|string',
            'stok_total' => 'required|integer|min:0',
            'status_alat'=> 'required|string',
            'lokasi'     => 'required|string|max:100',
            'foto'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $before = [
            'nama_alat'  => $tool->nama_alat,
            'stok_total' => $tool->stok_total,
            'status_alat'=> $tool->status_alat,
            'lokasi'     => $tool->lokasi,
        ];

        if ($request->hasFile('foto')) {
            if ($tool->foto_alat) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($tool->foto_alat);
            }
            $data['foto_alat'] = $request->file('foto')->store('alat', 'public');
        }

        $diffStok = $data['stok_total'] - $tool->stok_total;
        $data['stok_tersedia'] = max(0, $tool->stok_tersedia + $diffStok);

        if (in_array($data['status_alat'], ['Rusak', 'Dalam Perbaikan'])) {
            $data['stok_tersedia'] = 0;
        } elseif (in_array($tool->status_alat, ['Rusak', 'Dalam Perbaikan']) && $data['status_alat'] === 'Tersedia') {
            $data['stok_tersedia'] = $data['stok_total'];
        }

        $tool->update($data);

        $this->log(
            'UPDATE', 'Manajemen Alat', $id,
            "Memperbarui data alat '{$tool->nama_alat}'",
            $before,
            ['nama_alat' => $tool->nama_alat, 'stok_total' => $tool->stok_total, 'status_alat' => $tool->status_alat, 'lokasi' => $tool->lokasi]
        );

        return redirect()->back()->with('success', 'Alat berhasil diperbarui.');
    }

    public function destroyAlat($id)
    {
        $tool = Tool::findOrFail($id);
        $before = ['nama_alat' => $tool->nama_alat, 'stok_total' => $tool->stok_total];
        $tool->delete();

        $this->log(
            'DELETE', 'Manajemen Alat', $id,
            "Menghapus alat '{$before['nama_alat']}'",
            $before,
            null
        );

        return redirect()->back()->with('success', 'Alat berhasil dihapus.');
    }

    public function nonaktifkanAlat($id)
    {
        $tool = Tool::findOrFail($id);
        $before = ['Status Alat' => $tool->status_alat];
        $tool->status_alat = 'Nonaktif';
        $tool->save();

        $this->log(
            'UPDATE', 'Manajemen Alat', $id,
            "Menonaktifkan alat '{$tool->nama_alat}'",
            $before,
            ['Status Alat' => 'Nonaktif']
        );

        return redirect()->back()->with('success', 'Alat berhasil dinonaktifkan.');
    }

    public function aktifkanAlat($id)
    {
        $tool = Tool::findOrFail($id);
        $before = ['Status Alat' => $tool->status_alat];
        $tool->status_alat = 'Tersedia';
        $tool->save();

        $this->log(
            'UPDATE', 'Manajemen Alat', $id,
            "Mengaktifkan kembali alat '{$tool->nama_alat}'",
            $before,
            ['Status Alat' => 'Tersedia']
        );

        return redirect()->back()->with('success', 'Alat berhasil diaktifkan kembali.');
    }

    // =========================================================================
    // PEMINJAMAN
    // =========================================================================

    public function peminjaman()
    {
        $borrowings = Borrowing::with('mahasiswa', 'items.tool')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.peminjaman', compact('borrowings'));
    }

    public function approvePeminjaman($id)
    {
        $borrowing = Borrowing::with('mahasiswa')->findOrFail($id);
        $before = ['Status' => $borrowing->status];

        $borrowing->status        = 'Disetujui';
        $borrowing->diproses_oleh = auth()->id();
        $borrowing->tgl_diproses  = now();
        $borrowing->save();

        $namaMhs = $borrowing->mahasiswa->nama_lengkap ?? $borrowing->mahasiswa->name ?? '-';
        $this->log(
            'APPROVE', 'Peminjaman',
            'PIN-' . str_pad($id, 3, '0', STR_PAD_LEFT),
            "Menyetujui peminjaman oleh {$namaMhs}",
            $before,
            ['Status' => 'Disetujui']
        );

        N8NWebhookService::sendBorrowingEvent('borrowing.approved', $borrowing);

        return redirect()->back()->with('success', 'Peminjaman berhasil disetujui.');
    }

    public function rejectPeminjaman(Request $request, $id)
    {
        $request->validate([
            'catatan_admin' => 'required|string|max:1000',
        ], [
            'catatan_admin.required' => 'Catatan penolakan wajib diisi.',
        ]);

        $borrowing = Borrowing::with('mahasiswa')->findOrFail($id);
        $before = ['Status' => $borrowing->status];

        $borrowing->status        = 'Ditolak';
        $borrowing->diproses_oleh = auth()->id();
        $borrowing->tgl_diproses  = now();
        $borrowing->catatan_admin = $request->catatan_admin;
        $borrowing->save();

        foreach ($borrowing->items as $item) {
            $tool = $item->tool;
            if ($tool) {
                $tool->stok_tersedia += $item->jumlah_unit;
                $tool->save();
            }
        }

        $namaMhs = $borrowing->mahasiswa->nama_lengkap ?? $borrowing->mahasiswa->name ?? '-';
        $this->log(
            'REJECT', 'Peminjaman',
            'PIN-' . str_pad($id, 3, '0', STR_PAD_LEFT),
            "Menolak peminjaman oleh {$namaMhs} — {$request->catatan_admin}",
            $before,
            ['Status' => 'Ditolak']
        );

        N8NWebhookService::sendBorrowingEvent('borrowing.rejected', $borrowing);

        return redirect()->back()->with('success', 'Peminjaman telah ditolak.');
    }

    public function borrowPeminjaman($id)
    {
        $borrowing = Borrowing::with('mahasiswa')->findOrFail($id);
        $before = ['Status' => $borrowing->status];

        $borrowing->status = 'Dipinjam';
        $borrowing->save();

        $namaMhs = $borrowing->mahasiswa->nama_lengkap ?? $borrowing->mahasiswa->name ?? '-';
        $this->log(
            'UPDATE', 'Peminjaman',
            'PIN-' . str_pad($id, 3, '0', STR_PAD_LEFT),
            "Mengubah status peminjaman {$namaMhs} menjadi Dipinjam",
            $before,
            ['Status' => 'Dipinjam']
        );

        return redirect()->back()->with('success', 'Status peminjaman diubah menjadi Dipinjam.');
    }

    public function returnPeminjaman(Request $request, $id)
    {
        $borrowing = Borrowing::with(['mahasiswa', 'items.tool'])->findOrFail($id);
        $before = ['Status' => $borrowing->status];

        $borrowing->status                   = 'Dikembalikan';
        $borrowing->tgl_pengembalian_aktual  = now();
        $borrowing->save();

        $kondisiBaik        = $request->input('kondisi_baik', []);
        $kondisiRusakRingan = $request->input('kondisi_rusak_ringan', []);
        $kondisiRusakBerat  = $request->input('kondisi_rusak_berat', []);

        foreach ($borrowing->items as $item) {
            $tool   = $item->tool;
            $baik   = (int)($kondisiBaik[$item->id] ?? 0);
            $ringan = (int)($kondisiRusakRingan[$item->id] ?? 0);
            $berat  = (int)($kondisiRusakBerat[$item->id] ?? 0);

            $kondisi = 'Baik';
            if ($berat > 0) {
                $kondisi = 'Rusak Berat';
            } elseif ($ringan > 0) {
                $kondisi = 'Rusak Ringan';
            } elseif ($baik < $item->jumlah_unit && $baik > 0) {
                 $kondisi = 'Campuran';
            }

            $item->kondisi_saat_kembali = $kondisi;
            $item->save();

            if ($tool) {
                $tool->stok_tersedia += $baik;
                $tool->stok_total -= ($ringan + $berat);
                $tool->save();
            }
        }

        $namaMhs = $borrowing->mahasiswa->nama_lengkap ?? $borrowing->mahasiswa->name ?? '-';
        $this->log(
            'UPDATE', 'Peminjaman',
            'PIN-' . str_pad($id, 3, '0', STR_PAD_LEFT),
            "Pengembalian alat oleh {$namaMhs}",
            $before,
            ['Status' => 'Dikembalikan']
        );

        N8NWebhookService::sendBorrowingEvent('borrowing.returned', $borrowing);

        return redirect()->back()->with('success', 'Alat berhasil dikembalikan dan stok diperbarui.');
    }

    // =========================================================================
    // MANAJEMEN BARANG
    // =========================================================================

    public function manajemenBarang()
    {
        $items = Item::paginate(10);
        return view('admin.manajemen-barang', compact('items'));
    }

    public function storeBarang(Request $request)
    {
        $data = $request->validate([
            'kode_barang'  => 'required|string|max:50',
            'nama_barang'  => 'required|string|max:100',
            'kategori'     => 'required|string|max:50',
            'deskripsi'    => 'nullable|string',
            'stok'         => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'satuan'       => 'required|string|max:20',
            'kondisi'      => 'required|string',
            'lokasi'       => 'required|string|max:100',
        ]);

        $item = Item::create($data);

        $this->log(
            'CREATE', 'Manajemen Barang', 'BRG-' . str_pad($item->id, 3, '0', STR_PAD_LEFT),
            "Menambah barang baru '{$item->nama_barang}'",
            null,
            ['Nama Barang' => $item->nama_barang, 'Stok' => $item->stok, 'Kondisi' => $item->kondisi]
        );

        return redirect()->back()->with('success', 'Barang berhasil ditambahkan.');
    }

    public function updateBarang(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $data = $request->validate([
            'nama_barang'  => 'required|string|max:100',
            'kategori'     => 'required|string|max:50',
            'deskripsi'    => 'nullable|string',
            'stok'         => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'satuan'       => 'required|string|max:20',
            'kondisi'      => 'required|string',
            'lokasi'       => 'required|string|max:100',
        ]);

        $before = ['Nama Barang' => $item->nama_barang, 'Stok' => $item->stok, 'Kondisi' => $item->kondisi];
        $item->update($data);

        $this->log(
            'UPDATE', 'Manajemen Barang', 'BRG-' . str_pad($id, 3, '0', STR_PAD_LEFT),
            "Memperbarui data barang '{$item->nama_barang}'",
            $before,
            ['Nama Barang' => $item->nama_barang, 'Stok' => $item->stok, 'Kondisi' => $item->kondisi]
        );

        return redirect()->back()->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroyBarang($id)
    {
        $item   = Item::findOrFail($id);
        $before = ['ID' => 'BRG-' . str_pad($id, 3, '0', STR_PAD_LEFT), 'Nama Barang' => $item->nama_barang];
        $item->delete();

        $this->log(
            'DELETE', 'Manajemen Barang', 'BRG-' . str_pad($id, 3, '0', STR_PAD_LEFT),
            "Menghapus barang '{$before['Nama Barang']}' karena tidak layak pakai",
            $before,
            null
        );

        return redirect()->back()->with('success', 'Barang berhasil dihapus.');
    }

    public function mutasiStok(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $request->validate([
            'tipe_mutasi' => 'required|in:masuk,keluar',
            'jumlah'      => 'required|integer|min:1',
            'keterangan'  => 'nullable|string',
        ]);

        if ($request->tipe_mutasi == 'keluar' && $item->stok < $request->jumlah) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi untuk dikeluarkan.');
        }

        $stok_sebelum = $item->stok;
        $tipe         = ucfirst($request->tipe_mutasi);

        if ($request->tipe_mutasi == 'masuk') {
            $item->stok += $request->jumlah;
        } else {
            $item->stok -= $request->jumlah;
        }
        $item->save();

        \App\Models\ItemMutation::create([
            'item_id'        => $item->id,
            'tipe_mutasi'    => $tipe,
            'jumlah'         => $request->jumlah,
            'stok_sebelum'   => $stok_sebelum,
            'stok_sesudah'   => $item->stok,
            'keterangan'     => $request->keterangan,
            'dilakukan_oleh' => auth()->id(),
        ]);

        $this->log(
            'UPDATE', 'Manajemen Barang', 'BRG-' . str_pad($id, 3, '0', STR_PAD_LEFT),
            "Mutasi stok {$tipe} barang '{$item->nama_barang}' sejumlah {$request->jumlah}",
            ['Stok' => $stok_sebelum],
            ['Stok' => $item->stok]
        );

        return redirect()->back()->with('success', 'Mutasi stok berhasil.');
    }

    // =========================================================================
    // LAPORAN
    // =========================================================================

    public function laporan(Request $request)
    {
        $totalPeminjaman          = Borrowing::count();
        $peminjamanBulanIni       = Borrowing::whereMonth('created_at', now()->month)->count();
        $peminjamanAktif          = Borrowing::whereIn('status', ['Dipinjam', 'Menunggu'])->count();
        $peminjamanMenungguBulanIni = Borrowing::whereIn('status', ['Dipinjam', 'Menunggu'])->whereMonth('created_at', now()->month)->count();
        $alatRusak                = Item::where('kondisi', '!=', 'Baik')->count();
        $alatRusakBulanIni        = Item::where('kondisi', '!=', 'Baik')->whereMonth('updated_at', now()->month)->count();
        $totalMahasiswa           = User::where('role', 'mahasiswa')->count();
        $mahasiswaBaruBulanIni    = User::where('role', 'mahasiswa')->whereMonth('created_at', now()->month)->count();

        $alatSeringDipinjam = \Illuminate\Support\Facades\DB::table('borrowing_items')
            ->join('tools', 'borrowing_items.tool_id', '=', 'tools.id')
            ->select('tools.nama_alat', \Illuminate\Support\Facades\DB::raw('SUM(borrowing_items.jumlah_unit) as total'))
            ->groupBy('tools.id', 'tools.nama_alat')
            ->orderBy('total', 'desc')
            ->take(7)
            ->get();

        $jenisFilter  = $request->query('jenis', 'semua');
        $statusFilter = $request->query('status', '');
        $dariFilter   = $request->query('dari', '');
        $sampaiFilter = $request->query('sampai', '');

        $statusPeminjaman = ['Dipinjam', 'Dikembalikan', 'Ditolak', 'Menunggu', 'Disetujui', 'Diproses'];
        $statusInventaris = ['Baik', 'Rusak Ringan', 'Rusak Berat', 'Tidak Layak'];
        $statusMutasi     = ['Masuk', 'Keluar'];

        $queryPeminjaman = Borrowing::with('mahasiswa', 'items.tool')->orderBy('created_at', 'desc');
        if (in_array($jenisFilter, ['semua', 'peminjaman'])) {
            if ($statusFilter && in_array($statusFilter, $statusPeminjaman)) $queryPeminjaman->where('status', $statusFilter);
            if ($dariFilter)   $queryPeminjaman->whereDate('tgl_rencana_pinjam', '>=', $dariFilter);
            if ($sampaiFilter) $queryPeminjaman->whereDate('tgl_rencana_pinjam', '<=', $sampaiFilter);
        }
        $rekapPeminjaman = $queryPeminjaman->paginate(10, ['*'], 'page_pjm')->withQueryString();

        $queryInventaris = Item::orderBy('nama_barang');
        if (in_array($jenisFilter, ['semua', 'inventaris'])) {
            if ($statusFilter && in_array($statusFilter, $statusInventaris)) $queryInventaris->where('kondisi', $statusFilter);
        }
        $inventarisList = $queryInventaris->paginate(10, ['*'], 'page_inv')->withQueryString();

        $queryMutasi = \App\Models\ItemMutation::with('item')->orderBy('created_at', 'desc');
        if (in_array($jenisFilter, ['semua', 'mutasi'])) {
            if ($statusFilter && in_array($statusFilter, $statusMutasi)) $queryMutasi->where('tipe_mutasi', $statusFilter);
            if ($dariFilter)   $queryMutasi->whereDate('created_at', '>=', $dariFilter);
            if ($sampaiFilter) $queryMutasi->whereDate('created_at', '<=', $sampaiFilter);
        }
        $mutasiList = $queryMutasi->paginate(10, ['*'], 'page_mut')->withQueryString();

        $queryMahasiswa = User::where('role', 'mahasiswa')->withCount([
            'borrowings as total_pengajuan',
            'borrowings as menunggu'     => fn($q) => $q->where('status', 'Menunggu'),
            'borrowings as disetujui'    => fn($q) => $q->where('status', 'Disetujui'),
            'borrowings as dipinjam'     => fn($q) => $q->whereIn('status', ['Diproses', 'Dipinjam']),
            'borrowings as ditolak'      => fn($q) => $q->where('status', 'Ditolak'),
            'borrowings as dikembalikan' => fn($q) => $q->where('status', 'Dikembalikan'),
        ])->orderBy('nama_lengkap');

        $rekapMahasiswa = $queryMahasiswa->paginate(10, ['*'], 'page_mhs')->withQueryString();
        $rekapMahasiswa->getCollection()->transform(function ($mhs) {
            $mhs->aktif   = ($mhs->menunggu ?? 0) + ($mhs->disetujui ?? 0) + ($mhs->dipinjam ?? 0);
            $mhs->selesai = ($mhs->dikembalikan ?? 0);
            return $mhs;
        });

        return view('admin.laporan', compact(
            'totalPeminjaman', 'peminjamanBulanIni', 'peminjamanAktif', 'peminjamanMenungguBulanIni',
            'alatRusak', 'alatRusakBulanIni', 'totalMahasiswa', 'mahasiswaBaruBulanIni',
            'alatSeringDipinjam', 'rekapPeminjaman', 'inventarisList', 'mutasiList', 'rekapMahasiswa',
            'jenisFilter', 'statusFilter', 'dariFilter', 'sampaiFilter'
        ));
    }

    public function exportLaporan(Request $request)
    {
        $jenis  = $request->query('jenis', 'semua');
        $status = $request->query('status', '');
        $dari   = $request->query('dari', '');
        $sampai = $request->query('sampai', '');

        if ($dari && $sampai && $dari > $sampai) {
            abort(422, 'Rentang tanggal tidak valid.');
        }

        $rows       = [];
        $filename   = 'laporan-' . $jenis . '-' . now()->format('Ymd-His') . '.csv';
        $isGabungan = ($jenis === 'semua');

        if (in_array($jenis, ['semua', 'peminjaman'])) {
            $query = Borrowing::with(['mahasiswa', 'items.tool'])->orderBy('id', 'asc');
            $statusPeminjaman = ['Dipinjam', 'Dikembalikan', 'Ditolak', 'Menunggu', 'Disetujui', 'Diproses'];
            if ($status && in_array($status, $statusPeminjaman)) $query->where('status', $status);
            if ($dari)   $query->whereDate('tgl_rencana_pinjam', '>=', $dari);
            if ($sampai) $query->whereDate('tgl_rencana_pinjam', '<=', $sampai);

            if ($isGabungan) $rows[] = ['REKAP PEMINJAMAN'];
            $rows[] = ['ID Peminjaman', 'Nama Mahasiswa', 'NIM', 'Program Studi', 'Jumlah Alat', 'Tanggal Pinjam', 'Tanggal Kembali', 'Status'];

            foreach ($query->get() as $pjm) {
                $rows[] = [
                    'PJM-' . str_pad($pjm->id, 3, '0', STR_PAD_LEFT),
                    $pjm->mahasiswa->nama_lengkap ?? ($pjm->mahasiswa->name ?? '-'),
                    $pjm->mahasiswa->nim ?? '-',
                    $pjm->mahasiswa->program_studi ?? '-',
                    $pjm->items->sum('jumlah_unit'),
                    $pjm->tgl_rencana_pinjam  ? \Carbon\Carbon::parse($pjm->tgl_rencana_pinjam)->format('d/m/Y')  : '-',
                    $pjm->tgl_rencana_kembali ? \Carbon\Carbon::parse($pjm->tgl_rencana_kembali)->format('d/m/Y') : '-',
                    $pjm->status,
                ];
            }
            if ($isGabungan) $rows[] = array_fill(0, 8, '');
        }

        if (in_array($jenis, ['semua', 'inventaris'])) {
            $query = Item::orderBy('nama_barang');
            $statusInventaris = ['Baik', 'Rusak Ringan', 'Rusak Berat', 'Tidak Layak'];
            if ($status && in_array($status, $statusInventaris)) $query->where('kondisi', $status);

            if ($isGabungan) $rows[] = ['STATUS INVENTARIS'];
            $rows[] = ['Kode', 'Nama Barang', 'Kategori', 'Stok', 'Min Stok', 'Kondisi', 'Lokasi'];

            foreach ($query->get() as $inv) {
                $rows[] = [
                    'BRG-' . str_pad($inv->id, 3, '0', STR_PAD_LEFT),
                    $inv->nama_barang,
                    $inv->kategori     ?? '-',
                    $inv->stok,
                    $inv->stok_minimum ?? 10,
                    $inv->kondisi      ?? 'Baik',
                    $inv->lokasi       ?? '-',
                ];
            }
            if ($isGabungan) $rows[] = array_fill(0, 7, '');
        }

        if (in_array($jenis, ['semua', 'mutasi'])) {
            $query = \App\Models\ItemMutation::with('item')->orderBy('created_at', 'asc');
            if ($status && in_array($status, ['Masuk', 'Keluar'])) $query->where('tipe_mutasi', $status);
            if ($dari)   $query->whereDate('created_at', '>=', $dari);
            if ($sampai) $query->whereDate('created_at', '<=', $sampai);

            if ($isGabungan) $rows[] = ['LOG MUTASI STOK'];
            $rows[] = ['ID Mutasi', 'Tanggal', 'Nama Barang', 'Tipe Mutasi', 'Jumlah', 'Stok Sebelum', 'Stok Sesudah', 'Keterangan', 'Operator'];

            foreach ($query->get() as $mutasi) {
                $user     = $mutasi->dilakukan_oleh ? User::find($mutasi->dilakukan_oleh) : null;
                $operator = $user ? ($user->nama_lengkap ?? $user->name) : 'Admin Lab';
                $rows[]   = [
                    'MUT-' . str_pad($mutasi->id, 3, '0', STR_PAD_LEFT),
                    $mutasi->created_at ? $mutasi->created_at->format('d/m/Y H:i') : '-',
                    $mutasi->item->nama_barang ?? '-',
                    $mutasi->tipe_mutasi ?? '-',
                    $mutasi->jumlah,
                    $mutasi->stok_sebelum ?? '-',
                    $mutasi->stok_sesudah ?? '-',
                    $mutasi->keterangan   ?? '-',
                    $operator,
                ];
            }
            if ($isGabungan) $rows[] = array_fill(0, 9, '');
        }

        if (in_array($jenis, ['semua', 'mahasiswa'])) {
            $data = User::where('role', 'mahasiswa')->withCount([
                'borrowings as total_pengajuan',
                'borrowings as dipinjam'     => fn($q) => $q->whereIn('status', ['Diproses', 'Dipinjam']),
                'borrowings as menunggu'     => fn($q) => $q->where('status', 'Menunggu'),
                'borrowings as ditolak'      => fn($q) => $q->where('status', 'Ditolak'),
                'borrowings as dikembalikan' => fn($q) => $q->where('status', 'Dikembalikan'),
            ])->orderBy('nama_lengkap')->get();

            if ($isGabungan) $rows[] = ['REKAP MAHASISWA & DOSEN'];
            $rows[] = ['Nama', 'NIM/NIDN', 'Program Studi', 'Total Pengajuan', 'Aktif/Dipinjam', 'Menunggu', 'Dikembalikan', 'Ditolak'];

            foreach ($data as $mhs) {
                $rows[] = [
                    $mhs->nama_lengkap ?? '-',
                    $mhs->nim           ?? '-',
                    strtolower($mhs->name ?? '') === 'dosen' ? '-' : ($mhs->program_studi ?? '-'),
                    $mhs->total_pengajuan,
                    $mhs->dipinjam,
                    $mhs->menunggu,
                    $mhs->dikembalikan,
                    $mhs->ditolak,
                ];
            }
        }

        $callback = function () use ($rows) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
            foreach ($rows as $row) {
                fputcsv($handle, $row);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Cache-Control'       => 'no-cache, no-store, must-revalidate',
            'Pragma'              => 'no-cache',
            'Expires'             => '0',
        ]);
    }

    // =========================================================================
    // AUDIT TRAIL
    // =========================================================================

    public function auditTrail(Request $request)
    {
        $query = Auditlog::orderBy('created_at', 'desc');

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->filled('role')) {
            $query->where('role_pelaku', $request->role);
        }

        if ($request->filled('modul')) {
            $query->where('modul', $request->modul);
        }

        if ($request->filled('aksi')) {
            $query->where('aksi', $request->aksi);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pelaku', 'like', "%{$search}%")
                  ->orWhere('modul', 'like', "%{$search}%")
                  ->orWhere('aksi', 'like', "%{$search}%")
                  ->orWhere('id_record', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        $logs = $query->paginate(10)->withQueryString();

        return view('admin.audit-trail', compact('logs'));
    }

    public function exportAuditTrail(Request $request)
    {
        $query = Auditlog::orderBy('created_at', 'desc');

        if ($request->filled('date'))   $query->whereDate('created_at', $request->date);
        if ($request->filled('role'))   $query->where('role_pelaku', $request->role);
        if ($request->filled('modul'))  $query->where('modul', $request->modul);
        if ($request->filled('aksi'))   $query->where('aksi', $request->aksi);
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pelaku', 'like', "%{$search}%")
                  ->orWhere('modul', 'like', "%{$search}%")
                  ->orWhere('aksi', 'like', "%{$search}%")
                  ->orWhere('id_record', 'like', "%{$search}%");
            });
        }

        $logs     = $query->get();
        $filename = 'audit_trail_' . now()->format('Ymd_His') . '.csv';

        // Catat aksi export ini ke audit log
        $this->log(
            'EXPORT', 'Laporan',
            null,
            'Mengekspor audit trail ke CSV',
            null,
            ['Jumlah Ekport' => $logs->count()]
        );

        $callback = function () use ($logs) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($handle, ['ID Audit', 'Timestamp', 'User', 'Role', 'Modul', 'Aksi', 'Record ID', 'IP Address', 'Deskripsi']);

            foreach ($logs as $log) {
                fputcsv($handle, [
                    'AUD-' . str_pad($log->id, 3, '0', STR_PAD_LEFT),
                    $log->created_at?->format('Y-m-d H:i:s') ?? '-',
                    $log->nama_pelaku  ?? 'System',
                    $log->role_pelaku  ?? '-',
                    $log->modul,
                    $log->aksi,
                    $log->id_record    ?? '-',
                    $log->ip_address   ?? '-',
                    $log->deskripsi    ?? '-',
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Cache-Control'       => 'no-cache, no-store, must-revalidate',
            'Pragma'              => 'no-cache',
            'Expires'             => '0',
        ]);
    }

    // =========================================================================
    // MANAJEMEN USER
    // =========================================================================

    public function manajemenUser()
    {
        $users = User::paginate(10);
        return view('admin.manajemen-user', compact('users'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users',
            'password'     => 'required|string|min:8',
            'role'         => 'required|in:Admin,Mahasiswa,Dosen',
            'nim'          => 'nullable|string',
            'program_studi' => 'nullable|string',
        ]);

        $user = User::create([
            'name'          => $request->name,
            'nama_lengkap'  => $request->name,
            'email'         => $request->email,
            'password'      => \Illuminate\Support\Facades\Hash::make($request->password),
            'role'          => strtolower($request->role),
            'nim'           => $request->nim,
            'program_studi' => $request->program_studi,
            'is_active'     => $request->has('is_active') ? 1 : 0,
        ]);

        $this->log(
            'CREATE', 'Manajemen User', 'USR-' . str_pad($user->id, 3, '0', STR_PAD_LEFT),
            "Menambah user baru '{$user->name}' dengan role {$user->role}",
            null,
            ['Nama' => $user->name, 'Email' => $user->email, 'Role' => $user->role]
        );

        return redirect()->back()->with('success', 'User berhasil ditambahkan.');
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|string|email|max:255|unique:users,email,' . $id,
            'role'         => 'required|in:Admin,Mahasiswa,Dosen',
            'nim'          => 'nullable|string',
            'program_studi' => 'nullable|string',
        ]);

        $before = ['Nama' => $user->name, 'Email' => $user->email, 'Role' => $user->role];

        $user->update([
            'name'          => $request->name,
            'nama_lengkap'  => $request->name,
            'email'         => $request->email,
            'role'          => strtolower($request->role),
            'nim'           => $request->nim,
            'program_studi' => $request->program_studi,
            'is_active'     => $request->has('is_active') ? 1 : 0,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => \Illuminate\Support\Facades\Hash::make($request->password)]);
        }

        $this->log(
            'UPDATE', 'Manajemen User', 'USR-' . str_pad($id, 3, '0', STR_PAD_LEFT),
            "Memperbarui data user '{$user->name}'",
            $before,
            ['Nama' => $user->name, 'Email' => $user->email, 'Role' => $user->role]
        );

        return redirect()->back()->with('success', 'Data user berhasil diperbarui.');
    }

    public function toggleStatusUser($id)
    {
        $user = User::findOrFail($id);
        $before = ['Status' => $user->is_active == 1 ? 'Aktif' : 'Nonaktif'];

        $user->is_active = $user->is_active == 1 ? 0 : 1;
        $user->save();

        $statusBaru = $user->is_active == 1 ? 'Aktif' : 'Nonaktif';

        $this->log(
            'UPDATE', 'Manajemen User', 'USR-' . str_pad($id, 3, '0', STR_PAD_LEFT),
            "Mengubah status user '{$user->name}' menjadi {$statusBaru}",
            $before,
            ['Status' => $statusBaru]
        );

        return redirect()->back()->with('success', "Status user berhasil diubah menjadi {$statusBaru}.");
    }
}