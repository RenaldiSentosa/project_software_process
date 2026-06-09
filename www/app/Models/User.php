<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// Ganti properti fillable di sini sesuai kolom database DBeaver kita bang
#[Fillable([
    'nama_lengkap', 
    'nim', 
    'email', 
    'password', 
    'role', 
    'program_studi', 
    'is_active',
    'foto_profil' // ← tambahan baru untuk menyimpan path foto profil di database
])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed', // Password otomatis di-hash dengan aman oleh Laravel
        ];
    }

    // Relasi ke Peminjaman
    public function borrowings()
    {
        return $this->hasMany(Borrowing::class, 'mahasiswa_id');
    }
}