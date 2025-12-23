<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KargoFirmasi extends Model
{
    protected $fillable = [
        'ad',
        'kod',
        'telefon',
        'email',
        'web_sitesi',
        'adres',
        'varsayilan_ucret',
        'aktif',
        'notlar',
        'api_key',
        'api_secret',
    ];

    protected $casts = [
        'varsayilan_ucret' => 'decimal:2',
        'aktif' => 'boolean',
    ];
}
