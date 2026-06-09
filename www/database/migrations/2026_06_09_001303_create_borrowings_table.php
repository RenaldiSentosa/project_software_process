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
            $table->date('tgl_pengajuan');
            $table->date('tgl_rencana_pinjam');
            $table->date('tgl_rencana_kembali');
            $table->text('keperluan')->nullable();
            $table->string('status')->default('Menunggu'); 
            $table->foreignId('diproses_oleh')->nullable()->constrained('users')->onDelete('set null');
            $table->dateTime('tgl_diproses')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->date('tgl_pengembalian_aktual')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
