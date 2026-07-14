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
                'password' => bcrypt('admin123'),
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
                    'password' => bcrypt('password123'),
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


        }
    }
}
