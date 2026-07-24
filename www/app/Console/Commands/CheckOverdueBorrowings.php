<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Models\Borrowing;
use App\Services\N8NWebhookService;
use Carbon\Carbon;

#[Signature('borrowings:check-overdue')]
#[Description('Check for overdue borrowings and send notifications via n8n')]
class CheckOverdueBorrowings extends Command
{
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        
        // Find borrowings where the return date was before today and status is still 'Dipinjam'
        $overdueBorrowings = Borrowing::where('status', 'Dipinjam')
            ->whereDate('tgl_rencana_kembali', '<', $today)
            ->get();
            
        $count = $overdueBorrowings->count();
        $this->info("Found {$count} overdue borrowings.");
        
        foreach ($overdueBorrowings as $borrowing) {
            // Create a temporary note for the email
            $originalNote = $borrowing->catatan_admin;
            $borrowing->catatan_admin = "PERINGATAN: Batas waktu pengembalian alat telah lewat dari " . Carbon::parse($borrowing->tgl_rencana_kembali)->translatedFormat('d F Y') . ". Harap segera mengembalikan alat ke laboratorium!" . ($originalNote ? " | " . $originalNote : "");
            
            // Send webhook
            N8NWebhookService::sendBorrowingEvent('borrowing.overdue', $borrowing);
            
            // Restore original note so we don't accidentally save the temporary one if DB is updated later
            $borrowing->catatan_admin = $originalNote;
            
            $this->info("Sent overdue notification for borrowing ID: {$borrowing->id}");
        }
        
        return self::SUCCESS;
    }
}
