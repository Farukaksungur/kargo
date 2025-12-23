<?php

namespace App\Http\Controllers;

use App\Models\Kargo;
use App\Models\Marka;
use App\Models\Musteri;
use App\Models\GelirGider;
use App\Models\Fatura;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RaporExport;

class RaporController extends Controller
{
    public function index()
    {
        return view('raporlar.index');
    }

    public function olustur($tip)
    {
        $baslangic = request('baslangic', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $bitis = request('bitis', Carbon::now()->endOfMonth()->format('Y-m-d'));
        
        $rapor = match($tip) {
            'satis' => $this->satisRaporu($baslangic, $bitis),
            'kargo' => $this->kargoRaporu($baslangic, $bitis),
            'finansal' => $this->finansalRapor($baslangic, $bitis),
            'musteri' => $this->musteriRaporu($baslangic, $bitis),
            'marka' => $this->markaRaporu($baslangic, $bitis),
            default => null,
        };

        return view('raporlar.detay', compact('tip', 'baslangic', 'bitis', 'rapor'));
    }

    public function pdf($tip)
    {
        $baslangic = request('baslangic', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $bitis = request('bitis', Carbon::now()->endOfMonth()->format('Y-m-d'));
        
        $rapor = match($tip) {
            'satis' => $this->satisRaporu($baslangic, $bitis),
            'kargo' => $this->kargoRaporu($baslangic, $bitis),
            'finansal' => $this->finansalRapor($baslangic, $bitis),
            'musteri' => $this->musteriRaporu($baslangic, $bitis),
            'marka' => $this->markaRaporu($baslangic, $bitis),
            default => null,
        };

        $pdf = PDF::loadView('raporlar.pdf', compact('tip', 'baslangic', 'bitis', 'rapor'));
        return $pdf->download('rapor-' . $tip . '-' . $baslangic . '-' . $bitis . '.pdf');
    }

    public function excel($tip)
    {
        $baslangic = request('baslangic', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $bitis = request('bitis', Carbon::now()->endOfMonth()->format('Y-m-d'));
        
        $rapor = match($tip) {
            'satis' => $this->satisRaporu($baslangic, $bitis),
            'kargo' => $this->kargoRaporu($baslangic, $bitis),
            'finansal' => $this->finansalRapor($baslangic, $bitis),
            'musteri' => $this->musteriRaporu($baslangic, $bitis),
            'marka' => $this->markaRaporu($baslangic, $bitis),
            default => null,
        };

        $data = [];
        $headings = [];
        $title = ucfirst($tip) . ' Raporu';

        if ($tip == 'satis') {
            $headings = ['Takip No', 'Tarih', 'Müşteri', 'Durum', 'Tutar', 'Kargo Ücreti', 'Toplam'];
            foreach ($rapor['detaylar'] as $kargo) {
                $data[] = [
                    $kargo->takip_no ?? '-',
                    $kargo->created_at->format('d.m.Y'),
                    ($kargo->alici_ad ?? '') . ' ' . ($kargo->alici_soyad ?? ''),
                    $this->durumText($kargo->durum),
                    number_format($kargo->tutar ?? 0, 2, ',', '.') . ' ₺',
                    number_format($kargo->kargo_ucreti ?? 0, 2, ',', '.') . ' ₺',
                    number_format(($kargo->tutar ?? 0) + ($kargo->kargo_ucreti ?? 0), 2, ',', '.') . ' ₺',
                ];
            }
        } elseif ($tip == 'kargo') {
            $headings = ['Kargo Firması', 'Kargo Sayısı', 'Toplam Tutar'];
            foreach ($rapor['firma_bazli'] as $firma => $veri) {
                $data[] = [
                    $firma,
                    $veri['sayi'],
                    number_format($veri['tutar'], 2, ',', '.') . ' ₺',
                ];
            }
        } elseif ($tip == 'finansal') {
            $headings = ['Tarih', 'Tip', 'Başlık', 'Tutar'];
            foreach ($rapor['gelirler'] as $gelir) {
                $data[] = [
                    $gelir->tarih->format('d.m.Y'),
                    'Gelir',
                    $gelir->baslik ?? '-',
                    number_format($gelir->tutar, 2, ',', '.') . ' ₺',
                ];
            }
            foreach ($rapor['giderler'] as $gider) {
                $data[] = [
                    $gider->tarih->format('d.m.Y'),
                    'Gider',
                    $gider->baslik ?? '-',
                    number_format($gider->tutar, 2, ',', '.') . ' ₺',
                ];
            }
        } elseif ($tip == 'musteri') {
            $headings = ['Müşteri', 'Sipariş Sayısı', 'Toplam Harcama'];
            foreach ($rapor['musteri_bazli'] as $musteri) {
                $data[] = [
                    $musteri['ad'],
                    $musteri['siparis_sayisi'],
                    number_format($musteri['toplam_harcama'], 2, ',', '.') . ' ₺',
                ];
            }
        } elseif ($tip == 'marka') {
            $headings = ['Marka', 'Sipariş Sayısı', 'Toplam Tutar', 'Toplam Borç', 'Ödenen', 'Kalan'];
            foreach ($rapor['marka_bazli'] as $marka) {
                $data[] = [
                    $marka['ad'],
                    $marka['siparis_sayisi'],
                    number_format($marka['toplam_tutar'], 2, ',', '.') . ' ₺',
                    number_format($marka['toplam_borc'], 2, ',', '.') . ' ₺',
                    number_format($marka['odenen_tutar'], 2, ',', '.') . ' ₺',
                    number_format($marka['kalan_tutar'], 2, ',', '.') . ' ₺',
                ];
            }
        }

        return Excel::download(new RaporExport($data, $headings, $title), 'rapor-' . $tip . '-' . $baslangic . '-' . $bitis . '.xlsx');
    }

    private function durumText($durum)
    {
        return match($durum) {
            'hazirlaniyor' => 'Hazırlanıyor',
            'yolda' => 'Yolda',
            'teslim_edildi' => 'Teslim Edildi',
            default => $durum
        };
    }

    private function satisRaporu($baslangic, $bitis)
    {
        $kargolar = Kargo::whereBetween('created_at', [$baslangic, $bitis])->get();
        
        // Günlük bazlı veriler (grafik için)
        $gunlukVeriler = [];
        $baslangicCarbon = Carbon::parse($baslangic);
        $bitisCarbon = Carbon::parse($bitis);
        
        for ($date = $baslangicCarbon->copy(); $date->lte($bitisCarbon); $date->addDay()) {
            $gunKargolar = $kargolar->filter(function($kargo) use ($date) {
                return Carbon::parse($kargo->created_at)->format('Y-m-d') == $date->format('Y-m-d');
            });
            
            $gunlukVeriler[] = [
                'tarih' => $date->format('d.m.Y'),
                'siparis' => $gunKargolar->count(),
                'tutar' => $gunKargolar->sum('tutar'),
            ];
        }
        
        return [
            'toplam_siparis' => $kargolar->count(),
            'toplam_tutar' => $kargolar->sum('tutar'),
            'toplam_kargo_ucreti' => $kargolar->sum('kargo_ucreti'),
            'genel_toplam' => $kargolar->sum('tutar') + $kargolar->sum('kargo_ucreti'),
            'hazirlanan' => $kargolar->where('durum', Kargo::DURUM_HAZIRLANIYOR)->count(),
            'yolda' => $kargolar->where('durum', Kargo::DURUM_YOLDA)->count(),
            'teslim_edilen' => $kargolar->where('durum', Kargo::DURUM_TESLIM_EDILDI)->count(),
            'detaylar' => $kargolar,
            'gunluk_veriler' => $gunlukVeriler,
        ];
    }

    private function kargoRaporu($baslangic, $bitis)
    {
        $kargolar = Kargo::whereBetween('created_at', [$baslangic, $bitis])->get();
        
        // Firma bazlı veriler
        $firmaBazli = $kargolar->groupBy('kargo_firmasi')->map(function($group) {
            return [
                'sayi' => $group->count(),
                'tutar' => $group->sum('kargo_ucreti'),
            ];
        })->toArray();
        
        return [
            'toplam_kargo' => $kargolar->count(),
            'firma_bazli' => $firmaBazli,
            'durum_bazli' => [
                'hazirlanan' => $kargolar->where('durum', Kargo::DURUM_HAZIRLANIYOR)->count(),
                'yolda' => $kargolar->where('durum', Kargo::DURUM_YOLDA)->count(),
                'teslim_edilen' => $kargolar->where('durum', Kargo::DURUM_TESLIM_EDILDI)->count(),
            ],
            'detaylar' => $kargolar,
        ];
    }

    private function finansalRapor($baslangic, $bitis)
    {
        $gelirler = GelirGider::where('tip', 'gelir')
            ->whereBetween('tarih', [$baslangic, $bitis])
            ->get();
        $giderler = GelirGider::where('tip', 'gider')
            ->whereBetween('tarih', [$baslangic, $bitis])
            ->get();
        
        // Günlük bazlı veriler
        $gunlukVeriler = [];
        $baslangicCarbon = Carbon::parse($baslangic);
        $bitisCarbon = Carbon::parse($bitis);
        
        for ($date = $baslangicCarbon->copy(); $date->lte($bitisCarbon); $date->addDay()) {
            $gunGelirler = $gelirler->filter(function($gelir) use ($date) {
                return Carbon::parse($gelir->tarih)->format('Y-m-d') == $date->format('Y-m-d');
            });
            $gunGiderler = $giderler->filter(function($gider) use ($date) {
                return Carbon::parse($gider->tarih)->format('Y-m-d') == $date->format('Y-m-d');
            });
            
            $gunlukVeriler[] = [
                'tarih' => $date->format('d.m.Y'),
                'gelir' => $gunGelirler->sum('tutar'),
                'gider' => $gunGiderler->sum('tutar'),
            ];
        }
        
        return [
            'toplam_gelir' => $gelirler->sum('tutar'),
            'toplam_gider' => $giderler->sum('tutar'),
            'net_kar' => $gelirler->sum('tutar') - $giderler->sum('tutar'),
            'gelirler' => $gelirler,
            'giderler' => $giderler,
            'gunluk_veriler' => $gunlukVeriler,
        ];
    }

    private function musteriRaporu($baslangic, $bitis)
    {
        $musteriler = Musteri::with(['kargolar' => function($query) use ($baslangic, $bitis) {
            $query->whereBetween('created_at', [$baslangic, $bitis]);
        }])->get();
        
        return [
            'toplam_musteri' => $musteriler->count(),
            'aktif_musteri' => $musteriler->filter(fn($m) => $m->kargolar->count() > 0)->count(),
            'musteri_bazli' => $musteriler->map(function($musteri) {
                return [
                    'ad' => $musteri->ad . ' ' . $musteri->soyad,
                    'siparis_sayisi' => $musteri->kargolar->count(),
                    'toplam_harcama' => $musteri->kargolar->sum('tutar') + $musteri->kargolar->sum('kargo_ucreti'),
                ];
            })->sortByDesc('toplam_harcama')->take(10),
        ];
    }

    private function markaRaporu($baslangic, $bitis)
    {
        $markalar = Marka::with(['kargolar' => function($query) use ($baslangic, $bitis) {
            $query->whereBetween('created_at', [$baslangic, $bitis]);
        }])->get();
        
        return [
            'toplam_marka' => $markalar->count(),
            'marka_bazli' => $markalar->map(function($marka) {
                return [
                    'ad' => $marka->ad,
                    'siparis_sayisi' => $marka->kargolar->count(),
                    'toplam_tutar' => $marka->kargolar->sum('tutar'),
                    'toplam_borc' => $marka->toplam_borc,
                    'odenen_tutar' => $marka->odenen_tutar,
                    'kalan_tutar' => $marka->kalan_tutar,
                ];
            })->sortByDesc('toplam_tutar'),
        ];
    }
}
