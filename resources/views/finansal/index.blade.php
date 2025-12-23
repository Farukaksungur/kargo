@extends('adminlte::page')

@section('title', 'Finansal Yönetim')

@section('content_header')
    <h1><i class="fas fa-money-bill-wave mr-2"></i>Finansal Yönetim</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="card bg-gradient-primary">
                <div class="card-body">
                    <h5>Bugün Gelir</h5>
                    <h3>{{ number_format($bugunGelir, 2, ',', '.') }} ₺</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-gradient-danger">
                <div class="card-body">
                    <h5>Bugün Gider</h5>
                    <h3>{{ number_format($bugunGider, 2, ',', '.') }} ₺</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-gradient-success">
                <div class="card-body">
                    <h5>Aylık Gelir</h5>
                    <h3>{{ number_format($aylikGelir, 2, ',', '.') }} ₺</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-gradient-warning">
                <div class="card-body">
                    <h5>Aylık Gider</h5>
                    <h3>{{ number_format($aylikGider, 2, ',', '.') }} ₺</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Son Gelirler</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tarih</th>
                                <th>Başlık</th>
                                <th>Tutar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sonGelirler as $gelir)
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
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Son Giderler</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tarih</th>
                                <th>Başlık</th>
                                <th>Tutar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sonGiderler as $gider)
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
@stop

