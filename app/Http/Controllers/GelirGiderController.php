<?php

namespace App\Http\Controllers;

use App\Models\GelirGider;
use App\Models\Marka;
use App\Models\Musteri;
use Illuminate\Http\Request;

class GelirGiderController extends Controller
{
    public function index()
    {
        $gelirGiderler = GelirGider::with(['marka', 'musteri', 'kargo'])
            ->orderBy('tarih', 'desc')
            ->paginate(20);
        
        return view('gelir-gider.index', compact('gelirGiderler'));
    }

    public function create()
    {
        $markalar = Marka::all();
        $musteriler = Musteri::all();
        
        return view('gelir-gider.create', compact('markalar', 'musteriler'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tip' => 'required|in:gelir,gider',
            'tarih' => 'required|date',
            'baslik' => 'required|string|max:255',
            'tutar' => 'required|numeric|min:0',
            'kategori' => 'nullable|string|max:255',
            'odeme_yontemi' => 'nullable|string|max:255',
            'aciklama' => 'nullable|string',
        ]);

        GelirGider::create($request->all());
        
        return redirect()->route('gelir-gider.index')
            ->with('success', 'Gelir/Gider kaydı başarıyla oluşturuldu.');
    }

    public function show($id)
    {
        $gelirGider = GelirGider::with(['marka', 'musteri', 'kargo'])->findOrFail($id);
        
        return view('gelir-gider.show', compact('gelirGider'));
    }

    public function edit($id)
    {
        $gelirGider = GelirGider::findOrFail($id);
        $markalar = Marka::all();
        $musteriler = Musteri::all();
        
        return view('gelir-gider.edit', compact('gelirGider', 'markalar', 'musteriler'));
    }

    public function update(Request $request, $id)
    {
        $gelirGider = GelirGider::findOrFail($id);
        
        $request->validate([
            'tip' => 'required|in:gelir,gider',
            'tarih' => 'required|date',
            'baslik' => 'required|string|max:255',
            'tutar' => 'required|numeric|min:0',
            'kategori' => 'nullable|string|max:255',
            'odeme_yontemi' => 'nullable|string|max:255',
            'aciklama' => 'nullable|string',
        ]);

        $gelirGider->update($request->all());

        return redirect()->route('gelir-gider.index')
            ->with('success', 'Gelir/Gider kaydı başarıyla güncellendi.');
    }

    public function destroy($id)
    {
        $gelirGider = GelirGider::findOrFail($id);
        $gelirGider->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Gelir/Gider kaydı başarıyla silindi.']);
        }

        return redirect()->route('gelir-gider.index')
            ->with('success', 'Gelir/Gider kaydı başarıyla silindi.');
    }
}
