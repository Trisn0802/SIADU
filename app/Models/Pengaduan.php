<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Pengaduan extends Model
{
    protected $table = 'pengaduan';
    protected $primaryKey = 'id_pengaduan';
    protected $fillable = [
        'id_user', 'judul', 'deskripsi', 'kategori', 'foto', 'lokasi', 'tanggal_lapor', 'status'
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relasi ke TindakLanjut
    public function tindakLanjut()
    {
        return $this->hasOne(TindakLanjut::class, 'id_pengaduan');
    }
}
