<?php

namespace App\Http\Controllers;

use App\Models\KargoFirmasi;
use Illuminate\Http\Request;

class KargoFirmasiController extends Controller
{
    public function index()
    {
        // Tek firma varsa göster, yoksa oluştur
        $kargoFirmasi = KargoFirmasi::first();
        
        if (!$kargoFirmasi) {
            // İlk firma yoksa oluştur
            $kargoFirmasi = KargoFirmasi::create([
                'ad' => 'Kargo Firması',
                'kod' => 'KARGO',
                'aktif' => true,
            ]);
        }
        
        return view('kargo-firmalari.index', compact('kargoFirmasi'));
    }

    public function edit($id)
    {
        $kargoFirmasi = KargoFirmasi::findOrFail($id);
        
        return view('kargo-firmalari.edit', compact('kargoFirmasi'));
    }

    public function update(Request $request, $id)
    {
        $kargoFirmasi = KargoFirmasi::findOrFail($id);
        
        $data = $request->all();
        
        // Eğer API Secret boş bırakıldıysa, eski değeri koru
        if (empty($data['api_secret'])) {
            unset($data['api_secret']);
        }
        
        // Aktif checkbox kontrolü
        $data['aktif'] = $request->has('aktif') ? 1 : 0;
        
        $kargoFirmasi->update($data);
        
        return redirect()->route('kargo-firmalari.index')
            ->with('success', 'Kargo firması bilgileri başarıyla güncellendi.');
    }
}
