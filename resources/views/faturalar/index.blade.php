@extends('adminlte::page')

@section('title', 'Faturalar')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-file-invoice mr-2"></i>Fatura Yönetimi</h1>
        <a href="{{ route('faturalar.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-2"></i>Yeni Fatura
        </a>
    </div>
@stop

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0 font-weight-bold">Fatura Listesi</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th class="border-0">Fatura No</th>
                        <th class="border-0">Tarih</th>
                        <th class="border-0">Müşteri</th>
                        <th class="border-0 text-right">Toplam</th>
                        <th class="border-0 text-center">Durum</th>
                        <th class="border-0 text-center">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($faturalar as $fatura)
                    <tr>
                        <td>{{ $fatura->fatura_no }}</td>
                        <td>{{ $fatura->tarih->format('d.m.Y') }}</td>
                        <td>{{ $fatura->musteri ? $fatura->musteri->ad . ' ' . $fatura->musteri->soyad : '-' }}</td>
                        <td class="text-right">
                            <strong class="text-primary">{{ number_format($fatura->genel_toplam, 2, ',', '.') }} ₺</strong>
                        </td>
                        <td>
                            @if($fatura->durum == 'odendi')
                                <span class="badge badge-success">Ödendi</span>
                            @elseif($fatura->durum == 'beklemede')
                                <span class="badge badge-warning">Beklemede</span>
                            @else
                                <span class="badge badge-danger">İptal</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('faturalar.show', $fatura->id) }}" class="btn btn-sm btn-info" title="Detay">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('faturalar.edit', $fatura->id) }}" class="btn btn-sm btn-warning" title="Düzenle">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-sm btn-danger" 
                                        title="Sil"
                                        onclick="deleteFatura({{ $fatura->id }}, '{{ $fatura->fatura_no }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <form id="delete-form-{{ $fatura->id }}" action="{{ route('faturalar.destroy', $fatura->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @if($faturalar->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-2x mb-2"></i>
                            <p class="mb-0">Henüz fatura kaydı bulunmamaktadır.</p>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
            </div>
            <div class="card-footer bg-white border-0">
                {{ $faturalar->links() }}
            </div>
        </div>
    </div>
@stop

@section('js')
    @include('includes.scripts')
    <script>
        function deleteFatura(id, faturaNo) {
            confirmDelete(id, faturaNo, `/faturalar/${id}`, 'fatura');
        }
    </script>
@stop

