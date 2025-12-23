@extends('adminlte::page')

@section('title', 'Rapor Detay - ' . ucfirst($tip))

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-chart-bar mr-2"></i>Rapor Detay - {{ ucfirst($tip) }}</h1>
        <div>
            <a href="{{ route('raporlar.excel', ['tip' => $tip, 'baslangic' => $baslangic, 'bitis' => $bitis]) }}" class="btn btn-success mr-2">
                <i class="fas fa-file-excel mr-2"></i>Excel İndir
            </a>
            <a href="{{ route('raporlar.pdf', ['tip' => $tip, 'baslangic' => $baslangic, 'bitis' => $bitis]) }}" class="btn btn-danger" target="_blank">
                <i class="fas fa-file-pdf mr-2"></i>PDF İndir
            </a>
        </div>
    </div>
@stop

@section('content')
    <!-- Filtre Formu -->
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" class="form-inline">
                <div class="form-group mr-3">
                    <label class="mr-2">Başlangıç Tarihi:</label>
                    <input type="date" name="baslangic" value="{{ $baslangic }}" class="form-control" required>
                </div>
                <div class="form-group mr-3">
                    <label class="mr-2">Bitiş Tarihi:</label>
                    <input type="date" name="bitis" value="{{ $bitis }}" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter mr-2"></i>Filtrele
                </button>
            </form>
        </div>
    </div>

    @if($tip == 'satis')
        <!-- Satış Raporu -->
        <div class="row mb-3">
            <div class="col-md-3">
                <div class="card bg-gradient-primary text-white">
                    <div class="card-body">
                        <h6 class="mb-0">Toplam Sipariş</h6>
                        <h2 class="mb-0">{{ $rapor['toplam_siparis'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-gradient-success text-white">
                    <div class="card-body">
                        <h6 class="mb-0">Toplam Tutar</h6>
                        <h2 class="mb-0">{{ number_format($rapor['toplam_tutar'], 2, ',', '.') }} ₺</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-gradient-info text-white">
                    <div class="card-body">
                        <h6 class="mb-0">Kargo Ücreti</h6>
                        <h2 class="mb-0">{{ number_format($rapor['toplam_kargo_ucreti'], 2, ',', '.') }} ₺</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-gradient-warning text-white">
                    <div class="card-body">
                        <h6 class="mb-0">Genel Toplam</h6>
                        <h2 class="mb-0">{{ number_format($rapor['genel_toplam'], 2, ',', '.') }} ₺</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafikler -->
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-chart-pie mr-2"></i>Kargo Durumları</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="durumChart" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-chart-line mr-2"></i>Günlük Satış Trendi</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="satisTrendChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detay Tablosu -->
        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-table mr-2"></i>Detaylı Liste</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Takip No</th>
                                <th>Tarih</th>
                                <th>Müşteri</th>
                                <th>Durum</th>
                                <th>Tutar</th>
                                <th>Kargo Ücreti</th>
                                <th>Toplam</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rapor['detaylar']->take(20) as $kargo)
                            <tr>
                                <td>{{ $kargo->takip_no }}</td>
                                <td>{{ $kargo->created_at->format('d.m.Y') }}</td>
                                <td>{{ $kargo->alici_ad }} {{ $kargo->alici_soyad }}</td>
                                <td>
                                    @if($kargo->durum == 'hazirlaniyor')
                                        <span class="badge badge-info">Hazırlanıyor</span>
                                    @elseif($kargo->durum == 'yolda')
                                        <span class="badge badge-warning">Yolda</span>
                                    @else
                                        <span class="badge badge-success">Teslim Edildi</span>
                                    @endif
                                </td>
                                <td>{{ number_format($kargo->tutar, 2, ',', '.') }} ₺</td>
                                <td>{{ number_format($kargo->kargo_ucreti, 2, ',', '.') }} ₺</td>
                                <td><strong>{{ number_format($kargo->tutar + $kargo->kargo_ucreti, 2, ',', '.') }} ₺</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    @elseif($tip == 'kargo')
        <!-- Kargo Raporu -->
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="card bg-gradient-primary text-white">
                    <div class="card-body">
                        <h6 class="mb-0">Toplam Kargo</h6>
                        <h2 class="mb-0">{{ $rapor['toplam_kargo'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-gradient-info text-white">
                    <div class="card-body">
                        <h6 class="mb-0">Hazırlanan</h6>
                        <h2 class="mb-0">{{ $rapor['durum_bazli']['hazirlanan'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-gradient-success text-white">
                    <div class="card-body">
                        <h6 class="mb-0">Teslim Edilen</h6>
                        <h2 class="mb-0">{{ $rapor['durum_bazli']['teslim_edilen'] }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-chart-pie mr-2"></i>Kargo Durumları</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="kargoDurumChart" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-chart-bar mr-2"></i>Firma Bazlı Dağılım</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="firmaChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

    @elseif($tip == 'finansal')
        <!-- Finansal Rapor -->
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="card bg-gradient-success text-white">
                    <div class="card-body">
                        <h6 class="mb-0">Toplam Gelir</h6>
                        <h2 class="mb-0">{{ number_format($rapor['toplam_gelir'], 2, ',', '.') }} ₺</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-gradient-danger text-white">
                    <div class="card-body">
                        <h6 class="mb-0">Toplam Gider</h6>
                        <h2 class="mb-0">{{ number_format($rapor['toplam_gider'], 2, ',', '.') }} ₺</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-gradient-primary text-white">
                    <div class="card-body">
                        <h6 class="mb-0">Net Kar</h6>
                        <h2 class="mb-0">{{ number_format($rapor['net_kar'], 2, ',', '.') }} ₺</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-chart-line mr-2"></i>Gelir-Gider Trendi</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="finansalTrendChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-arrow-up text-success mr-2"></i>Gelirler</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Tarih</th>
                                        <th>Başlık</th>
                                        <th>Tutar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rapor['gelirler']->take(10) as $gelir)
                                    <tr>
                                        <td>{{ $gelir->tarih->format('d.m.Y') }}</td>
                                        <td>{{ $gelir->baslik }}</td>
                                        <td class="text-success">{{ number_format($gelir->tutar, 2, ',', '.') }} ₺</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="fas fa-arrow-down text-danger mr-2"></i>Giderler</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Tarih</th>
                                        <th>Başlık</th>
                                        <th>Tutar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rapor['giderler']->take(10) as $gider)
                                    <tr>
                                        <td>{{ $gider->tarih->format('d.m.Y') }}</td>
                                        <td>{{ $gider->baslik }}</td>
                                        <td class="text-danger">{{ number_format($gider->tutar, 2, ',', '.') }} ₺</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @elseif($tip == 'musteri')
        <!-- Müşteri Raporu -->
        <div class="row mb-3">
            <div class="col-md-6">
                <div class="card bg-gradient-primary text-white">
                    <div class="card-body">
                        <h6 class="mb-0">Toplam Müşteri</h6>
                        <h2 class="mb-0">{{ $rapor['toplam_musteri'] }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card bg-gradient-success text-white">
                    <div class="card-body">
                        <h6 class="mb-0">Aktif Müşteri</h6>
                        <h2 class="mb-0">{{ $rapor['aktif_musteri'] }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-chart-bar mr-2"></i>En Çok Harcama Yapan Müşteriler</h5>
            </div>
            <div class="card-body">
                <canvas id="musteriChart" height="100"></canvas>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5><i class="fas fa-table mr-2"></i>Müşteri Detayları</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Müşteri</th>
                                <th>Sipariş Sayısı</th>
                                <th>Toplam Harcama</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rapor['musteri_bazli'] as $musteri)
                            <tr>
                                <td>{{ $musteri['ad'] }}</td>
                                <td><span class="badge badge-info">{{ $musteri['siparis_sayisi'] }}</span></td>
                                <td><strong>{{ number_format($musteri['toplam_harcama'], 2, ',', '.') }} ₺</strong></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    @elseif($tip == 'marka')
        <!-- Marka Raporu -->
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="card bg-gradient-primary text-white">
                    <div class="card-body">
                        <h6 class="mb-0">Toplam Marka</h6>
                        <h2 class="mb-0">{{ $rapor['toplam_marka'] }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5><i class="fas fa-chart-bar mr-2"></i>Marka Bazlı Satışlar</h5>
            </div>
            <div class="card-body">
                <canvas id="markaChart" height="100"></canvas>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5><i class="fas fa-table mr-2"></i>Marka Detayları</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Marka</th>
                                <th>Sipariş Sayısı</th>
                                <th>Toplam Tutar</th>
                                <th>Toplam Borç</th>
                                <th>Ödenen</th>
                                <th>Kalan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rapor['marka_bazli'] as $marka)
                            <tr>
                                <td><strong>{{ $marka['ad'] }}</strong></td>
                                <td><span class="badge badge-info">{{ $marka['siparis_sayisi'] }}</span></td>
                                <td>{{ number_format($marka['toplam_tutar'], 2, ',', '.') }} ₺</td>
                                <td>{{ number_format($marka['toplam_borc'], 2, ',', '.') }} ₺</td>
                                <td class="text-success">{{ number_format($marka['odenen_tutar'], 2, ',', '.') }} ₺</td>
                                <td class="{{ $marka['kalan_tutar'] > 0 ? 'text-danger' : 'text-success' }}">
                                    {{ number_format($marka['kalan_tutar'], 2, ',', '.') }} ₺
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
@stop

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.css">
<style>
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
    .bg-gradient-danger {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%) !important;
    }
    .card {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border: none;
    }
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    @if($tip == 'satis')
    // Kargo Durumları Grafiği
    const durumCtx = document.getElementById('durumChart').getContext('2d');
    new Chart(durumCtx, {
        type: 'doughnut',
        data: {
            labels: ['Hazırlanan', 'Yolda', 'Teslim Edilen'],
            datasets: [{
                data: [
                    {{ $rapor['hazirlanan'] }},
                    {{ $rapor['yolda'] }},
                    {{ $rapor['teslim_edilen'] }}
                ],
                backgroundColor: ['#17a2b8', '#ffc107', '#28a745']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Satış Trendi Grafiği
    const satisTrendCtx = document.getElementById('satisTrendChart').getContext('2d');
    const gunlukVeriler = @json($rapor['gunluk_veriler'] ?? []);
    new Chart(satisTrendCtx, {
        type: 'line',
        data: {
            labels: gunlukVeriler.map(v => v.tarih),
            datasets: [{
                label: 'Günlük Satış',
                data: gunlukVeriler.map(v => v.tutar),
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    @elseif($tip == 'kargo')
    // Kargo Durum Grafiği
    const kargoDurumCtx = document.getElementById('kargoDurumChart').getContext('2d');
    new Chart(kargoDurumCtx, {
        type: 'pie',
        data: {
            labels: ['Hazırlanan', 'Yolda', 'Teslim Edilen'],
            datasets: [{
                data: [
                    {{ $rapor['durum_bazli']['hazirlanan'] }},
                    {{ $rapor['durum_bazli']['yolda'] }},
                    {{ $rapor['durum_bazli']['teslim_edilen'] }}
                ],
                backgroundColor: ['#17a2b8', '#ffc107', '#28a745']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    // Firma Bazlı Grafik
    const firmaCtx = document.getElementById('firmaChart').getContext('2d');
    const firmaVeriler = @json($rapor['firma_bazli'] ?? []);
    new Chart(firmaCtx, {
        type: 'bar',
        data: {
            labels: Object.keys(firmaVeriler),
            datasets: [{
                label: 'Kargo Sayısı',
                data: Object.values(firmaVeriler).map(f => f.sayi),
                backgroundColor: '#4facfe'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    @elseif($tip == 'finansal')
    // Finansal Trend Grafiği
    const finansalTrendCtx = document.getElementById('finansalTrendChart').getContext('2d');
    const finansalVeriler = @json($rapor['gunluk_veriler'] ?? []);
    new Chart(finansalTrendCtx, {
        type: 'line',
        data: {
            labels: finansalVeriler.map(v => v.tarih),
            datasets: [{
                label: 'Gelir',
                data: finansalVeriler.map(v => v.gelir),
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                tension: 0.4
            }, {
                label: 'Gider',
                data: finansalVeriler.map(v => v.gider),
                borderColor: '#dc3545',
                backgroundColor: 'rgba(220, 53, 69, 0.1)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    @elseif($tip == 'musteri')
    // Müşteri Grafiği
    const musteriCtx = document.getElementById('musteriChart').getContext('2d');
    const musteriVeriler = @json($rapor['musteri_bazli'] ?? []);
    new Chart(musteriCtx, {
        type: 'bar',
        data: {
            labels: musteriVeriler.map(m => m.ad),
            datasets: [{
                label: 'Toplam Harcama',
                data: musteriVeriler.map(m => m.toplam_harcama),
                backgroundColor: '#667eea'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    @elseif($tip == 'marka')
    // Marka Grafiği
    const markaCtx = document.getElementById('markaChart').getContext('2d');
    const markaVeriler = @json($rapor['marka_bazli'] ?? []);
    new Chart(markaCtx, {
        type: 'bar',
        data: {
            labels: markaVeriler.map(m => m.ad),
            datasets: [{
                label: 'Toplam Tutar',
                data: markaVeriler.map(m => m.toplam_tutar),
                backgroundColor: '#f5576c'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    @endif
</script>
@stop
