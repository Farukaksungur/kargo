<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Musteri extends Model
{
    protected $fillable = [
        'ad',
        'soyad',
        'telefon',
        'email',
        'il',
        'ilce',
        'adres',
        'notlar',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    /**
     * Kargolar ilişkisi
     */
    public function kargolar()
    {
        return $this->hasMany(Kargo::class);
    }

    /**
     * Toplam ürün sayısı
     */
    public function getToplamUrunSayisiAttribute()
    {
        return $this->kargolar()->count();
    }

    /**
     * Toplam harcama
     */
    public function getToplamHarcamaAttribute()
    {
        return $this->kargolar()->sum('tutar') + $this->kargolar()->sum('kargo_ucreti');
    }
}
