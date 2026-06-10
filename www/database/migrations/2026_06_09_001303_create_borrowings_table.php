<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('tgl_pengajuan')->useCurrent();
            $table->date('tgl_rencana_pinjam');
            $table->date('tgl_rencana_kembali');
            $table->text('keperluan');
            $table->enum('status', ['Menunggu', 'Disetujui', 'Ditolak', 'Dipinjam', 'Dikembalikan', 'Selesai'])->default('Menunggu'); 
            $table->foreignId('diproses_oleh')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('tgl_diproses')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->dateTime('tgl_pengembalian_aktual')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('status');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
