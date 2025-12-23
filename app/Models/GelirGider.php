<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GelirGider extends Model
{
    protected $fillable = [
        'tip',
        'baslik',
        'aciklama',
        'tutar',
        'tarih',
        'kategori',
        'marka_id',
        'musteri_id',
        'kargo_id',
        'odeme_yontemi',
        'fatura_no',
        'notlar',
        'aktif',
    ];

    protected $casts = [
        'tutar' => 'decimal:2',
        'tarih' => 'date',
        'aktif' => 'boolean',
    ];

    const TIP_GELIR = 'gelir';
    const TIP_GIDER = 'gider';

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
