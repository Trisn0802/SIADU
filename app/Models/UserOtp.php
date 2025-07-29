<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class UserOtp extends Model
{
    use HasFactory;

    protected $table = 'user_otps';
    protected $fillable = [
        'id_user', 'otp_code', 'type', 'is_verified', 'expired_at'
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'expired_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function isExpired()
    {
        return $this->expired_at < Carbon::now();
    }

    public static function generateOtp($id_user, $type = 'login', $expireMinutes = 5)
    {
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        return self::create([
            'id_user' => $id_user,
            'otp_code' => $otp,
            'type' => $type,
            'is_verified' => false,
            'expired_at' => now()->addMinutes($expireMinutes),
        ]);
    }
}
