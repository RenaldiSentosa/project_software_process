<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';

    protected $fillable = [
        'kode_barang', 'nama_barang', 'kategori', 'deskripsi', 
        'stok', 'satuan', 'kondisi', 'lokasi', 'tanggal_pengadaan'
    ];

    // Relasi: 1 Barang bisa punya banyak history mutasi stok
    public function mutations()
    {
        return $this->hasMany(ItemMutation::class, 'item_id');
    }
}