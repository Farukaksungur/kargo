<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fatura extends Model
{
    protected $fillable = [
        'fatura_no',
        'tip',
        'tarih',
        'vade_tarihi',
        'marka_id',
        'musteri_id',
        'kargo_id',
        'ara_toplam',
        'kdv_orani',
        'kdv_tutari',
        'genel_toplam',
        'durum',
        'odeme_yontemi',
        'notlar',
        'urunler',
        'aktif',
    ];

    protected $casts = [
        'tarih' => 'date',
        'vade_tarihi' => 'date',
        'ara_toplam' => 'decimal:2',
        'kdv_orani' => 'decimal:2',
        'kdv_tutari' => 'decimal:2',
        'genel_toplam' => 'decimal:2',
        'urunler' => 'array',
        'aktif' => 'boolean',
    ];

    const TIP_SATIS = 'satis';
    const TIP_ALIS = 'alis';
    const TIP_IADE = 'iade';

    const DURUM_BEKLEMEDE = 'beklemede';
    const DURUM_ODENDI = 'odendi';
    const DURUM_IPTAL = 'iptal';

    public function marka()
    {
        return $this->belongsTo(Marka::class);
    }

    public function musteri()
    {
        return $this->belongsTo(Musteri::class);
    }

    public function kargo()
    {
        return $this->belongsTo(Kargo::class);
    }
}
