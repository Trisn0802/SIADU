<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PassDebug extends Model
{
    protected $table = 'passwd_debug';
    protected $primaryKey = 'id_passwd';
    protected $fillable = [
        'passDebug',
    ];
}
