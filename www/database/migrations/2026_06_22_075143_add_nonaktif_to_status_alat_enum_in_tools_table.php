<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Menambahkan nilai 'Nonaktif' ke kolom enum status_alat pada tabel tools.
     * Laravel/Eloquent tidak punya cara native untuk ALTER COLUMN enum,
     * jadi kita pakai raw SQL.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE tools MODIFY COLUMN status_alat ENUM('Tersedia', 'Dipinjam', 'Rusak', 'Dalam Perbaikan', 'Nonaktif') NOT NULL DEFAULT 'Tersedia'");
    }

    /**
     * Reverse the migrations.
     *
     * PERHATIAN: kalau ada baris yang sudah berstatus 'Nonaktif' saat rollback,
     * baris itu akan gagal di-set balik (karena 'Nonaktif' sudah tidak ada di enum).
     * Pastikan tidak ada data 'Nonaktif' sebelum rollback, atau ubah dulu manual.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE tools MODIFY COLUMN status_alat ENUM('Tersedia', 'Dipinjam', 'Rusak', 'Dalam Perbaikan') NOT NULL DEFAULT 'Tersedia'");
    }
};