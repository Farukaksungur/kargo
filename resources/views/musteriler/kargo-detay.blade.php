@extends('adminlte::page')

@section('title', 'Kargo Detay - ' . $kargo->takip_no)

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="m-0"><i class="fas fa-box mr-2"></i>Kargo Detay</h1>
            <small class="text-muted">Takip No: {{ $kargo->takip_no }}</small>
        </div>
        <a href="{{ route('musteriler.show', $musteri->id) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Geri Dön
        </a>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-8">
            <!-- Kargo Bilgileri -->
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="fas fa-info-circle mr-2"></i>Kargo Bilgileri
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small d-block">Takip Kodu</label>
                            <p class="mb-0 font-weight-bold text-primary" style="font-size: 16px;">{{ $kargo->takip_no }}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small d-block">Kargo Kodu</label>
                            <p class="mb-0 font-weight-bold">{!! $kargo->kargo_kodu ?? '<span class="text-muted">-</span>' !!}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small d-block">Durum</label>
                            <p class="mb-0">
                                @if($kargo->durum == 'hazirlaniyor')
                                    <span class="badge badge-info badge-lg">Hazırlanıyor</span>
                                @elseif($kargo->durum == 'yolda')
                                    <span class="badge badge-warning badge-lg">Yolda</span>
                                @else
                                    <span class="badge badge-success badge-lg">Teslim Edildi</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small d-block">Kargo Firması</label>
                            <p class="mb-0 font-weight-bold">{!! $kargo->kargo_firmasi ?? '<span class="text-muted">-</span>' !!}</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small d-block">Marka</label>
                            <p class="mb-0 font-weight-bold">
                                @if($kargo->marka)
                                    <span class="badge badge-primary">{{ $kargo->marka->ad }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small d-block">Ürün Tutarı</label>
                            <p class="mb-0 font-weight-bold text-primary" style="font-size: 16px;">
                                {!! $kargo->tutar ? number_format($kargo->tutar, 2, ',', '.') . ' ₺' : '<span class="text-muted">-</span>' !!}
                            </p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small d-block">Ödeme Tutarı</label>
                            <p class="mb-0 font-weight-bold text-success" style="font-size: 16px;">
                                {!! $kargo->odeme_tutari ? number_format($kargo->odeme_tutari, 2, ',', '.') . ' ₺' : '<span class="text-muted">-</span>' !!}
                            </p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="text-muted small d-block">Kargo Ücreti</label>
                            <p class="mb-0 font-weight-bold text-info" style="font-size: 16px;">
                                {!! $kargo->kargo_ucreti ? number_format($kargo->kargo_ucreti, 2, ',', '.') . ' ₺' : '<span class="text-muted">-</span>' !!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alıcı Bilgileri -->
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="fas fa-user mr-2"></i>Alıcı Bilgileri
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Ad</label>
                            <p class="mb-0 font-weight-bold">{{ $kargo->alici_ad ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Soyad</label>
                            <p class="mb-0 font-weight-bold">{{ $kargo->alici_soyad ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Telefon</label>
                            <p class="mb-0">{{ $kargo->alici_telefon ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">İl</label>
                            <p class="mb-0">{{ $kargo->il ?? '-' }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">İlçe</label>
                            <p class="mb-0">{{ $kargo->ilce ?? '-' }}</p>
                        </div>
                        @if($kargo->adres)
                        <div class="col-12 mb-3">
                            <label class="text-muted small">Adres</label>
                            <p class="mb-0">{{ $kargo->adres }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Ürün Bilgileri -->
            @if($kargo->urun_bilgisi)
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="fas fa-box-open mr-2"></i>Ürün Bilgileri
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $kargo->urun_bilgisi }}</p>
                </div>
            </div>
            @endif

            <!-- Notlar -->
            @if($kargo->notlar)
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="fas fa-sticky-note mr-2"></i>Notlar
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $kargo->notlar }}</p>
                </div>
            </div>
            @endif
        </div>

        <div class="col-lg-4">
            <!-- Finansal Özet -->
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="fas fa-money-bill-wave mr-2"></i>Finansal Özet
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small d-block">Ürün Tutarı</label>
                        <p class="mb-0 font-weight-bold text-primary" style="font-size: 16px;">
                            {!! $kargo->tutar ? number_format($kargo->tutar, 2, ',', '.') . ' ₺' : '<span class="text-muted">-</span>' !!}
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small d-block">Ödeme Tutarı</label>
                        <p class="mb-0 font-weight-bold text-success" style="font-size: 16px;">
                            {!! $kargo->odeme_tutari ? number_format($kargo->odeme_tutari, 2, ',', '.') . ' ₺' : '<span class="text-muted">-</span>' !!}
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small d-block">Kargo Ücreti</label>
                        <p class="mb-0 font-weight-bold text-info" style="font-size: 16px;">
                            {!! $kargo->kargo_ucreti ? number_format($kargo->kargo_ucreti, 2, ',', '.') . ' ₺' : '<span class="text-muted">-</span>' !!}
                        </p>
                    </div>
                    @if($kargo->tutar || $kargo->kargo_ucreti)
                    <div class="mb-3 pt-3 border-top">
                        <label class="text-muted small d-block">Toplam Tutar</label>
                        <p class="mb-0 font-weight-bold text-dark" style="font-size: 18px;">
                            {{ number_format(($kargo->tutar ?? 0) + ($kargo->kargo_ucreti ?? 0), 2, ',', '.') }} ₺
                        </p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Tarih Bilgileri -->
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="fas fa-calendar-alt mr-2"></i>Tarih Bilgileri
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small d-block">Oluşturulma Tarihi</label>
                        <p class="mb-0 font-weight-bold">{{ $kargo->created_at->format('d.m.Y H:i') }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small d-block">Hazırlanma Tarihi</label>
                        <p class="mb-0">
                            {!! $kargo->hazirlanma_tarihi ? $kargo->hazirlanma_tarihi->format('d.m.Y H:i') : '<span class="text-muted">-</span>' !!}
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small d-block">Kargolanma Tarihi</label>
                        <p class="mb-0">
                            @if($kargo->kargolanma_tarihi)
                                <span class="text-info font-weight-bold">{{ $kargo->kargolanma_tarihi->format('d.m.Y H:i') }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small d-block">Yola Çıkış Tarihi</label>
                        <p class="mb-0">
                            {!! $kargo->yola_cikis_tarihi ? $kargo->yola_cikis_tarihi->format('d.m.Y H:i') : '<span class="text-muted">-</span>' !!}
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small d-block">Teslim Tarihi</label>
                        <p class="mb-0">
                            @if($kargo->teslim_tarihi)
                                <span class="text-success font-weight-bold">{{ $kargo->teslim_tarihi->format('d.m.Y H:i') }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Hızlı İşlemler -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 font-weight-bold">
                        <i class="fas fa-bolt mr-2"></i>Hızlı İşlemler
                    </h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('musteriler.show', $musteri->id) }}" class="btn btn-primary btn-block mb-2">
                        <i class="fas fa-user mr-2"></i>Müşteri Detayına Dön
                    </a>
                    @if($kargo->marka)
                    <a href="{{ route('markalar.show', $kargo->marka->id) }}" class="btn btn-info btn-block mb-2">
                        <i class="fas fa-tag mr-2"></i>Marka Detayına Git
                    </a>
                    @endif
                    <button class="btn btn-secondary btn-block" onclick="window.print()">
                        <i class="fas fa-print mr-2"></i>Yazdır
                    </button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        @media print {
            .btn, .card-header {
                display: none !important;
            }
        }
        
        .badge-lg {
            padding: 8px 12px;
            font-size: 13px;
        }
        
        label.text-muted.small {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        
        .card-body p {
            min-height: 24px;
        }
    </style>
@stop

@section('js')
    <script>
        console.log('Kargo detay sayfası yüklendi');
    </script>
@stop

