<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tool;
use App\Models\Auditlog;
use Illuminate\Http\Request;

class ApiToolController extends Controller
{
    public function index(Request $request)
    {
        $query = Tool::query();

        if ($request->has('kategori')) {
            $query->where('kategori', $request->kategori);
        }
        if ($request->has('status_alat')) {
            $query->where('status_alat', $request->status_alat);
        }

        $tools = $query->paginate(10);
        return response()->json(['status' => 'success', 'data' => $tools]);
    }

    public function show($id)
    {
        $tool = Tool::findOrFail($id);
        return response()->json(['status' => 'success', 'data' => $tool]);
    }

    public function store(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'kode_alat' => 'required|string|max:20|unique:tools,kode_alat',
            'nama_alat' => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'stok_total' => 'required|integer|min:0',
            'status_alat' => 'required|string',
            'lokasi' => 'required|string|max:50',
        ]);

        $data['stok_tersedia'] = $data['stok_total'];
        $tool = Tool::create($data);

        Auditlog::create([
            'nama_pelaku' => $request->user()->nama_lengkap ?? $request->user()->name,
            'role_pelaku' => 'Admin',
            'modul' => 'Manajemen Alat',
            'aksi' => 'CREATE',
            'id_record' => $tool->id
        ]);

        return response()->json(['status' => 'success', 'data' => $tool], 201);
    }

    public function update(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $tool = Tool::findOrFail($id);
        
        $data = $request->validate([
            'nama_alat' => 'required|string|max:100',
            'kategori' => 'required|string|max:50',
            'deskripsi' => 'nullable|string',
            'stok_total' => 'required|integer|min:0',
            'status_alat' => 'required|string',
            'lokasi' => 'required|string|max:50',
        ]);

        $diffStok = $data['stok_total'] - $tool->stok_total;
        $data['stok_tersedia'] = $tool->stok_tersedia + $diffStok;

        $tool->update($data);

        Auditlog::create([
            'nama_pelaku' => $request->user()->nama_lengkap ?? $request->user()->name,
            'role_pelaku' => 'Admin',
            'modul' => 'Manajemen Alat',
            'aksi' => 'UPDATE',
            'id_record' => $tool->id
        ]);

        return response()->json(['status' => 'success', 'data' => $tool]);
    }

    public function destroy(Request $request, $id)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $tool = Tool::findOrFail($id);
        $tool->delete();

        Auditlog::create([
            'nama_pelaku' => $request->user()->nama_lengkap ?? $request->user()->name,
            'role_pelaku' => 'Admin',
            'modul' => 'Manajemen Alat',
            'aksi' => 'DELETE',
            'id_record' => $id
        ]);

        return response()->json(['status' => 'success', 'message' => 'Alat berhasil dihapus (soft delete)']);
    }
}
