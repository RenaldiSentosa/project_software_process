<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Borrowing;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Group for v1 API
Route::prefix('v1')->group(function () {
    
    // N8N Webhook Endpoint (Protected by simple API Key)
    Route::middleware([\App\Http\Middleware\N8NApiKeyMiddleware::class])->group(function () {
        Route::get('/borrowings/overdue', function () {
            $overdueBorrowings = Borrowing::with('mahasiswa', 'items.tool')
                ->where('status', 'Dipinjam')
                ->whereDate('tgl_rencana_kembali', '<', now()->toDateString())
                ->get();
                
            return response()->json([
                'status' => 'success',
                'data' => $overdueBorrowings
            ]);
        });
    });

    // =========================================================================
    // MODUL AUTENTIKASI (PUBLIC)
    // =========================================================================
    Route::post('/auth/register', [\App\Http\Controllers\Api\ApiAuthController::class, 'register']);
    Route::post('/auth/login', [\App\Http\Controllers\Api\ApiAuthController::class, 'login']);

    // =========================================================================
    // MODUL AUTENTIKASI (PROTECTED BY SANCTUM)
    // =========================================================================
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/auth/logout', [\App\Http\Controllers\Api\ApiAuthController::class, 'logout']);
        Route::get('/auth/me', [\App\Http\Controllers\Api\ApiAuthController::class, 'me']);
    });

    // =========================================================================
    // MODUL LAINNYA (PROTECTED BY SANCTUM)
    // =========================================================================
    Route::middleware('auth:sanctum')->group(function () {
        // 8.3 Endpoint Manajemen Alat
        Route::get('/tools', [\App\Http\Controllers\Api\ApiToolController::class, 'index']);
        Route::get('/tools/{id}', [\App\Http\Controllers\Api\ApiToolController::class, 'show']);
        Route::post('/tools', [\App\Http\Controllers\Api\ApiToolController::class, 'store']);
        Route::put('/tools/{id}', [\App\Http\Controllers\Api\ApiToolController::class, 'update']);
        Route::delete('/tools/{id}', [\App\Http\Controllers\Api\ApiToolController::class, 'destroy']);

        // 8.4 Endpoint Peminjaman
        Route::get('/borrowings', [\App\Http\Controllers\Api\ApiBorrowingController::class, 'index']);
        Route::get('/borrowings/my', [\App\Http\Controllers\Api\ApiBorrowingController::class, 'myBorrowings']);
        Route::get('/borrowings/{id}', [\App\Http\Controllers\Api\ApiBorrowingController::class, 'show']);
        Route::post('/borrowings', [\App\Http\Controllers\Api\ApiBorrowingController::class, 'store']);
        Route::patch('/borrowings/{id}/approve', [\App\Http\Controllers\Api\ApiBorrowingController::class, 'approve']);
        Route::patch('/borrowings/{id}/reject', [\App\Http\Controllers\Api\ApiBorrowingController::class, 'reject']);
        Route::patch('/borrowings/{id}/return', [\App\Http\Controllers\Api\ApiBorrowingController::class, 'returnBorrowing']);

        // 8.5 Endpoint Inventaris Barang
        Route::get('/items', [\App\Http\Controllers\Api\ApiItemController::class, 'index']);
        Route::get('/items/{id}', [\App\Http\Controllers\Api\ApiItemController::class, 'show']);
        Route::post('/items', [\App\Http\Controllers\Api\ApiItemController::class, 'store']);
        Route::put('/items/{id}', [\App\Http\Controllers\Api\ApiItemController::class, 'update']);
        Route::post('/items/{id}/mutate', [\App\Http\Controllers\Api\ApiItemController::class, 'mutate']);

        // 8.6 Endpoint Laporan & Audit
        Route::get('/reports/borrowings', [\App\Http\Controllers\Api\ApiReportController::class, 'borrowings']);
        Route::get('/reports/items', [\App\Http\Controllers\Api\ApiReportController::class, 'items']);
        Route::get('/audit-logs', [\App\Http\Controllers\Api\ApiReportController::class, 'auditLogs']);
    });
});
