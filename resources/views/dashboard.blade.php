@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0"><i class="fas fa-chart-line mr-2"></i>Kargo İstatistikleri</h1>
        <div class="text-right">
            <div id="live-clock" class="text-primary font-weight-bold" style="font-size: 18px;">
                <i class="fas fa-clock mr-2"></i>
                <span id="clock-time">--:--:--</span>
            </div>
            <div class="text-muted small">
                <span id="clock-date">{{ \Carbon\Carbon::now()->locale('tr')->isoFormat('dddd, D MMMM YYYY') }}</span>
            </div>
        </div>
    </div>
@stop

@section('content')
    <!-- Genel Özet Kartları -->
    <div class="row mb-3">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="mini-stat-card mini-stat-card-primary">
                <div class="mini-stat-content">
                    <div class="mini-stat-icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <div class="mini-stat-info">
                        <h4 class="mini-stat-number">{{ $toplamKargo }}</h4>
                        <p class="mini-stat-label">Toplam Kargo</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="mini-stat-card mini-stat-card-info">
                <div class="mini-stat-content">
                    <div class="mini-stat-icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <div class="mini-stat-info">
                        <h4 class="mini-stat-number">{{ $hazirlananToplam }}</h4>
                        <p class="mini-stat-label">Hazırlanıyor</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="mini-stat-card mini-stat-card-warning">
                <div class="mini-stat-content">
                    <div class="mini-stat-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <div class="mini-stat-info">
                        <h4 class="mini-stat-number">{{ $yoldaToplam }}</h4>
                        <p class="mini-stat-label">Yolda</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="mini-stat-card mini-stat-card-success">
                <div class="mini-stat-content">
                    <div class="mini-stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="mini-stat-info">
                        <h4 class="mini-stat-number">{{ $teslimEdilenToplam }}</h4>
                        <p class="mini-stat-label">Teslim Edildi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Günlük İstatistikler -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-2">
                    <h6 class="mb-0 text-primary font-weight-bold">
                        <i class="far fa-calendar-alt mr-2"></i>Günlük İstatistikler
                    </h6>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="stat-card-compact stat-card-info">
                                <div class="stat-card-content-compact">
                                    <div class="stat-card-icon-compact">
                                        <i class="fas fa-box-open"></i>
                                    </div>
                                    <div class="stat-card-info-compact">
                                        <h5 class="stat-card-number-compact">{{ $istatistikler['gunluk']['hazirlanan'] }}</h5>
                                        <p class="stat-card-label-compact">Hazırlanan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="stat-card-compact stat-card-warning">
                                <div class="stat-card-content-compact">
                                    <div class="stat-card-icon-compact">
                                        <i class="fas fa-shipping-fast"></i>
                                    </div>
                                    <div class="stat-card-info-compact">
                                        <h5 class="stat-card-number-compact">{{ $istatistikler['gunluk']['yolda'] }}</h5>
                                        <p class="stat-card-label-compact">Yolda</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="stat-card-compact stat-card-success">
                                <div class="stat-card-content-compact">
                                    <div class="stat-card-icon-compact">
                                        <i class="fas fa-check-double"></i>
                                    </div>
                                    <div class="stat-card-info-compact">
                                        <h5 class="stat-card-number-compact">{{ $istatistikler['gunluk']['teslim_edilen'] }}</h5>
                                        <p class="stat-card-label-compact">Teslim Edilen</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Haftalık ve Aylık İstatistikler -->
    <div class="row mb-3">
        <div class="col-lg-6 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-2">
                    <h6 class="mb-0 text-success font-weight-bold">
                        <i class="far fa-calendar-check mr-2"></i>Haftalık İstatistikler
                    </h6>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-4 mb-2">
                            <div class="stat-card-compact stat-card-info">
                                <div class="stat-card-content-compact">
                                    <div class="stat-card-icon-compact">
                                        <i class="fas fa-box-open"></i>
                                    </div>
                                    <div class="stat-card-info-compact">
                                        <h5 class="stat-card-number-compact">{{ $istatistikler['haftalik']['hazirlanan'] }}</h5>
                                        <p class="stat-card-label-compact">Hazırlanan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 mb-2">
                            <div class="stat-card-compact stat-card-warning">
                                <div class="stat-card-content-compact">
                                    <div class="stat-card-icon-compact">
                                        <i class="fas fa-shipping-fast"></i>
                                    </div>
                                    <div class="stat-card-info-compact">
                                        <h5 class="stat-card-number-compact">{{ $istatistikler['haftalik']['yolda'] }}</h5>
                                        <p class="stat-card-label-compact">Yolda</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 mb-2">
                            <div class="stat-card-compact stat-card-success">
                                <div class="stat-card-content-compact">
                                    <div class="stat-card-icon-compact">
                                        <i class="fas fa-check-double"></i>
                                    </div>
                                    <div class="stat-card-info-compact">
                                        <h5 class="stat-card-number-compact">{{ $istatistikler['haftalik']['teslim_edilen'] }}</h5>
                                        <p class="stat-card-label-compact">Teslim</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-2">
                    <h6 class="mb-0 text-warning font-weight-bold">
                        <i class="far fa-calendar mr-2"></i>Aylık İstatistikler
                    </h6>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-4 mb-2">
                            <div class="stat-card-compact stat-card-info">
                                <div class="stat-card-content-compact">
                                    <div class="stat-card-icon-compact">
                                        <i class="fas fa-box-open"></i>
                                    </div>
                                    <div class="stat-card-info-compact">
                                        <h5 class="stat-card-number-compact">{{ $istatistikler['aylik']['hazirlanan'] }}</h5>
                                        <p class="stat-card-label-compact">Hazırlanan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 mb-2">
                            <div class="stat-card-compact stat-card-warning">
                                <div class="stat-card-content-compact">
                                    <div class="stat-card-icon-compact">
                                        <i class="fas fa-shipping-fast"></i>
                                    </div>
                                    <div class="stat-card-info-compact">
                                        <h5 class="stat-card-number-compact">{{ $istatistikler['aylik']['yolda'] }}</h5>
                                        <p class="stat-card-label-compact">Yolda</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 mb-2">
                            <div class="stat-card-compact stat-card-success">
                                <div class="stat-card-content-compact">
                                    <div class="stat-card-icon-compact">
                                        <i class="fas fa-check-double"></i>
                                    </div>
                                    <div class="stat-card-info-compact">
                                        <h5 class="stat-card-number-compact">{{ $istatistikler['aylik']['teslim_edilen'] }}</h5>
                                        <p class="stat-card-label-compact">Teslim</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Son Kargolar ve Teslim Oranı -->
    <div class="row">
        <div class="col-lg-8 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-2">
                    <h6 class="mb-0 font-weight-bold">
                        <i class="fas fa-list mr-2"></i>Son Eklenen Kargolar
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0">Takip No</th>
                                    <th class="border-0">Alıcı</th>
                                    <th class="border-0">Durum</th>
                                    <th class="border-0">Tarih</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sonKargolar as $kargo)
                                <tr>
                                    <td><strong>{{ $kargo->takip_no }}</strong></td>
                                    <td>{{ $kargo->alici_ad ?? '-' }}</td>
                                    <td>
                                        @if($kargo->durum == 'hazirlaniyor')
                                            <span class="badge badge-info">Hazırlanıyor</span>
                                        @elseif($kargo->durum == 'yolda')
                                            <span class="badge badge-warning">Yolda</span>
                                        @else
                                            <span class="badge badge-success">Teslim Edildi</span>
                                        @endif
                                    </td>
                                    <td><small class="text-muted">{{ $kargo->created_at->format('d.m.Y H:i') }}</small></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">Henüz kargo kaydı bulunmamaktadır.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-2">
                    <h6 class="mb-0 font-weight-bold">
                        <i class="fas fa-percentage mr-2"></i>Bu Ay Teslim Oranı
                    </h6>
                </div>
                <div class="card-body text-center py-4">
                    <div class="teslim-orani">
                        <h2 class="mb-0 text-success">{{ $teslimOrani }}%</h2>
                        <p class="text-muted mb-0 mt-2">Teslim Başarı Oranı</p>
                        <div class="progress mt-3" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $teslimOrani }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        :root {
            --card-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            --card-shadow-hover: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        body {
            background-color: #f8f9fa;
        }

        .card {
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .card-header {
            border-radius: 10px 10px 0 0 !important;
        }

        /* Mini Stat Cards */
        .mini-stat-card {
            background: #ffffff;
            border-radius: 10px;
            padding: 16px;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .mini-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: var(--card-shadow-hover);
        }

        .mini-stat-content {
            display: flex;
            align-items: center;
        }

        .mini-stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 20px;
            flex-shrink: 0;
        }

        .mini-stat-info {
            flex: 1;
        }

        .mini-stat-number {
            font-size: 24px;
            font-weight: 700;
            margin: 0 0 4px 0;
            line-height: 1.2;
        }

        .mini-stat-label {
            font-size: 12px;
            color: #6c757d;
            margin: 0;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .mini-stat-card-primary .mini-stat-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .mini-stat-card-primary .mini-stat-number { color: #667eea; }

        .mini-stat-card-info .mini-stat-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .mini-stat-card-info .mini-stat-number { color: #667eea; }

        .mini-stat-card-warning .mini-stat-icon {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }
        .mini-stat-card-warning .mini-stat-number { color: #f5576c; }

        .mini-stat-card-success .mini-stat-icon {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }
        .mini-stat-card-success .mini-stat-number { color: #00c9ff; }

        /* Compact Stat Cards */
        .stat-card-compact {
            background: #ffffff;
            border-radius: 8px;
            padding: 0;
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        .stat-card-compact:hover {
            transform: translateY(-2px);
            box-shadow: var(--card-shadow-hover);
        }

        .stat-card-content-compact {
            padding: 12px;
            display: flex;
            align-items: center;
        }

        .stat-card-icon-compact {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 16px;
            flex-shrink: 0;
        }

        .stat-card-info-compact {
            flex: 1;
        }

        .stat-card-number-compact {
            font-size: 20px;
            font-weight: 700;
            margin: 0 0 2px 0;
            line-height: 1.2;
        }

        .stat-card-label-compact {
            font-size: 11px;
            color: #6c757d;
            margin: 0;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card-compact.stat-card-info .stat-card-icon-compact {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .stat-card-compact.stat-card-info .stat-card-number-compact { color: #667eea; }

        .stat-card-compact.stat-card-warning .stat-card-icon-compact {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }
        .stat-card-compact.stat-card-warning .stat-card-number-compact { color: #f5576c; }

        .stat-card-compact.stat-card-success .stat-card-icon-compact {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }
        .stat-card-compact.stat-card-success .stat-card-number-compact { color: #00c9ff; }

        /* Table */
        .table {
            font-size: 14px;
        }

        .table thead th {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Teslim Oranı */
        .teslim-orani h2 {
            font-size: 48px;
            font-weight: 700;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .mini-stat-number {
                font-size: 20px;
            }
            .mini-stat-icon {
                width: 40px;
                height: 40px;
                font-size: 18px;
            }
            .stat-card-number-compact {
                font-size: 18px;
            }
        }
    </style>
@stop

@section('js')
    @include('includes.scripts')
    <script>
        // Canlı saat (Türkiye Saati - UTC+3)
        function updateClock() {
            const now = new Date();
            // Türkiye saati için UTC+3 offset ekle
            const turkiyeOffset = 3 * 60; // UTC+3 = 180 dakika
            const localTime = now.getTime();
            const localOffset = now.getTimezoneOffset() * 60000; // dakika cinsinden offset
            const utcTime = localTime + localOffset;
            const turkiyeTime = new Date(utcTime + (turkiyeOffset * 60000));
            
            const hours = String(turkiyeTime.getHours()).padStart(2, '0');
            const minutes = String(turkiyeTime.getMinutes()).padStart(2, '0');
            const seconds = String(turkiyeTime.getSeconds()).padStart(2, '0');
            
            const timeString = hours + ':' + minutes + ':' + seconds;
            const clockTime = document.getElementById('clock-time');
            if (clockTime) {
                clockTime.textContent = timeString;
            }
            
            // Tarih güncellemesi
            const days = ['Pazar', 'Pazartesi', 'Salı', 'Çarşamba', 'Perşembe', 'Cuma', 'Cumartesi'];
            const months = ['Ocak', 'Şubat', 'Mart', 'Nisan', 'Mayıs', 'Haziran', 'Temmuz', 'Ağustos', 'Eylül', 'Ekim', 'Kasım', 'Aralık'];
            
            const dayName = days[turkiyeTime.getDay()];
            const day = turkiyeTime.getDate();
            const month = months[turkiyeTime.getMonth()];
            const year = turkiyeTime.getFullYear();
            
            const dateString = dayName + ', ' + day + ' ' + month + ' ' + year;
            const clockDate = document.getElementById('clock-date');
            if (clockDate) {
                clockDate.textContent = dateString;
            }
        }
        
        // İlk güncelleme
        updateClock();
        // Her saniye güncelle
        setInterval(updateClock, 1000);
        
        // Sayıları animasyonlu göster
        document.addEventListener('DOMContentLoaded', function() {
            const numbers = document.querySelectorAll('.stat-card-number-compact, .mini-stat-number');
            numbers.forEach(number => {
                const finalValue = parseInt(number.textContent);
                if (!isNaN(finalValue) && finalValue > 0) {
                    let currentValue = 0;
                    const increment = finalValue / 20;
                    const timer = setInterval(() => {
                        currentValue += increment;
                        if (currentValue >= finalValue) {
                            number.textContent = finalValue;
                            clearInterval(timer);
                        } else {
                            number.textContent = Math.floor(currentValue);
                        }
                    }, 30);
                }
            });
        });
    </script>
@stop
