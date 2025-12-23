<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Odeme extends Model
{
    protected $fillable = [
        'marka_id',
        'tutar',
        'odeme_tarihi',
        'odeme_tipi',
        'aciklama',
        'fatura_no',
        'notlar',
    ];

    protected $casts = [
        'tutar' => 'decimal:2',
        'odeme_tarihi' => 'date',
    ];

    // Ödeme tipi sabitleri
    const TIP_NAKIT = 'nakit';
    const TIP_HAVALE = 'havale';
    const TIP_CEK = 'cek';
    const TIP_SENET = 'senet';

    /**
     * Marka ilişkisi
     */
    public function marka()
    {
        return $this->belongsTo(Marka::class);
    }
}
