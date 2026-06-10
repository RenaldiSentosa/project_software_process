<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang', 20)->unique();
            $table->string('nama_barang', 100);
            $table->string('kategori', 50)->nullable();
            $table->text('deskripsi')->nullable();
            $table->integer('stok')->default(0);
            $table->string('satuan', 20)->nullable();
            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat', 'Tidak Layak'])->default('Baik');
            $table->string('lokasi', 50)->nullable();
            $table->date('tanggal_pengadaan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
