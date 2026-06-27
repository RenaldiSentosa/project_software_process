<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = \App\Models\User::updateOrCreate(
            ['email' => 'dummyadmin@ipwija.ac.id'],
            [
                'nama_lengkap' => 'Admin SmartLab',
                'nim' => 'dummyadmin',
                'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        for ($i = 1; $i <= 10; $i++) {
            $nim = '1234567890' . str_pad($i, 2, '0', STR_PAD_LEFT);
            
            // 1. User Dummy
            $user = \App\Models\User::updateOrCreate(
                ['email' => "dummymhs{$i}@ipwija.ac.id"],
                [
                    'nama_lengkap' => "Dummy Mahasiswa $i",
                    'nim' => $nim,
                    'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                    'role' => 'mahasiswa',
                    'program_studi' => 'Teknik Informatika',
                    'is_active' => true,
                ]
            );

            // 2. Mahasiswa Dummy (opsional, apabila dibutuhkan oleh sistem yang terpisah dari User)
            \App\Models\Mahasiswa::updateOrCreate(
                ['nim' => $nim],
                ['nama' => "Dummy Mahasiswa $i"]
            );

            // 3. Tool Dummy
            $kode_alat = 'AL-' . str_pad($i, 3, '0', STR_PAD_LEFT);
            $tool = \App\Models\Tool::updateOrCreate(
                ['kode_alat' => $kode_alat],
                [
                    'nama_alat' => "Alat Praktikum $i",
                    'kategori' => 'Alat Optik',
                    'deskripsi' => "Deskripsi untuk Alat Praktikum $i.",
                    'stok_total' => 10,
                    'stok_tersedia' => 10,
                    'status_alat' => 'Tersedia',
                    'lokasi' => 'Lab Biologi Dasar',
                ]
            );

            // 4. Item Dummy (Barang Habis Pakai / Inventaris Umum)
            $kode_barang = 'BR-' . str_pad($i, 3, '0', STR_PAD_LEFT);
            $item = \App\Models\Item::updateOrCreate(
                ['kode_barang' => $kode_barang],
                [
                    'nama_barang' => "Barang Inventaris $i",
                    'kategori' => 'Networking',
                    'deskripsi' => "Deskripsi barang inventaris $i.",
                    'stok' => 50,
                    'stok_minimum' => 10,
                    'satuan' => 'Meter',
                    'kondisi' => 'Baik',
                    'lokasi' => 'Gudang Lab Komputer',
                    'tanggal_pengadaan' => now(),
                ]
            );

            // 5. ItemMutation Dummy
            \App\Models\ItemMutation::updateOrCreate(
                ['item_id' => $item->id, 'keterangan' => "Pengadaan barang awal $i"],
                [
                    'tipe_mutasi' => 'Masuk',
                    'jumlah' => 50,
                    'stok_sebelum' => 0,
                    'stok_sesudah' => 50,
                    'dilakukan_oleh' => $admin->id,
                ]
            );

            // 6. Borrowing (Peminjaman) Dummy
            $borrowing = \App\Models\Borrowing::updateOrCreate(
                ['mahasiswa_id' => $user->id, 'keperluan' => "Praktikum Jaringan Komputer Lanjut $i"],
                [
                    'tgl_pengajuan' => now(),
                    'tgl_rencana_pinjam' => now()->addDays(1),
                    'tgl_rencana_kembali' => now()->addDays(3),
                    'status' => 'Disetujui',
                    'diproses_oleh' => $admin->id,
                    'tgl_diproses' => now(),
                ]
            );

            // 7. Borrowing_Item Dummy
            \App\Models\Borrowing_Item::updateOrCreate(
                ['borrowing_id' => $borrowing->id, 'tool_id' => $tool->id],
                [
                    'jumlah_unit' => 1,
                    'kondisi_saat_kembali' => null,
                    'catatan_pengembalian' => null,
                ]
            );

            // 8. Auditlog Dummy
            \App\Models\Auditlog::updateOrCreate(
                ['id_record' => $tool->id, 'aksi' => 'Create', 'modul' => 'Tools'],
                [
                    'timestamp' => now(),
                    'dilakukan_oleh' => $admin->id,
                    'nama_pelaku' => $admin->nama_lengkap,
                    'role_pelaku' => $admin->role,
                    'data_sebelum' => [],
                    'data_sesudah' => $tool->toArray(),
                    'ip_address' => '127.0.0.1',
                ]
            );
        }
    }
}
