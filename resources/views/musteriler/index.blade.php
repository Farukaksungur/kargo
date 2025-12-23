@extends('adminlte::page')

@section('title', 'Müşteriler')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="m-0"><i class="fas fa-users mr-2"></i>Müşteriler</h1>
        <div>
            <a href="{{ route('musteriler.create') }}" class="btn btn-primary mr-2">
                <i class="fas fa-plus mr-2"></i>Yeni Müşteri Ekle
            </a>
            <a href="{{ route('musteriler.excel') }}" class="btn btn-success">
                <i class="fas fa-file-excel mr-2"></i>Excel İndir
            </a>
        </div>
    </div>
@stop

@section('content')
    <!-- Müşteriler Tablosu -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 font-weight-bold">Müşteri Listesi</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0">Ad Soyad</th>
                                    <th class="border-0">Telefon</th>
                                    <th class="border-0">Adres</th>
                                    <th class="border-0 text-center">Ürün Sayısı</th>
                                    <th class="border-0 text-right">Toplam Harcama</th>
                                    <th class="border-0 text-center">Durum</th>
                                    <th class="border-0 text-center">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($musteriler as $musteri)
                                <tr>
                                    <td>
                                        <strong class="text-primary">{{ $musteri->ad }} {{ $musteri->soyad }}</strong>
                                        @if($musteri->email)
                                            <br><small class="text-muted">{{ $musteri->email }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $musteri->telefon ?? '-' }}</td>
                                    <td>
                                        @if($musteri->il || $musteri->ilce)
                                            {{ $musteri->il ?? '' }}{{ $musteri->il && $musteri->ilce ? '/' : '' }}{{ $musteri->ilce ?? '' }}
                                            @if($musteri->adres)
                                                <br><small class="text-muted">{{ Str::limit($musteri->adres, 50) }}</small>
                                            @endif
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge badge-info badge-lg">{{ $musteri->kargolar_count }}</span>
                                    </td>
                                    <td class="text-right">
                                        @php
                                            $toplam = $musteri->kargolar->sum('tutar') + $musteri->kargolar->sum('kargo_ucreti');
                                        @endphp
                                        <strong class="text-success">{{ number_format($toplam, 2, ',', '.') }} ₺</strong>
                                    </td>
                                    <td class="text-center">
                                        @if($musteri->aktif)
                                            <span class="badge badge-success">Aktif</span>
                                        @else
                                            <span class="badge badge-secondary">Pasif</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('musteriler.show', $musteri->id) }}" class="btn btn-sm btn-info" title="Detay">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('musteriler.edit', $musteri->id) }}" class="btn btn-sm btn-warning" title="Düzenle">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger" 
                                                    title="Sil"
                                                    onclick="deleteMusteri({{ $musteri->id }}, '{{ $musteri->ad }} {{ $musteri->soyad }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <form id="delete-form-{{ $musteri->id }}" action="{{ route('musteriler.destroy', $musteri->id) }}" method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-2x mb-2"></i>
                                        <p class="mb-0">Henüz müşteri kaydı bulunmamaktadır.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .badge-lg {
            padding: 8px 12px;
            font-size: 13px;
        }

        .table-row-clickable:hover {
            background-color: #f8f9fa !important;
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
    </style>
@stop

@section('js')
    @include('includes.scripts')
    <script>
        function deleteMusteri(id, name) {
            confirmDelete(id, name, `/musteriler/${id}`, 'müşteri');
        }
    </script>
@stop

