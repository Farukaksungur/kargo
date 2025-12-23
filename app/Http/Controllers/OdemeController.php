<?php

namespace App\Http\Controllers;

use App\Models\Odeme;
use App\Models\Marka;
use Illuminate\Http\Request;

class OdemeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'marka_id' => 'required|exists:markas,id',
            'tutar' => 'required|numeric|min:0',
            'odeme_tarihi' => 'required|date',
            'odeme_tipi' => 'required|in:nakit,havale,cek,senet',
            'aciklama' => 'nullable|string|max:255',
            'fatura_no' => 'nullable|string|max:255',
            'notlar' => 'nullable|string',
        ]);

        $odeme = Odeme::create($request->all());

        // Marka'nın ödenen tutarını güncelle
        $marka = Marka::find($request->marka_id);
        $marka->odenen_tutar += $request->tutar;
        $marka->save();

        return response()->json([
            'success' => true,
            'message' => 'Ödeme başarıyla eklendi.',
            'odeme' => $odeme
        ]);
    }
}
