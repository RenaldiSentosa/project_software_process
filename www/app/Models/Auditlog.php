<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    use HasFactory;

    protected $table = 'audit_logs';
    protected $primaryKey = 'id_log'; // Sesuai dengan DB abang id_log
    public $timestamps = false;

    protected $fillable = [
        'timestamp', 'dilakukan_oleh', 'nama_pelaku', 'role_pelaku', 
        'modul', 'aksi', 'id_record', 'data_sebelum', 'data_sesudah', 'ip_address'
    ];

    // Karena data_sebelum dan data_sesudah tipenya JSON, kita cast ke array di Laravel otomatis
    protected $casts = [
        'data_sebelum' => 'array',
        'data_sesudah' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'dilakukan_oleh');
    }
}