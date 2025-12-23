<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Yetki extends Model
{
    protected $fillable = [
        'ad',
        'slug',
        'aciklama',
        'modul',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function roller()
    {
        return $this->belongsToMany(Rol::class, 'rol_yetki');
    }
}
