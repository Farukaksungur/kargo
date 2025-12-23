@extends('adminlte::page')

@section('title', ($musteri->ad ?? '') . ' ' . ($musteri->soyad ?? '') . ' - Detay')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="m-0"><i class="fas fa-user mr-2"></i>{{ $musteri->ad ?? '-' }} {{ $musteri->soyad ?? '-' }}</h1>
            <small class="text-muted">{{ $musteri->telefon ?? '-' }}</small>
        </div>
        <a href="{{ route('musteriler.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Geri Dön
        </a>
    </div>
@stop

@section('content')
    <!-- İstatistik Kartları -->
    <div class="row mb-3">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card shadow-sm border-0 bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0 text-white-50">Toplam Ürün</h6>
                            <h3 class="mb-0 mt-2">{{ $toplamUrunSayisi }}</h3>
                        </div>
                        <i class="fas fa-boxes fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card shadow-sm border-0 bg-gradient-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0 text-white-50">Toplam Harcama</h6>
                            <h3 class="mb-0 mt-2">{{ number_format($toplamHarcama, 2, ',', '.') }} ₺</h3>
                        </div>
                        <i class="fas fa-money-bill-wave fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card shadow-sm border-0 bg-gradient-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0 text-white-50">Ödenen Tutar</h6>
                            <h3 class="mb-0 mt-2">{{ number_format($toplamOdenen, 2, ',', '.') }} ₺</h3>
                        </div>
                        <i class="fas fa-check-circle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card shadow-sm border-0 bg-gradient-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0 text-white-50">Kargo Ücreti</h6>
                            <h3 class="mb-0 mt-2">{{ number_format($toplamKargoUcreti, 2, ',', '.') }} ₺</h3>
                        </div>
                        <i class="fas fa-shipping-fast fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Durum İstatistikleri -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-2">
                    <h6 class="mb-0 font-weight-bold">
                        <i class="fas fa-chart-pie mr-2"></i>Kargo Durumları
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="stat-mini-card stat-mini-info">
                                <div class="stat-mini-content">
                                    <div class="stat-mini-icon">
                                        <i class="fas fa-box-open"></i>
                                    </div>
                                    <div class="stat-mini-info">
                                        <h4 class="stat-mini-number">{{ $hazirlanan }}</h4>
                                        <p class="stat-mini-label">Hazırlanan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="stat-mini-card stat-mini-warning">
                                <div class="stat-mini-content">
                                    <div class="stat-mini-icon">
                                        <i class="fas fa-truck"></i>
                                    </div>
                                    <div class="stat-mini-info">
                                        <h4 class="stat-mini-number">{{ $yolda }}</h4>
                                        <p class="stat-mini-label">Yolda</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="stat-mini-card stat-mini-success">
                                <div class="stat-mini-content">
                                    <div class="stat-mini-icon">
                                        <i class="fas fa-check-double"></i>
                                    </div>
                                    <div class="stat-mini-info">
                                        <h4 class="stat-mini-number">{{ $teslimEdilen }}</h4>
                                        <p class="stat-mini-label">Teslim Edilen</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Müşteri Bilgileri -->
    <div class="row mb-3">
        <div class="col-lg-6 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="fas fa-user-circle mr-2"></i>Müşteri Bilgileri
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small d-block">Ad</label>
                            <p class="mb-0 font-weight-bold">{{ $musteri->ad ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small d-block">Soyad</label>
                            <p class="mb-0 font-weight-bold">{{ $musteri->soyad ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small d-block">Telefon</label>
                            <p class="mb-0">{{ $musteri->telefon ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small d-block">E-posta</label>
                            <p class="mb-0">{{ $musteri->email ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small d-block">İl</label>
                            <p class="mb-0">{{ $musteri->il ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small d-block">İlçe</label>
                            <p class="mb-0">{{ $musteri->ilce ?? '-' }}</p>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="text-muted small d-block">Adres</label>
                            <p class="mb-0">{{ $musteri->adres ?? '-' }}</p>
                        </div>
                        @if($musteri->notlar)
                        <div class="col-12 mb-3">
                            <label class="text-muted small d-block">Notlar</label>
                            <p class="mb-0">{{ $musteri->notlar }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="fas fa-chart-line mr-2"></i>Özet Bilgiler
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small d-block">Toplam Sipariş</label>
                        <p class="mb-0 font-weight-bold" style="font-size: 24px;">{{ $toplamUrunSayisi }}</p>
                    </div>
                    <div class="mb-3 pt-3 border-top">
                        <label class="text-muted small d-block">Toplam Harcama</label>
                        <p class="mb-0 font-weight-bold text-success" style="font-size: 20px;">
                            {{ number_format($toplamHarcama, 2, ',', '.') }} ₺
                        </p>
                    </div>
                    <div class="mb-3 pt-3 border-top">
                        <label class="text-muted small d-block">Ortalama Sipariş Tutarı</label>
                        <p class="mb-0 font-weight-bold text-primary" style="font-size: 18px;">
                            {{ $toplamUrunSayisi > 0 ? number_format($toplamHarcama / $toplamUrunSayisi, 2, ',', '.') : '0,00' }} ₺
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kargo Geçmişi -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="fas fa-boxes mr-2"></i>Bugüne Kadar Aldığı Ürünler
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0">Tarih</th>
                                    <th class="border-0">Takip No</th>
                                    <th class="border-0">Marka</th>
                                    <th class="border-0">Ürün</th>
                                    <th class="border-0">Kargo Firması</th>
                                    <th class="border-0">Durum</th>
                                    <th class="border-0 text-right">Ürün Tutarı</th>
                                    <th class="border-0 text-right">Ödeme</th>
                                    <th class="border-0 text-right">Kargo Ücreti</th>
                                    <th class="border-0 text-right">Toplam</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kargolar as $kargo)
                                <tr class="table-row-clickable" data-href="{{ route('musteriler.kargo.detay', ['musteriId' => $musteri->id, 'kargoId' => $kargo->id]) }}" style="cursor: pointer;">
                                    <td>
                                        <small class="d-block">{{ $kargo->created_at->format('d.m.Y') }}</small>
                                        @if($kargo->teslim_tarihi)
                                            <small class="text-muted">Teslim: {{ $kargo->teslim_tarihi->format('d.m.Y') }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <strong>{{ $kargo->takip_no }}</strong>
                                        @if($kargo->kargo_kodu)
                                            <br><small class="text-muted">Kod: {{ $kargo->kargo_kodu }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($kargo->marka)
                                            <span class="badge badge-primary">{{ $kargo->marka->ad }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($kargo->urun_bilgisi)
                                            <small class="d-block" title="{{ $kargo->urun_bilgisi }}">{{ Str::limit($kargo->urun_bilgisi, 50) }}</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <small>{{ $kargo->kargo_firmasi ?? '-' }}</small>
                                    </td>
                                    <td>
                                        @if($kargo->durum == 'hazirlaniyor')
                                            <span class="badge badge-info">Hazırlanıyor</span>
                                        @elseif($kargo->durum == 'yolda')
                                            <span class="badge badge-warning">Yolda</span>
                                        @else
                                            <span class="badge badge-success">Teslim Edildi</span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <strong class="text-primary">
                                            {{ $kargo->tutar ? number_format($kargo->tutar, 2, ',', '.') . ' ₺' : '-' }}
                                        </strong>
                                    </td>
                                    <td class="text-right">
                                        <strong class="text-warning">
                                            {{ $kargo->odeme_tutari ? number_format($kargo->odeme_tutari, 2, ',', '.') . ' ₺' : '-' }}
                                        </strong>
                                    </td>
                                    <td class="text-right">
                                        <strong class="text-info">
                                            {{ $kargo->kargo_ucreti ? number_format($kargo->kargo_ucreti, 2, ',', '.') . ' ₺' : '-' }}
                                        </strong>
                                    </td>
                                    <td class="text-right">
                                        <strong class="text-success" style="font-size: 15px;">
                                            {{ number_format(($kargo->tutar ?? 0) + ($kargo->kargo_ucreti ?? 0), 2, ',', '.') }} ₺
                                        </strong>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="10" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p class="mb-0">Bu müşteriye ait kargo kaydı bulunmamaktadır.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                            @if($kargolar->count() > 0)
                            <tfoot class="thead-light">
                                <tr>
                                    <th colspan="6" class="text-right">TOPLAM:</th>
                                    <th class="text-right text-primary">{{ number_format($kargolar->sum('tutar'), 2, ',', '.') }} ₺</th>
                                    <th class="text-right text-warning">{{ number_format($kargolar->sum('odeme_tutari'), 2, ',', '.') }} ₺</th>
                                    <th class="text-right text-info">{{ number_format($kargolar->sum('kargo_ucreti'), 2, ',', '.') }} ₺</th>
                                    <th class="text-right text-success">{{ number_format($toplamHarcama, 2, ',', '.') }} ₺</th>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .stat-mini-card {
            background: #ffffff;
            border-radius: 8px;
            padding: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .stat-mini-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .stat-mini-content {
            display: flex;
            align-items: center;
        }

        .stat-mini-icon {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 20px;
            flex-shrink: 0;
        }

        .stat-mini-info {
            flex: 1;
        }

        .stat-mini-number {
            font-size: 20px;
            font-weight: 700;
            margin: 0 0 4px 0;
            line-height: 1.2;
        }

        .stat-mini-label {
            font-size: 12px;
            color: #6c757d;
            margin: 0;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-mini-info .stat-mini-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .stat-mini-info .stat-mini-number { color: #667eea; }

        .stat-mini-warning .stat-mini-icon {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }
        .stat-mini-warning .stat-mini-number { color: #f5576c; }

        .stat-mini-success .stat-mini-icon {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }
        .stat-mini-success .stat-mini-number { color: #00c9ff; }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%) !important;
        }

        .bg-gradient-info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%) !important;
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%) !important;
        }

        .table {
            font-size: 14px;
        }

        .table thead th {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 15px;
        }

        .table tbody td {
            padding: 12px 15px;
            vertical-align: middle;
        }

        .table tfoot th {
            font-weight: 700;
            padding: 15px;
            font-size: 14px;
        }
    </style>
@stop

@section('js')
    <script>
        console.log('Müşteri detay sayfası yüklendi');
        
        // Satıra tıklayınca kargo detay sayfasına git
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('.table-row-clickable');
            rows.forEach(row => {
                row.addEventListener('click', function(e) {
                    if (e.target.tagName !== 'A' && e.target.tagName !== 'BUTTON' && !e.target.closest('a') && !e.target.closest('button')) {
                        window.location.href = this.dataset.href;
                    }
                });
                
                row.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = '#f8f9fa';
                });
                row.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = '';
                });
            });
        });
    </script>
@stop

