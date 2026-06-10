<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->timestamp('timestamp')->useCurrent();
            $table->unsignedBigInteger('dilakukan_oleh')->nullable(); // Sesuai SRS: Tidak ada constraint FK
            $table->string('nama_pelaku')->nullable();
            $table->enum('role_pelaku', ['Admin', 'Mahasiswa', 'System'])->nullable();
            $table->string('modul', 50);
            $table->string('aksi', 100);
            $table->string('id_record', 50)->nullable();
            $table->json('data_sebelum')->nullable();
            $table->json('data_sesudah')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};
