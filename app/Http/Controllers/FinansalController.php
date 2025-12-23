<?php

namespace App\Http\Controllers;

use App\Models\GelirGider;
use App\Models\Fatura;
use App\Models\Kargo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinansalController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        
        // Bugün
        $bugunGelir = GelirGider::where('tip', 'gelir')
            ->whereDate('tarih', $now->toDateString())
            ->sum('tutar');
        $bugunGider = GelirGider::where('tip', 'gider')
            ->whereDate('tarih', $now->toDateString())
            ->sum('tutar');
        
        // Bu ay
        $aylikGelir = GelirGider::where('tip', 'gelir')
            ->whereMonth('tarih', $now->month)
            ->whereYear('tarih', $now->year)
            ->sum('tutar');
        $aylikGider = GelirGider::where('tip', 'gider')
            ->whereMonth('tarih', $now->month)
            ->whereYear('tarih', $now->year)
            ->sum('tutar');
        
        // Toplam
        $toplamGelir = GelirGider::where('tip', 'gelir')->sum('tutar');
        $toplamGider = GelirGider::where('tip', 'gider')->sum('tutar');
        
        // Son işlemler
        $sonGelirler = GelirGider::where('tip', 'gelir')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        $sonGiderler = GelirGider::where('tip', 'gider')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Faturalar
        $bekleyenFaturalar = Fatura::where('durum', Fatura::DURUM_BEKLEMEDE)->count();
        $odenenFaturalar = Fatura::where('durum', Fatura::DURUM_ODENDI)->sum('genel_toplam');
        
        return view('finansal.index', compact(
            'bugunGelir',
            'bugunGider',
            'aylikGelir',
            'aylikGider',
            'toplamGelir',
            'toplamGider',
            'sonGelirler',
            'sonGiderler',
            'bekleyenFaturalar',
            'odenenFaturalar'
        ));
    }
}
