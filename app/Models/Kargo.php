<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kargo extends Model
{
    protected $fillable = [
        'takip_no',
        'alici_ad',
        'alici_soyad',
        'alici_telefon',
        'il',
        'ilce',
        'adres',
        'urun_bilgisi',
        'tutar',
        'odeme_tutari',
        'kargo_ucreti',
        'kargo_firmasi',
        'kargo_kodu',
        'kargolanma_tarihi',
        'notlar',
        'durum',
        'marka_id',
        'musteri_id',
        'hazirlanma_tarihi',
        'yola_cikis_tarihi',
        'teslim_tarihi',
        'basitkargo_id',
        'basitkargo_barcode',
        'basitkargo_handler_code',
        'basitkargo_tracking_link',
    ];

    protected $casts = [
        'hazirlanma_tarihi' => 'datetime',
        'yola_cikis_tarihi' => 'datetime',
        'teslim_tarihi' => 'datetime',
        'kargolanma_tarihi' => 'datetime',
        'tutar' => 'decimal:2',
        'odeme_tutari' => 'decimal:2',
        'kargo_ucreti' => 'decimal:2',
    ];

    // Durum sabitleri
    const DURUM_HAZIRLANIYOR = 'hazirlaniyor';
    const DURUM_YOLDA = 'yolda';
    const DURUM_TESLIM_EDILDI = 'teslim_edildi';

    /**
     * Hazırlanan kargoları getir
     */
    public static function hazirlanan($baslangic, $bitis)
    {
        return self::where('durum', self::DURUM_HAZIRLANIYOR)
            ->where(function($query) use ($baslangic, $bitis) {
                $query->whereBetween('created_at', [$baslangic, $bitis])
                      ->orWhere(function($q) use ($baslangic, $bitis) {
                          $q->whereNotNull('hazirlanma_tarihi')
                            ->whereBetween('hazirlanma_tarihi', [$baslangic, $bitis]);
                      });
            })
            ->count();
    }

    /**
     * Yolda olan kargoları getir
     */
    public static function yolda($baslangic, $bitis)
    {
        return self::where('durum', self::DURUM_YOLDA)
            ->where(function($query) use ($baslangic, $bitis) {
                $query->where(function($q) use ($baslangic, $bitis) {
                    $q->whereNotNull('yola_cikis_tarihi')
                      ->whereBetween('yola_cikis_tarihi', [$baslangic, $bitis]);
                })->orWhere(function($q) use ($baslangic, $bitis) {
                    $q->whereNull('yola_cikis_tarihi')
                      ->whereBetween('created_at', [$baslangic, $bitis]);
                });
            })
            ->count();
    }

    /**
     * Teslim edilen kargoları getir
     */
    public static function teslimEdilen($baslangic, $bitis)
    {
        return self::where('durum', self::DURUM_TESLIM_EDILDI)
            ->whereNotNull('teslim_tarihi')
            ->whereBetween('teslim_tarihi', [$baslangic, $bitis])
            ->count();
    }

    /**
     * Marka ilişkisi
     */
    public function marka()
    {
        return $this->belongsTo(Marka::class);
    }

    /**
     * Müşteri ilişkisi
     */
    public function musteri()
    {
        return $this->belongsTo(Musteri::class);
    }
}
