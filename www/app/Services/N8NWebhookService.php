<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Borrowing;

class N8NWebhookService
{
    /**
     * Send webhook to N8N for borrowing events.
     *
     * @param string $event
     * @param Borrowing $borrowing
     * @return void
     */
    public static function sendBorrowingEvent(string $event, Borrowing $borrowing)
    {
        $webhookUrl = env('N8N_WEBHOOK_URL');

        if (empty($webhookUrl)) {
            Log::info("N8N_WEBHOOK_URL is not set. Skipping webhook for event: {$event}");
            return;
        }

        try {
            // Get first tool info for simplicity, or handle multiple
            $firstItem = $borrowing->items()->first();
            $toolName = $firstItem && $firstItem->tool ? $firstItem->tool->nama_alat : 'Multiple Tools';
            $toolCode = $firstItem && $firstItem->tool ? $firstItem->tool->kode_alat : '-';

            $payload = [
                'event' => $event,
                'borrowing_id' => $borrowing->id,
                'student_name' => $borrowing->mahasiswa->nama_lengkap ?? $borrowing->mahasiswa->name ?? 'Unknown',
                'student_email' => $borrowing->mahasiswa->email ?? '',
                'tool_name' => $toolName,
                'tool_code' => $toolCode,
                'borrow_date' => $borrowing->tgl_rencana_pinjam,
                'return_date' => $borrowing->tgl_rencana_kembali,
                'admin_note' => $borrowing->catatan_admin,
                'target_email' => $borrowing->mahasiswa->email ?? 'gozzzgas@gmail.com',
                'timestamp' => now()->toIso8601String()
            ];

            // Fire and forget
            Http::timeout(3)->post($webhookUrl, $payload);
        } catch (\Exception $e) {
            Log::error("Failed to send N8N webhook: " . $e->getMessage());
        }
    }
}
