<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowing;
use App\Models\Borrowing_Item; // Sesuai nama model pakai underscore abang
use App\Models\Tool;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;
use App\Services\N8NWebhookService;

class BorrowingController extends Controller
{
    /**
     * 1. HALAMAN RIWAYAT TABEL: Tampilkan list riwayat "Peminjaman Saya"
     * Fungsi ini mengambil data peminjaman sekaligus data User yang sedang login secara dinamis
     */
    public function index()
    {
        // Ambil data user mahasiswa yang sedang login secara realtime dari DB
        $user = Auth::user(); 
        
        // Fallback objek dummy jika belum login / untuk kebutuhan testing awal backend agar tidak crash
        if (!$user) {
            $user = (object)[
                'id' => 2,
                'name' => 'Aprizal Kim',
                'nim' => '202301110011',
                'program_studi' => 'Teknik Informatika'
            ];
        }

        $userId = $user->id ?? 2;

        // Ambil data peminjaman milik user ini beserta detail item alat & nama alatnya
        $dataPeminjaman = Borrowing::with(['items.tool'])
                            ->where('mahasiswa_id', $userId)
                            ->orderBy('created_at', 'desc')
                            ->get();

        // Format datanya menjadi array rapi agar pas dengan struktur tabel di Blade lu bang
        $peminjaman = [];
        
        foreach ($dataPeminjaman as $row) {
            // Logika penentuan nama alat yang tampil di kolom tabel
            $namaAlat = 'Tidak Diketahui';
            if ($row->items->count() > 0) {
                $namaAlat = $row->items->first()->tool->nama_alat ?? 'Alat Lab';
                // Jika meminjam lebih dari 1 jenis alat, beri keterangan tambahan (+ x alat lainnya)
                if ($row->items->count() > 1) {
                    $namaAlat .= ' (+ ' . ($row->items->count() - 1) . ' alat lainnya)';
                }
            }

            // Mengubah format tanggal bawaan DB menjadi format teks Indonesia (Contoh: 10 Mei 2026)
            $tglAju = Carbon::parse($row->created_at)->translatedFormat('d F Y');
            $tglPinjam = Carbon::parse($row->tgl_rencana_pinjam)->translatedFormat('d M Y');
            $tglKembali = Carbon::parse($row->tgl_rencana_kembali)->translatedFormat('d M Y');

            $peminjaman[] = [
                // Membuat format nomor invoice/ID peminjaman custom (Contoh: PMJ-2026-001)
                'raw_id'  => $row->id,
                'id'      => 'PMJ-' . Carbon::parse($row->created_at)->format('Y') . '-' . str_pad($row->id, 3, '0', STR_PAD_LEFT),
                'alat'    => $namaAlat,
                'tgl_aju' => $tglAju,
                'periode' => $tglPinjam . ' — ' . $tglKembali,
                'status'  => strtolower($row->status), // Dipaksa lowercase agar sesuai dengan warna badge CSS (.menunggu, .disetujui)
            ];
        }

        // Kirim variabel $peminjaman dan data $user ke view riwayat mahasiswa
        return view('mahasiswa.peminjaman', compact('peminjaman', 'user'));
    }

    /**
     * 2. HALAMAN FORM INPUT: Tampilkan halaman form pengisian peminjaman alat
     */
    public function create()
    {
        // Ambil semua alat lab yang stok_tersedia-nya masih ada di atas 0
        $tools = Tool::where('stok_tersedia', '>', 0)
                     ->whereNull('deleted_at')
                     ->get();

        // Diarahkan ke file form pengajuan pinjam (Sesuaikan nama file view form lu ya bang, misal: form_peminjaman)
        return view('mahasiswa.form_peminjaman', compact('tools'));
    }

