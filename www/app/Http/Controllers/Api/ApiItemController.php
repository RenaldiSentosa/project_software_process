<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\ItemMutation;
use App\Models\Auditlog;
use Illuminate\Http\Request;

class ApiItemController extends Controller
{
    public function index()
    {
        $items = Item::paginate(10);
        return response()->json(['status' => 'success', 'data' => $items]);
    }

    public function show($id)
    {
        $item = Item::with('mutations')->findOrFail($id);
        return response()->json(['status' => 'success', 'data' => $item]);
    }

    public function store(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'kode_barang' => 'required|string|max:20|unique:items,kode_barang',
            'nama_barang' => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string|max:20',
            'kondisi' => 'required|string',
            'lokasi' => 'required|string|max:50',
            'tanggal_pengadaan' => 'required|date'
        ]);

        $item = Item::create($data);

        Auditlog::create([
            'nama_pelaku' => $request->user()->nama_lengkap ?? $request->user()->name,
            'role_pelaku' => 'Admin',
            'modul' => 'Manajemen Barang',
            'aksi' => 'CREATE',
            'id_record' => $item->id
        ]);

        return response()->json(['status' => 'success', 'data' => $item], 201);
    }

    public function update(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $item = Item::findOrFail($id);
        
        $data = $request->validate([
            'nama_barang' => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'satuan' => 'required|string|max:20',
            'kondisi' => 'required|string',
            'lokasi' => 'required|string|max:50',
            'tanggal_pengadaan' => 'required|date'
        ]);

        $item->update($data);

        Auditlog::create([
            'nama_pelaku' => $request->user()->nama_lengkap ?? $request->user()->name,
            'role_pelaku' => 'Admin',
            'modul' => 'Manajemen Barang',
            'aksi' => 'UPDATE',
            'id_record' => $item->id
        ]);

        return response()->json(['status' => 'success', 'data' => $item]);
    }

    public function mutate(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $item = Item::findOrFail($id);
        
        $request->validate([
            'tipe_mutasi' => 'required|in:masuk,keluar,penyesuaian',
            'jumlah' => 'required|integer|min:1',
            'keterangan' => 'nullable|string'
        ]);

        if ($request->tipe_mutasi == 'keluar' && $item->stok < $request->jumlah) {
            return response()->json(['status' => 'error', 'message' => 'Stok tidak mencukupi'], 400);
        }

        $stok_sebelum = $item->stok;

        if ($request->tipe_mutasi == 'masuk') {
            $item->stok += $request->jumlah;
        } else if ($request->tipe_mutasi == 'keluar') {
            $item->stok -= $request->jumlah;
        } else {
            // penyesuaian (bisa menambah atau mengurangi, tapi di sini kita anggap 'jumlah' sebagai stok akhir jika penyesuaian, atau selisih. Mari kita pakai selisih absolut untuk penyesuaian).
            // Berdasarkan UI sebelumnya, tidak ada 'penyesuaian', tapi karena diminta di endpoint, kita implement.
            // Asumsi penyesuaian menyetel stok menjadi nilai 'jumlah'.
            $item->stok = $request->jumlah;
        }
        
        $item->save();

        $mutation = ItemMutation::create([
            'item_id' => $item->id,
            'tipe_mutasi' => ucfirst($request->tipe_mutasi),
            'jumlah' => $request->jumlah,
            'stok_sebelum' => $stok_sebelum,
            'stok_sesudah' => $item->stok,
            'keterangan' => $request->keterangan,
            'dilakukan_oleh' => $request->user()->id
        ]);

        Auditlog::create([
            'nama_pelaku' => $request->user()->nama_lengkap ?? $request->user()->name,
            'role_pelaku' => 'Admin',
            'modul' => 'Manajemen Barang',
            'aksi' => 'Mutasi Stok ' . ucfirst($request->tipe_mutasi),
            'id_record' => $id
        ]);

        return response()->json(['status' => 'success', 'data' => $mutation]);
    }
}
