<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $table = 'chat';
    protected $primaryKey = 'id_chat';
    protected $fillable = [
        'id_pengaduan', 'id_user', 'pesan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