    /**
     * 3. PROSES SIMPAN: Proses validasi dan simpan data pengajuan peminjaman ke Database
     */
    public function store(Request $request)
    {
        // 1. Validasi input form
        $request->validate([
            'tgl_rencana_pinjam'   => 'required|date|after_or_equal:today',
            'tgl_rencana_kembali'  => 'required|date|after:tgl_rencana_pinjam',
            'keperluan'            => 'required|string|max:500',
            'tools'                => 'required|array', // Array ID alat yang dipilih dari checklist/keranjang
            'jumlah_unit'          => 'required|array', // Array jumlah unit tiap alat
        ]);

        $userId = Auth::id() ?? 2;

        // Cek apakah mahasiswa masih memiliki peminjaman aktif
        $activeBorrowing = Borrowing::where('mahasiswa_id', $userId)
            ->whereIn('status', ['Menunggu', 'Disetujui', 'Dipinjam'])
            ->first();

        if ($activeBorrowing) {
            return redirect()->back()->withErrors(['error' => 'Anda tidak dapat mengajukan peminjaman baru karena masih memiliki peminjaman yang sedang aktif atau menunggu persetujuan.'])->withInput();
        }

        // Gunakan DB Transaction biar aman. Kalau di tengah jalan ada satu yang gagal, semua insert otomatis dibatalkan (rollback)
        DB::beginTransaction();

        try {
            // 2. Simpan ke tabel master 'borrowings'
            $borrowing = new Borrowing();
            $borrowing->mahasiswa_id = $userId; 
            $borrowing->tgl_rencana_pinjam = $request->tgl_rencana_pinjam;
            $borrowing->tgl_rencana_kembali = $request->tgl_rencana_kembali;
            $borrowing->keperluan = $request->keperluan;
            $borrowing->status = 'Menunggu'; // Status default awal pengajuan
            $borrowing->save();

            // 3. Looping untuk simpan ke tabel detail 'borrowing_items'
            foreach ($request->tools as $index => $toolId) {
                $qtyDiminta = $request->jumlah_unit[$index];

                // Cek ketersediaan stok alat di database secara realtime
                $tool = Tool::find($toolId);
                if (!$tool || $tool->stok_tersedia < $qtyDiminta) {
                    throw new Exception("Stok untuk alat '" . ($tool->nama_alat ?? 'Tidak Diketahui') . "' tidak mencukupi atau alat tidak ditemukan!");
                }

                // Simpan baris detail barang yang dipinjam
                $detail = new Borrowing_Item(); 
                $detail->borrowing_id = $borrowing->id;
                $detail->tool_id = $toolId;
                $detail->jumlah_unit = $qtyDiminta;
                $detail->save();

                // Kurangi stok alat secara sementara (reserved)
                $tool->stok_tersedia -= $qtyDiminta;
                $tool->save();
            }

            // Kunci perubahan data jika seluruh proses aman tanpa hambatan
            DB::commit();
            
            // Trigger webhook untuk N8N
            N8NWebhookService::sendBorrowingEvent('borrowing.submitted', $borrowing);

            // Redirect balik ke rute halaman list riwayat dengan flash alert sukses
            return redirect()->route('peminjaman')->with('success', 'Pengajuan peminjaman alat berhasil dikirim! Menunggu persetujuan admin.');

        } catch (Exception $e) {
            // Batalkan semua insert data jika terjadi error di tengah jalan agar database tidak korup/berantakan
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * 4. HALAMAN DETAIL: Tampilkan rincian detail item alat yang dipinjam
     * Dipanggil saat tombol "Detail" atau "Aksi" di tabel diklik
     */
    public function show(string $id)
    {
        // Ambil data peminjaman beserta relasi item dan alatnya berdasarkan ID rute URL
        $detail = Borrowing::with(['items.tool'])->findOrFail($id);
        
        // Ambil data user yang sedang login untuk informasi header profil di blade detail
        $user = Auth::user() ?? (object)[
            'name' => 'Aprizal Kim',
            'nim' => '202301110011',
            'program_studi' => 'Teknik Informatika'
        ];

        // Mengarahkan ke file view detail peminjaman milik mahasiswa
        return view('mahasiswa.detail_peminjaman', compact('detail', 'user'));
    }
}