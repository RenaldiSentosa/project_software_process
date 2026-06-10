<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Item;
use App\Models\Auditlog;
use Illuminate\Http\Request;

class ApiReportController extends Controller
{
    public function borrowings(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $query = Borrowing::with('mahasiswa', 'borrowingItems.tool')->orderBy('created_at', 'desc');

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $reports = $query->paginate(15);
        return response()->json(['status' => 'success', 'data' => $reports]);
    }

    public function items(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $items = Item::with('mutations')->paginate(15);
        return response()->json(['status' => 'success', 'data' => $items]);
    }

    public function auditLogs(Request $request)
    {
        if ($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $query = Auditlog::orderBy('created_at', 'desc');

        if ($request->has('modul')) {
            $query->where('modul', $request->modul);
        }
        if ($request->has('aksi')) {
            $query->where('aksi', $request->aksi);
        }

        $logs = $query->paginate(20);
        return response()->json(['status' => 'success', 'data' => $logs]);
    }
}
