<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengaduanPetugas extends Model
{
    use HasFactory;

    protected $table = 'pengaduan_petugas';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_pengaduan',
        'id_user',
        'role_petugas',
        'status_penanganan',
        'assigned_at',
        'unassigned_at'
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'unassigned_at' => 'datetime'
    ];

    // Relasi ke Pengaduan
    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class, 'id_pengaduan', 'id_pengaduan');
    }

    // Relasi ke User (Admin/Petugas)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // Scope untuk petugas yang aktif
    public function scopeAktif($query)
    {
        return $query->where('status_penanganan', 'aktif');
    }

    // Scope untuk role tertentu
    public function scopeRole($query, $role)
    {
        return $query->where('role_petugas', $role);
    }
}
