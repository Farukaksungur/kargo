<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ayar extends Model
{
    protected $fillable = [
        'anahtar',
        'deger',
        'tip',
        'grup',
        'aciklama',
    ];

    public static function get($anahtar, $varsayilan = null)
    {
        $ayar = self::where('anahtar', $anahtar)->first();
        return $ayar ? $ayar->deger : $varsayilan;
    }

    public static function set($anahtar, $deger, $tip = 'text', $grup = 'genel', $aciklama = null)
    {
        return self::updateOrCreate(
            ['anahtar' => $anahtar],
            [
                'deger' => $deger,
                'tip' => $tip,
                'grup' => $grup,
                'aciklama' => $aciklama,
            ]
        );
    }
}
