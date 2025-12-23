<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rapor extends Model
{
    protected $fillable = [
        'ad',
        'tip',
        'baslangic_tarihi',
        'bitis_tarihi',
        'parametreler',
        'user_id',
        'aciklama',
    ];

    protected $casts = [
        'baslangic_tarihi' => 'date',
        'bitis_tarihi' => 'date',
        'parametreler' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
