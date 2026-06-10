<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Borrowing_Item;
use App\Models\Tool;
use App\Models\Auditlog;
use App\Services\N8NWebhookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiBorrowingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $query = Borrowing::with('mahasiswa', 'borrowingItems.tool')->orderBy('created_at', 'desc');

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $borrowings = $query->paginate(10);
        
        $borrowings->getCollection()->transform(function ($borrowing) {
            $borrowing->jumlah_alat = $borrowing->borrowingItems->sum('jumlah_unit');
            return $borrowing;
        });

        return response()->json(['status' => 'success', 'data' => $borrowings]);
    }

    public function myBorrowings(Request $request)
    {
        $borrowings = Borrowing::with('borrowingItems.tool')
            ->where('mahasiswa_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json(['status' => 'success', 'data' => $borrowings]);
    }

    public function show($id)
    {
        $borrowing = Borrowing::with('borrowingItems.tool', 'mahasiswa')->findOrFail($id);
        return response()->json(['status' => 'success', 'data' => $borrowing]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.tool_id' => 'required|exists:tools,id',
            'items.*.jumlah_unit' => 'required|integer|min:1',
            'tgl_rencana_pinjam' => 'required|date|after_or_equal:today',
            'tgl_rencana_kembali' => 'required|date|after_or_equal:tgl_rencana_pinjam',
            'keperluan' => 'required|string',
        ]);

        $activeBorrowing = Borrowing::where('mahasiswa_id', $request->user()->id)
            ->whereIn('status', ['Menunggu', 'Disetujui', 'Dipinjam'])
            ->exists();

        if ($activeBorrowing) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda masih memiliki peminjaman aktif.'
            ], 400);
        }

        DB::beginTransaction();
        try {
            $borrowing = Borrowing::create([
                'mahasiswa_id' => $request->user()->id,
                'tgl_rencana_pinjam' => $request->tgl_rencana_pinjam,
                'tgl_rencana_kembali' => $request->tgl_rencana_kembali,
                'keperluan' => $request->keperluan,
                'status' => 'Menunggu'
            ]);

            foreach ($request->items as $item) {
                $tool = Tool::findOrFail($item['tool_id']);
                
                if ($tool->stok_tersedia < $item['jumlah_unit']) {
                    throw new \Exception('Stok alat ' . $tool->nama_alat . ' tidak mencukupi.');
                }

                $tool->stok_tersedia -= $item['jumlah_unit'];
                $tool->save();

                Borrowing_Item::create([
                    'borrowing_id' => $borrowing->id,
                    'tool_id' => $tool->id,
                    'jumlah_unit' => $item['jumlah_unit']
                ]);
            }

            DB::commit();

            N8NWebhookService::sendBorrowingEvent('borrowing.submitted', $borrowing);

            return response()->json(['status' => 'success', 'data' => $borrowing], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    public function approve(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $borrowing = Borrowing::findOrFail($id);
        $borrowing->status = 'Disetujui';
        $borrowing->diproses_oleh = $request->user()->id;
        $borrowing->tgl_diproses = now();
        $borrowing->save();
        
        Auditlog::create([
            'nama_pelaku' => $request->user()->nama_lengkap ?? $request->user()->name,
            'role_pelaku' => 'Admin',
            'modul' => 'Peminjaman',
            'aksi' => 'APPROVE',
            'id_record' => $id
        ]);
        
        N8NWebhookService::sendBorrowingEvent('borrowing.approved', $borrowing);

        return response()->json(['status' => 'success', 'data' => $borrowing]);
    }

    public function reject(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'catatan_admin' => 'required|string|max:1000'
        ]);

        $borrowing = Borrowing::findOrFail($id);
        $borrowing->status = 'Ditolak';
        $borrowing->diproses_oleh = $request->user()->id;
        $borrowing->tgl_diproses = now();
        $borrowing->catatan_admin = $request->catatan_admin;
        $borrowing->save();
        
        foreach($borrowing->borrowingItems as $item) {
            $tool = $item->tool;
            if($tool) {
                $tool->stok_tersedia += $item->jumlah_unit;
                $tool->save();
            }
        }
        
        Auditlog::create([
            'nama_pelaku' => $request->user()->nama_lengkap ?? $request->user()->name,
            'role_pelaku' => 'Admin',
            'modul' => 'Peminjaman',
            'aksi' => 'REJECT',
            'id_record' => $id
        ]);
        
        N8NWebhookService::sendBorrowingEvent('borrowing.rejected', $borrowing);

        return response()->json(['status' => 'success', 'data' => $borrowing]);
    }

    public function returnBorrowing(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $borrowing = Borrowing::with('borrowingItems.tool')->findOrFail($id);
        
        $kondisiArray = $request->input('kondisi', []);

        $borrowing->status = 'Dikembalikan';
        $borrowing->tgl_pengembalian_aktual = now();
        $borrowing->save();

        foreach($borrowing->borrowingItems as $item) {
            $tool = $item->tool;
            $kondisi = $kondisiArray[$item->id]['kondisi_saat_kembali'] ?? 'Baik';
            $catatan = $kondisiArray[$item->id]['catatan_pengembalian'] ?? null;
            
            $item->kondisi_saat_kembali = $kondisi;
            $item->catatan_pengembalian = $catatan;
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
            'nama_pelaku' => $request->user()->nama_lengkap ?? $request->user()->name,
            'role_pelaku' => 'Admin',
            'modul' => 'Peminjaman',
            'aksi' => 'RETURN',
            'id_record' => $id
        ]);
        
        N8NWebhookService::sendBorrowingEvent('borrowing.returned', $borrowing);

        return response()->json(['status' => 'success', 'data' => $borrowing]);
    }
}
