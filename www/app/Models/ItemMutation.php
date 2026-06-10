<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemMutation extends Model
{
    use HasFactory;

    protected $table = 'item_mutations';
    
    public $timestamps = false; // Kita handle created_at manual / via DB default

    protected $fillable = [
        'item_id', 'tipe_mutasi', 'jumlah', 'stok_sebelum', 'stok_sesudah', 'keterangan', 'dilakukan_oleh', 'created_at'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function penanggungJawab()
    {
        return $this->belongsTo(User::class, 'dilakukan_oleh');
    }
}