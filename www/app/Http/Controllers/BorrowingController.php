<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowing;
use App\Models\Borrowing_Item;
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
     */
    public function index()
    {
        $user = Auth::user();

        $user = Auth::user();
        $userId = $user->id;

        $dataPeminjaman = Borrowing::with(['items.tool'])
                            ->where('mahasiswa_id', $userId)
                            ->orderBy('created_at', 'desc')
                            ->get();

        $peminjaman = [];

        foreach ($dataPeminjaman as $row) {
            $namaAlat = 'Tidak Diketahui';
            if ($row->items->count() > 0) {
                $namaAlat = $row->items->first()->tool->nama_alat ?? 'Alat Lab';
                if ($row->items->count() > 1) {
                    $namaAlat .= ' (+ ' . ($row->items->count() - 1) . ' alat lainnya)';
                }
            }

            $tglAju     = Carbon::parse($row->created_at)->translatedFormat('d F Y');
            $tglPinjam  = Carbon::parse($row->tgl_rencana_pinjam)->translatedFormat('d M Y');
            $tglKembali = Carbon::parse($row->tgl_rencana_kembali)->translatedFormat('d M Y');

            $peminjaman[] = [
                'raw_id'  => $row->id,
                'id'      => 'PMJ-' . Carbon::parse($row->created_at)->format('Y') . '-' . str_pad($row->id, 3, '0', STR_PAD_LEFT),
                'alat'    => $namaAlat,
                'tgl_aju' => $tglAju,
                'periode' => $tglPinjam . ' — ' . $tglKembali,
                'status'  => strtolower($row->status),
            ];
        }

        return view('mahasiswa.peminjaman', compact('peminjaman', 'user'));
    }

    /**
     * 2. HALAMAN FORM INPUT
     */
    public function create()
    {
        $tools = Tool::where('stok_tersedia', '>', 0)
                     ->whereNull('deleted_at')
                     ->get();

        return view('mahasiswa.form_peminjaman', compact('tools'));
    }

    /**
     * 3. PROSES SIMPAN: Baca dari session cart (keranjang), bukan dari input form langsung
     */
    public function store(Request $request)
    {
        // 1. Validasi input tanggal & keperluan
        $request->validate([
            'tgl_rencana_pinjam'  => 'required|date|after_or_equal:today',
            'tgl_rencana_kembali' => 'required|date|after:tgl_rencana_pinjam',
            'keperluan'           => 'required|string|max:500',
        ]);

        // 2. Ambil data cart dari session (bukan dari input form)
        $cart = session()->get('cart', []);

        // Gabungkan jumlah_unit dari form (user bisa update qty di keranjang)
        // Format input dari keranjang.blade.php: items[id][jumlah_unit]
        $itemsInput = $request->input('items', []);

        if (empty($cart)) {
            return redirect()->back()->withErrors(['error' => 'Keranjang kosong! Silakan tambahkan alat terlebih dahulu.'])->withInput();
        }

        $userId = Auth::id();

        // 3. Cek peminjaman aktif
        $activeBorrowing = Borrowing::where('mahasiswa_id', $userId)
            ->whereIn('status', ['Menunggu', 'Disetujui', 'Dipinjam'])
            ->first();

        if ($activeBorrowing) {
            return redirect()->back()->withErrors(['error' => 'Anda masih memiliki peminjaman yang aktif atau menunggu persetujuan.'])->withInput();
        }

        DB::beginTransaction();

        try {
            // 4. Simpan ke tabel borrowings
            $borrowing = new Borrowing();
            $borrowing->mahasiswa_id        = $userId;
            $borrowing->tgl_rencana_pinjam  = $request->tgl_rencana_pinjam;
            $borrowing->tgl_rencana_kembali = $request->tgl_rencana_kembali;
            $borrowing->keperluan           = $request->keperluan;
            $borrowing->status              = 'Menunggu';
            $borrowing->save();

            // 5. Loop cart session untuk simpan borrowing_items
            foreach ($cart as $toolId => $details) {
                // Ambil jumlah dari form jika user ubah qty, fallback ke session
                $qtyDiminta = isset($itemsInput[$toolId]['jumlah_unit'])
                    ? (int) $itemsInput[$toolId]['jumlah_unit']
                    : (int) ($details['jumlah_unit'] ?? 1);

                $tool = Tool::find($toolId);
                if (!$tool || $tool->stok_tersedia < $qtyDiminta) {
                    throw new Exception("Stok untuk alat '" . ($tool->nama_alat ?? 'Tidak Diketahui') . "' tidak mencukupi!");
                }

                $detail               = new Borrowing_Item();
                $detail->borrowing_id = $borrowing->id;
                $detail->tool_id      = $toolId;
                $detail->jumlah_unit  = $qtyDiminta;
                $detail->save();

                // Kurangi stok
                $tool->stok_tersedia -= $qtyDiminta;
                $tool->save();
            }

            DB::commit();

            // 6. Kosongkan keranjang setelah berhasil submit
            session()->forget('cart');

            // Trigger webhook N8N
            N8NWebhookService::sendBorrowingEvent('borrowing.submitted', $borrowing);

            return redirect()->route('peminjaman')->with('success', 'Pengajuan peminjaman berhasil dikirim! Menunggu persetujuan admin.');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * 4. HALAMAN DETAIL
     */
    public function show(string $id)
    {
        $detail = Borrowing::with(['items.tool'])->findOrFail($id);

        $user = Auth::user();

        $user = Auth::user();

        // Kolom 'name' di tabel users sebenarnya menyimpan ROLE user
        // (mis. "Admin", "Mahasiswa", "Dosen"), bukan nama orangnya.
        // Normalisasi ke lowercase biar konsisten dipakai di blade ($isDosen).
        $user->role = strtolower($user->name ?? 'mahasiswa');

        return view('mahasiswa.detail_peminjaman', compact('detail', 'user'));
    }
}