<?php

namespace App\Http\Controllers;

use App\Models\Marka;
use App\Models\Kargo;
use App\Models\Odeme;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MarkaExport;

class MarkaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $markalar = Marka::orderBy('ad')->get();
        
        // Toplam istatistikler
        $toplamBorc = Marka::sum('toplam_borc');
        $toplamOdenen = Marka::sum('odenen_tutar');
        $toplamKalan = Marka::sum('kalan_tutar');
        
        return view('markalar.index', compact('markalar', 'toplamBorc', 'toplamOdenen', 'toplamKalan'));
    }

    public function export()
    {
        $markalar = Marka::orderBy('ad')->get();
        return Excel::download(new MarkaExport($markalar), 'markalar-' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('markalar.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ad' => 'required|string|max:255',
            'firma_adi' => 'nullable|string|max:255',
            'telefon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'adres' => 'nullable|string',
            'toplam_borc' => 'nullable|numeric|min:0',
            'odenen_tutar' => 'nullable|numeric|min:0',
            'notlar' => 'nullable|string',
            'aktif' => 'boolean',
        ]);

        $marka = Marka::create($request->all());

        return redirect()->route('markalar.index')
            ->with('success', 'Marka başarıyla oluşturuldu.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Marka $markalar)
    {
        $marka = $markalar; // Route parametresi markalar ama değişken adı marka olarak kullanıyoruz
        
        $filtre = $request->get('filtre', 'aylik'); // gunluk, haftalik, aylik, yillik
        
        $now = \Carbon\Carbon::now();
        
        // Tarih aralıklarını belirle
        switch ($filtre) {
            case 'gunluk':
                $baslangic = $now->copy()->startOfDay();
                $bitis = $now->copy()->endOfDay();
                break;
            case 'haftalik':
                $baslangic = $now->copy()->startOfWeek();
                $bitis = $now->copy()->endOfWeek();
                break;
            case 'yillik':
                $baslangic = $now->copy()->startOfYear();
                $bitis = $now->copy()->endOfYear();
                break;
            default: // aylik
                $baslangic = $now->copy()->startOfMonth();
                $bitis = $now->copy()->endOfMonth();
                break;
        }
        
        // Kargo istatistikleri
        $kargolar = $marka->kargolar()
            ->whereBetween('created_at', [$baslangic, $bitis])
            ->orderBy('created_at', 'desc')
            ->get();
        
        $hazirlanan = $kargolar->where('durum', Kargo::DURUM_HAZIRLANIYOR)->count();
        $yolda = $kargolar->where('durum', Kargo::DURUM_YOLDA)->count();
        $teslimEdilen = $kargolar->where('durum', Kargo::DURUM_TESLIM_EDILDI)->count();
        
        // Ödeme istatistikleri
        $odemeler = $marka->odemeler()
            ->whereBetween('odeme_tarihi', [$baslangic->format('Y-m-d'), $bitis->format('Y-m-d')])
            ->orderBy('odeme_tarihi', 'desc')
            ->get();
        
        $toplamOdenen = $odemeler->sum('tutar');
        $nakitOdenen = $odemeler->where('odeme_tipi', Odeme::TIP_NAKIT)->sum('tutar');
        $havaleOdenen = $odemeler->where('odeme_tipi', Odeme::TIP_HAVALE)->sum('tutar');
        $cekOdenen = $odemeler->where('odeme_tipi', Odeme::TIP_CEK)->sum('tutar');
        $senetOdenen = $odemeler->where('odeme_tipi', Odeme::TIP_SENET)->sum('tutar');
        
        // Genel istatistikler
        $toplamKargo = $marka->kargolar()->count();
        $toplamOdeme = $marka->odemeler()->sum('tutar');
        
        return view('markalar.show', compact(
            'marka',
            'filtre',
            'baslangic',
            'bitis',
            'kargolar',
            'hazirlanan',
            'yolda',
            'teslimEdilen',
            'odemeler',
            'toplamOdenen',
            'nakitOdenen',
            'havaleOdenen',
            'cekOdenen',
            'senetOdenen',
            'toplamKargo',
            'toplamOdeme'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $marka = Marka::findOrFail($id);
        return view('markalar.edit', compact('marka'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $marka = Marka::findOrFail($id);

        $request->validate([
            'ad' => 'required|string|max:255',
            'firma_adi' => 'nullable|string|max:255',
            'telefon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'adres' => 'nullable|string',
            'toplam_borc' => 'nullable|numeric|min:0',
            'odenen_tutar' => 'nullable|numeric|min:0',
            'notlar' => 'nullable|string',
            'aktif' => 'boolean',
        ]);

        $marka->update($request->all());

        return redirect()->route('markalar.index')
            ->with('success', 'Marka başarıyla güncellendi.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $marka = Marka::findOrFail($id);
        
        // İlişkili kayıtlar varsa kontrol et
        if ($marka->kargolar()->count() > 0) {
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Bu markaya ait kargolar bulunduğu için silinemez.'], 400);
            }
            return redirect()->route('markalar.index')
                ->with('error', 'Bu markaya ait kargolar bulunduğu için silinemez.');
        }

        $marka->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Marka başarıyla silindi.']);
        }

        return redirect()->route('markalar.index')
            ->with('success', 'Marka başarıyla silindi.');
    }

    /**
     * Kargo detaylarını göster
     */
    public function kargoDetay($markaId, $kargoId)
    {
        $marka = Marka::findOrFail($markaId);
        $kargo = $marka->kargolar()->findOrFail($kargoId);
        
        return view('markalar.kargo-detay', compact('marka', 'kargo'));
    }
}
