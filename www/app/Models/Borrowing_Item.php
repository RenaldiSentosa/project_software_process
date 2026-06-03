<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// KUNCI UTAMA: Nama class wajib pakai underscore (Borrowing_Item) agar klop dengan nama file
class Borrowing_Item extends Model
{
    use HasFactory;

    protected $table = 'borrowing_items';

    public $timestamps = false; 

    protected $fillable = [
        'borrowing_id', 
        'tool_id', 
        'jumlah_unit', 
        'kondisi_saat_kembali', 
        'catatan_pengembalian', 
        'created_at'
    ];

    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class, 'borrowing_id');
    }

    public function tool()
    {
        return $this->belongsTo(Tool::class, 'tool_id');
    }
}