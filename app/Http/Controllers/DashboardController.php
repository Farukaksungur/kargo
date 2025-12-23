<?php

namespace App\Http\Controllers;

use App\Models\Kargo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        
        // Günlük istatistikler (bugün)
        $gunlukBaslangic = $now->copy()->startOfDay();
        $gunlukBitis = $now->copy()->endOfDay();
        
        // Haftalık istatistikler (bu hafta)
        $haftalikBaslangic = $now->copy()->startOfWeek();
        $haftalikBitis = $now->copy()->endOfWeek();
        
        // Aylık istatistikler (bu ay)
        $aylikBaslangic = $now->copy()->startOfMonth();
        $aylikBitis = $now->copy()->endOfMonth();
        
        $istatistikler = [
            'gunluk' => [
                'hazirlanan' => Kargo::hazirlanan($gunlukBaslangic, $gunlukBitis),
                'yolda' => Kargo::yolda($gunlukBaslangic, $gunlukBitis),
                'teslim_edilen' => Kargo::teslimEdilen($gunlukBaslangic, $gunlukBitis),
            ],
            'haftalik' => [
                'hazirlanan' => Kargo::hazirlanan($haftalikBaslangic, $haftalikBitis),
                'yolda' => Kargo::yolda($haftalikBaslangic, $haftalikBitis),
                'teslim_edilen' => Kargo::teslimEdilen($haftalikBaslangic, $haftalikBitis),
            ],
            'aylik' => [
                'hazirlanan' => Kargo::hazirlanan($aylikBaslangic, $aylikBitis),
                'yolda' => Kargo::yolda($aylikBaslangic, $aylikBitis),
                'teslim_edilen' => Kargo::teslimEdilen($aylikBaslangic, $aylikBitis),
            ],
        ];
        
        // Ek veriler
        $toplamKargo = Kargo::count();
        $hazirlananToplam = Kargo::where('durum', Kargo::DURUM_HAZIRLANIYOR)->count();
        $yoldaToplam = Kargo::where('durum', Kargo::DURUM_YOLDA)->count();
        $teslimEdilenToplam = Kargo::where('durum', Kargo::DURUM_TESLIM_EDILDI)->count();
        
        // Son eklenen kargolar
        $sonKargolar = Kargo::orderBy('created_at', 'desc')->limit(5)->get();
        
        // Bu ay teslim oranı
        $aylikToplam = $istatistikler['aylik']['hazirlanan'] + $istatistikler['aylik']['yolda'] + $istatistikler['aylik']['teslim_edilen'];
        $teslimOrani = $aylikToplam > 0 ? round(($istatistikler['aylik']['teslim_edilen'] / $aylikToplam) * 100, 1) : 0;
        
        return view('dashboard', compact('istatistikler', 'toplamKargo', 'hazirlananToplam', 'yoldaToplam', 'teslimEdilenToplam', 'sonKargolar', 'teslimOrani'));
    }
}
