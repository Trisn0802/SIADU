<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'id_user';
    protected $fillable = [
        'nama', 'nik', 'email', 'instansi', 'role', 'status', 'password', 'no_hp', 'foto', 'remember_token', 'otp_verified', 'uuid', 'reset_token', 'reset_token_expires_at'
    ];

    protected $casts = [
        'otp_verified' => 'boolean',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Boot method untuk auto-generate UUID saat user dibuat
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = \Illuminate\Support\Str::uuid();
            }
        });
    }

    // Relasi ke Pengaduan
    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'id_user');
    }
}
