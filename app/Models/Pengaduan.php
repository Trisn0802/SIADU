<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Pengaduan extends Model
{
    protected $table = 'pengaduan';
    protected $primaryKey = 'id_pengaduan';
    protected $fillable = [
        'id_user', 'judul', 'deskripsi', 'kategori', 'foto', 'lokasi', 'tanggal_lapor', 'status', 'assigned_petugas'
    ];

    // Relasi ke User (pengadu)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Relasi ke User (petugas yang ditugaskan)
    public function assignedPetugas()
    {
        return $this->belongsTo(User::class, 'assigned_petugas', 'id_user');
    }

    // Relasi many-to-many ke petugas/admin yang menangani
    public function petugasPenanganan()
    {
        return $this->belongsToMany(User::class, 'pengaduan_petugas', 'id_pengaduan', 'id_user')
                    ->withPivot('role_petugas', 'status_penanganan', 'assigned_at')
                    ->withTimestamps();
    }

    // Relasi ke PengaduanPetugas
    public function pengaduanPetugas()
    {
        return $this->hasMany(PengaduanPetugas::class, 'id_pengaduan', 'id_pengaduan');
    }

    // Relasi ke TindakLanjut
    public function tindakLanjut()
    {
        return $this->hasOne(TindakLanjut::class, 'id_pengaduan');
    }

    // Method untuk mendapatkan petugas yang aktif menangani
    public function getPetugasAktif()
    {
        return $this->pengaduanPetugas()->aktif()->with('user')->get();
    }

    // Method untuk menugaskan petugas
    public function assignPetugas($userId, $role = 'petugas')
    {
        // Cek apakah sudah pernah ada assignment (aktif atau nonaktif)
        $existing = $this->pengaduanPetugas()
                        ->where('id_user', $userId)
                        ->first();

        if ($existing) {
            // Jika sudah ada, update role/status dan kembalikan record
            $existing->update([
                'role_petugas' => $role,
                'status_penanganan' => 'aktif',
                'assigned_at' => now(),
                'unassigned_at' => null,
            ]);

            return $existing->fresh();
        }

        // Jika belum ada sama sekali, buat record baru
        return $this->pengaduanPetugas()->create([
            'id_user' => $userId,
            'role_petugas' => $role,
            'status_penanganan' => 'aktif',
            'assigned_at' => now()
        ]);
    }

    // Method untuk unassign petugas
    public function unassignPetugas($userId)
    {
        return $this->pengaduanPetugas()
                    ->where('id_user', $userId)
                    ->where('status_penanganan', 'aktif')
                    ->update([
                        'status_penanganan' => 'nonaktif',
                        'unassigned_at' => now()
                    ]);
    }
}
