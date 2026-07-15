<?php

namespace Database\Seeders;

use App\Models\User;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Akun Admin
        User::updateOrCreate(
            ['email' => 'admin@ipwija.ac.id'],
            [
                'nama_lengkap'  => 'Sandy Aryadi',
                'name'           => 'Admin',
                'nim'           => 'admin',
                'password'      => bcrypt('password'),
                'role'          => 'admin',
                'program_studi' => null,
                'is_active'     => 1,
            ]
        );

        // 2. Akun Mahasiswa
        User::updateOrCreate(
            ['email' => 'mahasiswa@ipwija.ac.id'],
            [
                'nama_lengkap'  => 'Renaldi Sentosa',
                'name'           => 'Mahasiswa',
                'nim'           => '202301110011',
                'password'      => bcrypt('password'),
                'role'          => 'mahasiswa',
                'program_studi' => 'Teknik Informatika',
                'is_active'     => 1,
            ]
        );

        // 3. Akun Dosen
        User::updateOrCreate(
            ['email' => 'dosen@ipwija.ac.id'],
            [
                'nama_lengkap'  => 'Dr. Hermawan, M.T.',
                'name'           => 'Dosen',
                'nim'           => '198701012',
                'password'      => bcrypt('password'),
                'role'          => 'mahasiswa',
                'program_studi' => 'Teknik Informatika',
                'is_active'     => 1,
            ]
        );



        // Data alat kini menggunakan dump SQL (data_alat.sql) dan bukan seeder lagi.

        // Memanggil DummySeeder untuk mengisi tabel lainnya agar tidak kosong
        $this->call(DummySeeder::class);
    }
}
