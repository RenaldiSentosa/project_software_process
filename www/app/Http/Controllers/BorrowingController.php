<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowing;
use App\Models\Borrowing_Item; // Sesuai nama model pakai underscore abang
use App\Models\Tool;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Exception;

class BorrowingController extends Controller
{
    /**
     * Tampilkan halaman form peminjaman alat (Halaman Blade Mahasiswa)
     */
    public function create()
    {
        // Ambil semua alat lab yang stok_tersedia-nya masih ada di atas 0
        $tools = Tool::where('stok_tersedia', '>', 0)
                     ->whereNull('deleted_at')
                     ->get();

        // GANTI BARIS INI YA BANG:
        return view('mahasiswa.peminjaman', compact('tools'));
    }

    /**
     * Proses simpan data pengajuan peminjaman ke Database
     */
    public function store(Request $request)
    {
        // 1. Validasi input dari form blade abang
        $request->validate([
            'tgl_rencana_pinjam'   => 'required|date|after_or_equal:today',
            'tgl_rencana_kembali'  => 'required|date|after:tgl_rencana_pinjam',
            'keperluan'            => 'required|string|max:500',
            'tools'                => 'required|array', // Array ID alat yang dipilih
            'jumlah_unit'          => 'required|array', // Array jumlah unit tiap alat
        ]);

        // Gunakan DB Transaction biar aman. Kalau di tengah jalan ada yang error, data otomatis dibatalkan (rollback)
        DB::beginTransaction();

        try {
            // 2. Simpan ke tabel master 'borrowings'
            $borrowing = new Borrowing();
            // Jika fitur Auth login abang sudah jadi, pakai: Auth::id()
            // Sementara untuk testing backend, kita hardcode dulu ke ID 2 (sesuaikan ID mahasiswa di tabel users abang)
            $borrowing->mahasiswa_id = Auth::id() ?? 2; 
            $borrowing->tgl_rencana_pinjam = $request->tgl_rencana_pinjam;
            $borrowing->tgl_rencana_kembali = $request->tgl_rencana_kembali;
            $borrowing->keperluan = $request->keperluan;
            $borrowing->status = 'Menunggu'; // Status default awal
            $borrowing->save();

            // 3. Looping untuk simpan ke tabel detail 'borrowing_items'
            foreach ($request->tools as $index => $toolId) {
                $qtyDiminta = $request->jumlah_unit[$index];

                // Cek stok alat di database apakah mencukupi
                $tool = Tool::find($toolId);
                if (!$tool || $tool->stok_tersedia < $qtyDiminta) {
                    throw new Exception("Stok untuk alat '" . ($tool->nama_alat ?? 'Tidak Diketahui') . "' tidak mencukupi!");
                }

                // Simpan detailnya
                $detail = new Borrowing_Item(); // Memanggil Model dengan underscore abang
                $detail->borrowing_id = $borrowing->id;
                $detail->tool_id = $toolId;
                $detail->jumlah_unit = $qtyDiminta;
                $detail->save();
            }

            // Jika semua proses looping aman, kunci perubahan ke database
            DB::commit();

            return redirect()->back()->with('success', 'Pengajuan peminjaman alat berhasil dikirim! Menunggu persetujuan admin.');

        } catch (Exception $e) {
            // Jika ada gagal di tengah jalan, batalkan semua insert data di atas
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
}