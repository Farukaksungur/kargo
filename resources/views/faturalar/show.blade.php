@extends('adminlte::page')

@section('title', 'Fatura Detay')

@section('content_header')
    <h1><i class="fas fa-file-invoice mr-2"></i>Fatura Detay</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Fatura No:</strong> {{ $fatura->fatura_no }}</p>
                    <p><strong>Tarih:</strong> {{ $fatura->tarih->format('d.m.Y') }}</p>
                    <p><strong>Tip:</strong> {{ ucfirst($fatura->tip) }}</p>
                    <p><strong>Durum:</strong> 
                        @if($fatura->durum == 'odendi')
                            <span class="badge badge-success">Ödendi</span>
                        @elseif($fatura->durum == 'beklemede')
                            <span class="badge badge-warning">Beklemede</span>
                        @else
                            <span class="badge badge-danger">İptal</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>Marka:</strong> {{ $fatura->marka ? $fatura->marka->ad : '-' }}</p>
                    <p><strong>Müşteri:</strong> {{ $fatura->musteri ? $fatura->musteri->ad . ' ' . $fatura->musteri->soyad : '-' }}</p>
                    <p><strong>Ödeme Yöntemi:</strong> {{ $fatura->odeme_yontemi ?? '-' }}</p>
                    @if($fatura->vade_tarihi)
                    <p><strong>Vade Tarihi:</strong> {{ $fatura->vade_tarihi->format('d.m.Y') }}</p>
                    @endif
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4">
                    <p><strong>Ara Toplam:</strong> {{ number_format($fatura->ara_toplam, 2, ',', '.') }} ₺</p>
                </div>
                <div class="col-md-4">
                    <p><strong>KDV (%{{ $fatura->kdv_orani }}):</strong> {{ number_format($fatura->kdv_tutari, 2, ',', '.') }} ₺</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Genel Toplam:</strong> <span class="text-success font-weight-bold">{{ number_format($fatura->genel_toplam, 2, ',', '.') }} ₺</span></p>
                </div>
            </div>
            @if($fatura->notlar)
            <div class="mt-3">
                <strong>Notlar:</strong>
                <p>{{ $fatura->notlar }}</p>
            </div>
            @endif
            <div class="mt-3">
                <a href="{{ route('faturalar.index') }}" class="btn btn-secondary">Geri Dön</a>
            </div>
        </div>
    </div>
@stop

