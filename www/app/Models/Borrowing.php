<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    protected $table = 'borrowings';

    protected $fillable = [
        'mahasiswa_id', 'tgl_pengajuan', 'tgl_rencana_pinjam', 'tgl_rencana_kembali',
        'keperluan', 'status', 'diproses_oleh', 'tgl_diproses', 'catatan_admin', 'tgl_pengembalian_aktual'
    ];

    // Relasi ke Mahasiswa (User)
    public function mahasiswa()
    {
        return $this->belongsTo(User::class, 'mahasiswa_id');
    }

    // Relasi ke Admin yang memproses (User)
    public function admin()
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }

    // Relasi ke Detail Item yang dipinjam
    public function items()
    {
        return $this->hasMany(Borrowing_Item::class, 'borrowing_id');
    }
}