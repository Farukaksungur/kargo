<?php

namespace App\Http\Controllers;

use App\Models\Fatura;
use App\Models\Marka;
use App\Models\Musteri;
use Illuminate\Http\Request;

class FaturaController extends Controller
{
    public function index()
    {
        $faturalar = Fatura::with(['marka', 'musteri', 'kargo'])
            ->orderBy('tarih', 'desc')
            ->paginate(20);
        
        return view('faturalar.index', compact('faturalar'));
    }

    public function create()
    {
        $markalar = Marka::all();
        $musteriler = Musteri::all();
        
        return view('faturalar.create', compact('markalar', 'musteriler'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fatura_no' => 'required|string|max:255',
            'tarih' => 'required|date',
            'tip' => 'required|in:satis,alis,iade',
            'ara_toplam' => 'required|numeric|min:0',
            'kdv_orani' => 'nullable|numeric|min:0|max:100',
            'genel_toplam' => 'required|numeric|min:0',
            'durum' => 'required|in:beklemede,odendi,iptal',
            'odeme_yontemi' => 'nullable|string|max:255',
        ]);

        $fatura = Fatura::create($request->all());
        
        return redirect()->route('faturalar.index')
            ->with('success', 'Fatura başarıyla oluşturuldu.');
    }

    public function show($id)
    {
        $fatura = Fatura::with(['marka', 'musteri', 'kargo'])->findOrFail($id);
        
        return view('faturalar.show', compact('fatura'));
    }

    public function edit($id)
    {
        $fatura = Fatura::findOrFail($id);
        $markalar = Marka::all();
        $musteriler = Musteri::all();
        
        return view('faturalar.edit', compact('fatura', 'markalar', 'musteriler'));
    }

    public function update(Request $request, $id)
    {
        $fatura = Fatura::findOrFail($id);
        
        $request->validate([
            'fatura_no' => 'required|string|max:255',
            'tarih' => 'required|date',
            'tip' => 'required|in:satis,alis,iade',
            'ara_toplam' => 'required|numeric|min:0',
            'kdv_orani' => 'nullable|numeric|min:0|max:100',
            'genel_toplam' => 'required|numeric|min:0',
            'durum' => 'required|in:beklemede,odendi,iptal',
            'odeme_yontemi' => 'nullable|string|max:255',
        ]);

        $fatura->update($request->all());

        return redirect()->route('faturalar.index')
            ->with('success', 'Fatura başarıyla güncellendi.');
    }

    public function destroy($id)
    {
        $fatura = Fatura::findOrFail($id);
        $fatura->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Fatura başarıyla silindi.']);
        }

        return redirect()->route('faturalar.index')
            ->with('success', 'Fatura başarıyla silindi.');
    }
}
