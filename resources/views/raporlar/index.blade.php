@extends('adminlte::page')

@section('title', 'Raporlar ve Analitik')

@section('content_header')
    <h1><i class="fas fa-chart-bar mr-2"></i>Raporlar ve Analitik</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="fas fa-shopping-cart fa-3x text-primary"></i>
                    </div>
                    <h5 class="mb-3">Satış Raporu</h5>
                    <p class="text-muted small mb-3">Sipariş ve satış istatistiklerini görüntüleyin</p>
                    <a href="{{ route('raporlar.olustur', 'satis') }}" class="btn btn-primary btn-block">
                        <i class="fas fa-chart-line mr-2"></i>Raporu Görüntüle
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="fas fa-box fa-3x text-info"></i>
                    </div>
                    <h5 class="mb-3">Kargo Raporu</h5>
                    <p class="text-muted small mb-3">Kargo durumları ve firma bazlı analizler</p>
                    <a href="{{ route('raporlar.olustur', 'kargo') }}" class="btn btn-info btn-block">
                        <i class="fas fa-chart-pie mr-2"></i>Raporu Görüntüle
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="fas fa-money-bill-wave fa-3x text-success"></i>
                    </div>
                    <h5 class="mb-3">Finansal Rapor</h5>
                    <p class="text-muted small mb-3">Gelir, gider ve kar analizleri</p>
                    <a href="{{ route('raporlar.olustur', 'finansal') }}" class="btn btn-success btn-block">
                        <i class="fas fa-chart-area mr-2"></i>Raporu Görüntüle
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="fas fa-users fa-3x text-warning"></i>
                    </div>
                    <h5 class="mb-3">Müşteri Raporu</h5>
                    <p class="text-muted small mb-3">Müşteri analizleri ve harcama istatistikleri</p>
                    <a href="{{ route('raporlar.olustur', 'musteri') }}" class="btn btn-warning btn-block">
                        <i class="fas fa-chart-bar mr-2"></i>Raporu Görüntüle
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center p-4">
                    <div class="mb-3">
                        <i class="fas fa-tags fa-3x text-danger"></i>
                    </div>
                    <h5 class="mb-3">Marka Raporu</h5>
                    <p class="text-muted small mb-3">Marka bazlı satış ve borç analizleri</p>
                    <a href="{{ route('raporlar.olustur', 'marka') }}" class="btn btn-danger btn-block">
                        <i class="fas fa-chart-bar mr-2"></i>Raporu Görüntüle
                    </a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
    }
</style>
@stop


