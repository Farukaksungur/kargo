<?php

namespace App\Http\Controllers;

use App\Models\Ayar;
use Illuminate\Http\Request;

class AyarController extends Controller
{
    public function index()
    {
        $ayarlar = Ayar::orderBy('grup')->orderBy('anahtar')->get()->groupBy('grup');
        
        return view('ayarlar.index', compact('ayarlar'));
    }

    public function store(Request $request)
    {
        foreach ($request->except(['_token']) as $anahtar => $deger) {
            Ayar::set($anahtar, $deger);
        }
        
        return redirect()->route('ayarlar.index')
            ->with('success', 'Ayarlar başarıyla güncellendi.');
    }
}
