@extends('adminlte::page')

@section('title', 'Kargo Firması Ayarları')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-truck mr-2"></i>Kargo Firması Ayarları</h1>
        <a href="{{ route('kargo-firmalari.edit', $kargoFirmasi->id) }}" class="btn btn-primary">
            <i class="fas fa-edit mr-2"></i>Düzenle
        </a>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Firma Bilgileri</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Firma Adı</label>
                        <p class="mb-0 font-weight-bold">{{ $kargoFirmasi->ad }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">Kod</label>
                        <p class="mb-0">{{ $kargoFirmasi->kod }}</p>
                    </div>
                    @if($kargoFirmasi->telefon)
                    <div class="mb-3">
                        <label class="text-muted small">Telefon</label>
                        <p class="mb-0">{{ $kargoFirmasi->telefon }}</p>
                    </div>
                    @endif
                    @if($kargoFirmasi->email)
                    <div class="mb-3">
                        <label class="text-muted small">Email</label>
                        <p class="mb-0">{{ $kargoFirmasi->email }}</p>
                    </div>
                    @endif
                    @if($kargoFirmasi->varsayilan_ucret)
                    <div class="mb-3">
                        <label class="text-muted small">Varsayılan Ücret</label>
                        <p class="mb-0">{{ number_format($kargoFirmasi->varsayilan_ucret, 2, ',', '.') }} ₺</p>
                    </div>
                    @endif
                    <div class="mb-3">
                        <label class="text-muted small">Durum</label>
                        <p class="mb-0">
                            @if($kargoFirmasi->aktif)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-danger">Pasif</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>API Bilgileri</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">API Key</label>
                        <p class="mb-0">
                            @if($kargoFirmasi->api_key)
                                <code class="bg-light p-2 d-block">{{ substr($kargoFirmasi->api_key, 0, 20) }}...</code>
                            @else
                                <span class="text-muted">Belirtilmemiş</span>
                            @endif
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted small">API Secret</label>
                        <p class="mb-0">
                            @if($kargoFirmasi->api_secret)
                                <code class="bg-light p-2 d-block">{{ substr($kargoFirmasi->api_secret, 0, 20) }}...</code>
                            @else
                                <span class="text-muted">Belirtilmemiş</span>
                            @endif
                        </p>
                    </div>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i>
                        API bilgilerini düzenlemek için "Düzenle" butonuna tıklayın.
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
