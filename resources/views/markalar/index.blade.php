@extends('adminlte::page')

@section('title', 'Markalar')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0"><i class="fas fa-tags mr-2"></i>Markalar</h1>
        <div>
            <a href="{{ route('markalar.create') }}" class="btn btn-primary mr-2">
                <i class="fas fa-plus mr-2"></i>Yeni Marka Ekle
            </a>
            <a href="{{ route('markalar.excel') }}" class="btn btn-success">
                <i class="fas fa-file-excel mr-2"></i>Excel İndir
            </a>
        </div>
    </div>
@stop

@section('content')
    <!-- Özet Kartları -->
    <div class="row mb-3">
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card shadow-sm border-0 bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0 text-white-50">Toplam Borç</h6>
                            <h3 class="mb-0 mt-2">{{ number_format($toplamBorc, 2, ',', '.') }} ₺</h3>
                        </div>
                        <div class="icon-circle">
                            <i class="fas fa-money-bill-wave fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card shadow-sm border-0 bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0 text-white-50">Toplam Ödenen</h6>
                            <h3 class="mb-0 mt-2">{{ number_format($toplamOdenen, 2, ',', '.') }} ₺</h3>
                        </div>
                        <div class="icon-circle">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 mb-3">
            <div class="card shadow-sm border-0 bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0 text-white-50">Toplam Kalan</h6>
                            <h3 class="mb-0 mt-2">{{ number_format($toplamKalan, 2, ',', '.') }} ₺</h3>
                        </div>
                        <div class="icon-circle">
                            <i class="fas fa-exclamation-triangle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Markalar Tablosu -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 font-weight-bold">Marka Listesi</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0">Marka Adı</th>
                                    <th class="border-0">Firma Adı</th>
                                    <th class="border-0">Telefon</th>
                                    <th class="border-0 text-right">Toplam Borç</th>
                                    <th class="border-0 text-right">Ödenen Tutar</th>
                                    <th class="border-0 text-right">Kalan Tutar</th>
                                    <th class="border-0 text-center">Durum</th>
                                    <th class="border-0 text-center">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($markalar as $marka)
                                <tr>
                                    <td>
                                        <a href="{{ route('markalar.show', $marka->id) }}" class="text-primary font-weight-bold">
                                            {{ $marka->ad }}
                                        </a>
                                    </td>
                                    <td>{{ $marka->firma_adi ?? '-' }}</td>
                                    <td>{{ $marka->telefon ?? '-' }}</td>
                                    <td class="text-right">
                                        <span class="text-primary font-weight-bold">{{ number_format($marka->toplam_borc, 2, ',', '.') }} ₺</span>
                                    </td>
                                    <td class="text-right">
                                        <span class="text-success font-weight-bold">{{ number_format($marka->odenen_tutar, 2, ',', '.') }} ₺</span>
                                    </td>
                                    <td class="text-right">
                                        @if($marka->kalan_tutar > 0)
                                            <span class="text-danger font-weight-bold">{{ number_format($marka->kalan_tutar, 2, ',', '.') }} ₺</span>
                                        @else
                                            <span class="text-success font-weight-bold">{{ number_format($marka->kalan_tutar, 2, ',', '.') }} ₺</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($marka->aktif)
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-secondary">Pasif</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('markalar.show', $marka->id) }}" class="btn btn-sm btn-info" title="Detay">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('markalar.edit', $marka->id) }}" class="btn btn-sm btn-warning" title="Düzenle">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    title="Sil"
                                                    onclick="deleteMarka({{ $marka->id }}, '{{ $marka->ad }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $marka->id }}" action="{{ route('markalar.destroy', $marka->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p class="mb-0">Henüz marka kaydı bulunmamaktadır.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                            @if($markalar->count() > 0)
                            <tfoot class="thead-light">
                                <tr>
                                    <th colspan="3" class="text-right">TOPLAM:</th>
                                    <th class="text-right text-primary">{{ number_format($toplamBorc, 2, ',', '.') }} ₺</th>
                                    <th class="text-right text-success">{{ number_format($toplamOdenen, 2, ',', '.') }} ₺</th>
                                    <th class="text-right text-danger">{{ number_format($toplamKalan, 2, ',', '.') }} ₺</th>
                                    <th></th>
                                    <th></th>
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
        .icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
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

        .card {
            border-radius: 10px;
        }
        .table-row-clickable:hover {
            background-color: #f8f9fa !important;
        }
    </style>
@stop

@section('js')
    @include('includes.scripts')
    <script>
        function deleteMarka(id, name) {
            confirmDelete(id, name, `/markalar/${id}`, 'marka');
        }
    </script>
@stop

