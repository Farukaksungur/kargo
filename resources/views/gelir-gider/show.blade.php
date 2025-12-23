@extends('adminlte::page')

@section('title', 'Gelir/Gider Detay')

@section('content_header')
    <h1><i class="fas fa-exchange-alt mr-2"></i>Gelir/Gider Detay</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Tip:</strong> 
                        @if($gelirGider->tip == 'gelir')
                            <span class="badge badge-success">Gelir</span>
                        @else
                            <span class="badge badge-danger">Gider</span>
                        @endif
                    </p>
                    <p><strong>Başlık:</strong> {{ $gelirGider->baslik }}</p>
                    <p><strong>Tarih:</strong> {{ $gelirGider->tarih->format('d.m.Y') }}</p>
                    <p><strong>Tutar:</strong> {{ number_format($gelirGider->tutar, 2, ',', '.') }} ₺</p>
                    <p><strong>Kategori:</strong> {{ $gelirGider->kategori ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Marka:</strong> {{ $gelirGider->marka ? $gelirGider->marka->ad : '-' }}</p>
                    <p><strong>Müşteri:</strong> {{ $gelirGider->musteri ? $gelirGider->musteri->ad . ' ' . $gelirGider->musteri->soyad : '-' }}</p>
                    <p><strong>Ödeme Yöntemi:</strong> {{ $gelirGider->odeme_yontemi ?? '-' }}</p>
                    <p><strong>Fatura No:</strong> {{ $gelirGider->fatura_no ?? '-' }}</p>
                </div>
            </div>
            @if($gelirGider->aciklama)
            <div class="mt-3">
                <strong>Açıklama:</strong>
                <p>{{ $gelirGider->aciklama }}</p>
            </div>
            @endif
            @if($gelirGider->notlar)
            <div class="mt-3">
                <strong>Notlar:</strong>
                <p>{{ $gelirGider->notlar }}</p>
            </div>
            @endif
            <div class="mt-3">
                <a href="{{ route('gelir-gider.index') }}" class="btn btn-secondary">Geri Dön</a>
            </div>
        </div>
    </div>
@stop

