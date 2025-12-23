<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IslemLogu extends Model
{
    protected $fillable = [
        'user_id',
        'islem_tipi',
        'modul',
        'tablo',
        'kayit_id',
        'aciklama',
        'ip_adresi',
        'eski_deger',
        'yeni_deger',
    ];

    protected $casts = [
        'eski_deger' => 'array',
        'yeni_deger' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
