<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TindakLanjut extends Model
{
    protected $table = 'tindaklanjut';

    protected $primaryKey = 'id_tindak';

    protected $fillable = [
        'id_pengaduan', 'id_user', 'tanggal_tindak', 'catatan', 'status_akhir', 'foto'
    ];

    // Relasi ke Pengaduan
    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'id_pengaduan');
    }

    // Relasi ke Petugas
    public function petugas()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
