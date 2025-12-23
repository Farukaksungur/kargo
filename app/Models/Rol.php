<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $fillable = [
        'ad',
        'aciklama',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function yetkiler()
    {
        return $this->belongsToMany(Yetki::class, 'rol_yetki');
    }

    public function kullanicilar()
    {
        return $this->hasMany(User::class);
    }
}
