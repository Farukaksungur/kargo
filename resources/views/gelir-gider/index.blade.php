@extends('adminlte::page')

@section('title', 'Gelir/Gider')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-exchange-alt mr-2"></i>Gelir/Gider Yönetimi</h1>
        <a href="{{ route('gelir-gider.create') }}" class="btn btn-primary">
            <i class="fas fa-plus mr-2"></i>Yeni Ekle
        </a>
    </div>
@stop

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white border-0 py-3">
            <h5 class="mb-0 font-weight-bold">Gelir/Gider Listesi</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-0">Tarih</th>
                            <th class="border-0">Tip</th>
                            <th class="border-0">Başlık</th>
                            <th class="border-0 text-right">Tutar</th>
                            <th class="border-0">Kategori</th>
                            <th class="border-0 text-center">İşlemler</th>
                        </tr>
                    </thead>
                <tbody>
                    @foreach($gelirGiderler as $item)
                    <tr>
                        <td>{{ $item->tarih->format('d.m.Y') }}</td>
                        <td>
                            @if($item->tip == 'gelir')
                                <span class="badge badge-success">Gelir</span>
                            @else
                                <span class="badge badge-danger">Gider</span>
                            @endif
                        </td>
                        <td><strong>{{ $item->baslik }}</strong></td>
                        <td class="text-right">
                            <strong class="{{ $item->tip == 'gelir' ? 'text-success' : 'text-danger' }}">
                                {{ number_format($item->tutar, 2, ',', '.') }} ₺
                            </strong>
                        </td>
                        <td>{{ $item->kategori ?? '-' }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('gelir-gider.show', $item->id) }}" class="btn btn-sm btn-info" title="Detay">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('gelir-gider.edit', $item->id) }}" class="btn btn-sm btn-warning" title="Düzenle">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" 
                                        class="btn btn-sm btn-danger" 
                                        title="Sil"
                                        onclick="deleteGelirGider({{ $item->id }}, '{{ $item->baslik }}')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <form id="delete-form-{{ $item->id }}" action="{{ route('gelir-gider.destroy', $item->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @if($gelirGiderler->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-2x mb-2"></i>
                            <p class="mb-0">Henüz gelir/gider kaydı bulunmamaktadır.</p>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
            </div>
            <div class="card-footer bg-white border-0">
                {{ $gelirGiderler->links() }}
            </div>
        </div>
    </div>
@stop

@section('js')
    @include('includes.scripts')
    <script>
        function deleteGelirGider(id, baslik) {
            confirmDelete(id, baslik, `/gelir-gider/${id}`, 'Gelir/Gider kaydı');
        }
    </script>
@stop

