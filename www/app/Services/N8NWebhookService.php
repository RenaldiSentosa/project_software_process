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
            // 1. Kumpulkan semua alat
            $items = $borrowing->items()->with('tool')->get();
            
            $toolNamesArray = [];
            $htmlTableRows = "";

            foreach ($items as $item) {
                $nama = $item->tool ? $item->tool->nama_alat : 'Alat tidak diketahui';
                $qty = $item->jumlah_unit;
                
                $toolNamesArray[] = "{$qty}x {$nama}";
                
                $htmlTableRows .= "
                    <tr>
                        <td style='padding: 12px 15px; border-bottom: 1px solid #e2e8f0; color: #1e293b; font-size: 14px;'>{$nama}</td>
                        <td style='padding: 12px 15px; border-bottom: 1px solid #e2e8f0; color: #1e293b; font-size: 14px; text-align: center; font-weight: bold;'>{$qty}</td>
                    </tr>
                ";
            }

            $toolName = implode(", ", $toolNamesArray);
            
            // Format Tanggal
            $tglPinjam = \Carbon\Carbon::parse($borrowing->tgl_rencana_pinjam)->translatedFormat('d F Y');
            $tglKembali = \Carbon\Carbon::parse($borrowing->tgl_rencana_kembali)->translatedFormat('d F Y');
            $mahasiswaName = $borrowing->mahasiswa->nama_lengkap ?? $borrowing->mahasiswa->name ?? 'Unknown';
            $statusLabel = strtoupper($borrowing->status);

            // Warna berdasarkan event/status
            $color = '#3b82f6'; // default blue (submitted)
            $rgbaColor = 'rgba(59, 130, 246, 0.1)';
            if ($event === 'borrowing.approved') {
                $color = '#10b981'; // green
                $rgbaColor = 'rgba(16, 185, 129, 0.1)';
            }
            if ($event === 'borrowing.rejected' || $event === 'borrowing.overdue') {
                $color = '#ef4444'; // red
                $rgbaColor = 'rgba(239, 68, 68, 0.1)';
            }

            // 2. Buat Template Email HTML yang sangat menarik & responsif
            $adminNoteHtml = '';
            if (!empty($borrowing->catatan_admin)) {
                $noteColor = ($event === 'borrowing.rejected' || $event === 'borrowing.overdue') ? '#fef2f2' : '#fffbeb';
                $noteBorderColor = ($event === 'borrowing.rejected' || $event === 'borrowing.overdue') ? '#ef4444' : '#f59e0b';
                $noteTitleColor = ($event === 'borrowing.rejected' || $event === 'borrowing.overdue') ? '#991b1b' : '#92400e';
                $noteTextColor = ($event === 'borrowing.rejected' || $event === 'borrowing.overdue') ? '#b91c1c' : '#b45309';

                $adminNoteHtml = "
                <div style='background-color: {$noteColor}; border-left: 4px solid {$noteBorderColor}; padding: 16px 20px; margin-bottom: 25px; border-radius: 4px 8px 8px 4px;'>
                    <p style='margin: 0 0 6px 0; color: {$noteTitleColor}; font-size: 14px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;'>Catatan Admin</p>
                    <p style='margin: 0; color: {$noteTextColor}; font-size: 15px; line-height: 1.6;'>{$borrowing->catatan_admin}</p>
                </div>
                ";
            }

            $emailBodyHtml = "
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset='utf-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            </head>
            <body style='margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, \"Segoe UI\", Roboto, Helvetica, Arial, sans-serif; background-color: #f3f4f6;'>
                <table width='100%' border='0' cellspacing='0' cellpadding='0' style='background-color: #f3f4f6; padding: 40px 20px;'>
                    <tr>
                        <td align='center'>
                            <table width='100%' max-width='600' border='0' cellspacing='0' cellpadding='0' style='max-width: 600px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.05); margin: 0 auto;'>
                                
                                <!-- Header -->
                                <tr>
                                    <td align='center' style='background: linear-gradient(135deg, {$color} 0%, " . ($event === 'borrowing.approved' ? '#059669' : (($event === 'borrowing.rejected' || $event === 'borrowing.overdue') ? '#dc2626' : '#2563eb')) . " 100%); padding: 40px 30px;'>
                                        <h1 style='color: #ffffff; margin: 0; font-size: 28px; font-weight: 800; letter-spacing: -0.5px;'>IPWIJA SmartLab</h1>
                                        <p style='color: rgba(255,255,255,0.9); margin: 10px 0 0 0; font-size: 16px; font-weight: 500;'>Notifikasi Sistem Peminjaman</p>
                                    </td>
                                </tr>

                                <!-- Body -->
                                <tr>
                                    <td style='padding: 40px 40px 30px 40px;'>
                                        <p style='margin: 0 0 24px 0; color: #374151; font-size: 16px; line-height: 1.6;'>
                                            Halo <strong style='color: #111827;'>{$mahasiswaName}</strong>,<br><br>
                                            Terdapat pembaruan pada status permintaan peminjaman alat laboratorium Anda. Berikut adalah rinciannya:
                                        </p>

                                        <!-- Status Card -->
                                        <div style='background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; margin-bottom: 25px;'>
                                            <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                                <tr>
                                                    <td style='padding: 0 0 12px 0; border-bottom: 1px solid #e2e8f0;'>
                                                        <span style='color: #64748b; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;'>ID Peminjaman</span><br>
                                                        <span style='color: #0f172a; font-size: 16px; font-weight: 700; display: inline-block; margin-top: 4px;'>PMJ-" . str_pad($borrowing->id, 3, '0', STR_PAD_LEFT) . "</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='padding: 12px 0; border-bottom: 1px solid #e2e8f0;'>
                                                        <span style='color: #64748b; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;'>Status Saat Ini</span><br>
                                                        <span style='color: {$color}; font-size: 16px; font-weight: 800; display: inline-block; margin-top: 4px; padding: 4px 12px; background-color: {$rgbaColor}; border-radius: 20px;'>{$statusLabel}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='padding: 12px 0 0 0;'>
                                                        <table width='100%' border='0' cellspacing='0' cellpadding='0'>
                                                            <tr>
                                                                <td width='50%'>
                                                                    <span style='color: #64748b; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;'>Tgl Pinjam</span><br>
                                                                    <span style='color: #0f172a; font-size: 15px; font-weight: 600; display: inline-block; margin-top: 4px;'>{$tglPinjam}</span>
                                                                </td>
                                                                <td width='50%'>
                                                                    <span style='color: #64748b; font-size: 13px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;'>Tgl Kembali</span><br>
                                                                    <span style='color: #0f172a; font-size: 15px; font-weight: 600; display: inline-block; margin-top: 4px;'>{$tglKembali}</span>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>

                                        {$adminNoteHtml}

                                        <h3 style='margin: 0 0 16px 0; color: #111827; font-size: 18px; font-weight: 700;'>Daftar Alat:</h3>
                                        <table width='100%' border='0' cellspacing='0' cellpadding='0' style='margin-bottom: 30px; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden;'>
                                            <thead>
                                                <tr>
                                                    <th style='background-color: #f1f5f9; color: #475569; padding: 14px 20px; text-align: left; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #e2e8f0;'>Nama Alat</th>
                                                    <th style='background-color: #f1f5f9; color: #475569; padding: 14px 20px; text-align: center; font-size: 13px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 1px solid #e2e8f0; width: 80px;'>Qty</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {$htmlTableRows}
                                            </tbody>
                                        </table>

                                        <div style='text-align: center; margin-top: 40px;'>
                                            <a href='" . url('/') . "' style='display: inline-block; background-color: #111827; color: #ffffff; text-decoration: none; padding: 14px 32px; border-radius: 8px; font-weight: 600; font-size: 16px; transition: background-color 0.2s;'>Buka Dashboard</a>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Footer -->
                                <tr>
                                    <td style='background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 30px 40px; text-align: center;'>
                                        <p style='margin: 0; color: #64748b; font-size: 13px; line-height: 1.6;'>
                                            Ini adalah pesan otomatis dari sistem <strong>IPWIJA SmartLab</strong>.<br>
                                            Mohon tidak membalas email ini.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </body>
            </html>
            ";

            $payload = [
                'event' => $event,
                'borrowing_id' => $borrowing->id,
                'student_name' => $mahasiswaName,
                'student_email' => $borrowing->mahasiswa->email ?? '',
                'tool_name' => $toolName,
                'borrow_date' => $borrowing->tgl_rencana_pinjam,
                'return_date' => $borrowing->tgl_rencana_kembali,
                'admin_note' => $borrowing->catatan_admin,
                'target_email' => $borrowing->mahasiswa->email ?? 'gozzzgas@gmail.com',
                'timestamp' => now()->toIso8601String(),
                
                // Variabel khusus HTML
                'email_body_html' => $emailBodyHtml
            ];

            // Fire and forget
            Http::timeout(3)->post($webhookUrl, $payload);
        } catch (\Exception $e) {
            Log::error("Failed to send N8N webhook: " . $e->getMessage());
        }
    }
}
