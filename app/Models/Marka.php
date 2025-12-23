<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marka extends Model
{
    protected $fillable = [
        'ad',
        'firma_adi',
        'telefon',
        'email',
        'adres',
        'toplam_borc',
        'odenen_tutar',
        'notlar',
        'aktif',
    ];

    protected $casts = [
        'toplam_borc' => 'decimal:2',
        'odenen_tutar' => 'decimal:2',
        'kalan_tutar' => 'decimal:2',
        'aktif' => 'boolean',
    ];

    /**
     * Kalan tutarı otomatik hesapla
     */
    public static function boot()
    {
        parent::boot();

        static::saving(function ($marka) {
            if (isset($marka->toplam_borc) && isset($marka->odenen_tutar)) {
                $marka->kalan_tutar = $marka->toplam_borc - $marka->odenen_tutar;
            }
        });
    }

    /**
     * Kargolar ilişkisi
     */
    public function kargolar()
    {
        return $this->hasMany(Kargo::class);
    }

    /**
     * Ödemeler ilişkisi
     */
    public function odemeler()
    {
        return $this->hasMany(Odeme::class);
    }
}
