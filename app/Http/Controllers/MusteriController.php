<?php

namespace App\Http\Controllers;

use App\Models\Musteri;
use App\Models\Kargo;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MusteriExport;

class MusteriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $musteriler = Musteri::withCount('kargolar')
            ->with(['kargolar' => function($query) {
                $query->select('id', 'musteri_id', 'tutar', 'kargo_ucreti');
            }])
            ->orderBy('ad')
            ->get();
        
        return view('musteriler.index', compact('musteriler'));
    }

    public function export()
    {
        $musteriler = Musteri::with('kargolar')->orderBy('ad')->get();
        return Excel::download(new MusteriExport($musteriler), 'musteriler-' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('musteriler.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ad' => 'required|string|max:255',
            'soyad' => 'required|string|max:255',
            'telefon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'il' => 'nullable|string|max:255',
            'ilce' => 'nullable|string|max:255',
            'adres' => 'nullable|string',
            'notlar' => 'nullable|string',
            'aktif' => 'boolean',
        ]);

        Musteri::create($request->all());

        return redirect()->route('musteriler.index')
            ->with('success', 'Müşteri başarıyla oluşturuldu.');
    }

    /**
     * Display the specified resource.
     */
    public function show($musteriler)
    {
        $musteri = Musteri::findOrFail($musteriler);
        
        // Bugüne kadar aldığı tüm kargolar
        $kargolar = $musteri->kargolar()
            ->with('marka')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // İstatistikler
        $toplamUrunSayisi = $kargolar->count();
        $toplamHarcama = $kargolar->sum('tutar') + $kargolar->sum('kargo_ucreti');
        $toplamOdenen = $kargolar->sum('odeme_tutari');
        $toplamKargoUcreti = $kargolar->sum('kargo_ucreti');
        
        // Durum bazlı sayılar
        $hazirlanan = $kargolar->where('durum', Kargo::DURUM_HAZIRLANIYOR)->count();
        $yolda = $kargolar->where('durum', Kargo::DURUM_YOLDA)->count();
        $teslimEdilen = $kargolar->where('durum', Kargo::DURUM_TESLIM_EDILDI)->count();
        
        return view('musteriler.show', compact(
            'musteri',
            'kargolar',
            'toplamUrunSayisi',
            'toplamHarcama',
            'toplamOdenen',
            'toplamKargoUcreti',
            'hazirlanan',
            'yolda',
            'teslimEdilen'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $musteri = Musteri::findOrFail($id);
        return view('musteriler.edit', compact('musteri'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $musteri = Musteri::findOrFail($id);

        $request->validate([
            'ad' => 'required|string|max:255',
            'soyad' => 'required|string|max:255',
            'telefon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'il' => 'nullable|string|max:255',
            'ilce' => 'nullable|string|max:255',
            'adres' => 'nullable|string',
            'notlar' => 'nullable|string',
            'aktif' => 'boolean',
        ]);

        $musteri->update($request->all());

        return redirect()->route('musteriler.index')
            ->with('success', 'Müşteri başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $musteri = Musteri::findOrFail($id);
        
        // İlişkili kayıtlar varsa kontrol et
        if ($musteri->kargolar()->count() > 0) {
            return redirect()->route('musteriler.index')
                ->with('error', 'Bu müşteriye ait kargolar bulunduğu için silinemez.');
        }

        $musteri->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Müşteri başarıyla silindi.']);
        }

        return redirect()->route('musteriler.index')
            ->with('success', 'Müşteri başarıyla silindi.');
    }

    /**
     * Kargo detaylarını göster
     */
    public function kargoDetay($musteriId, $kargoId)
    {
        $musteri = Musteri::findOrFail($musteriId);
        $kargo = $musteri->kargolar()->with('marka')->findOrFail($kargoId);
        
        return view('musteriler.kargo-detay', compact('musteri', 'kargo'));
    }
}
