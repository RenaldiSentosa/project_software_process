<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tool extends Model
{
    use HasFactory;

    // Karena nama tabelnya jamak tapi bukan standar bahasa inggris Laravel (tools)
    protected $table = 'tools';

    protected $fillable = [
        'kode_alat', 'nama_alat', 'kategori', 'deskripsi', 
        'stok_total', 'stok_tersedia', 'status_alat', 'lokasi', 'foto_alat'
    ];

    public function borrowingItems()
{
    return $this->hasMany('App\Models\Borrowing_Item', 'tool_id');
}

}