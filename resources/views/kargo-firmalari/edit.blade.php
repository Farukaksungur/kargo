@extends('adminlte::page')

@section('title', 'Kargo Firması Düzenle')

@section('content_header')
    <h1><i class="fas fa-truck mr-2"></i>Kargo Firması Düzenle</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('kargo-firmalari.update', $kargoFirmasi->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <h5 class="mb-3">Firma Bilgileri</h5>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Firma Adı</label>
                            <input type="text" name="ad" class="form-control" value="{{ $kargoFirmasi->ad }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kod</label>
                            <input type="text" name="kod" class="form-control" value="{{ $kargoFirmasi->kod }}" required>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Telefon</label>
                            <input type="text" name="telefon" class="form-control" value="{{ $kargoFirmasi->telefon }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $kargoFirmasi->email }}">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Web Sitesi</label>
                            <input type="url" name="web_sitesi" class="form-control" value="{{ $kargoFirmasi->web_sitesi }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Varsayılan Ücret</label>
                            <input type="number" step="0.01" name="varsayilan_ucret" class="form-control" value="{{ $kargoFirmasi->varsayilan_ucret }}">
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Adres</label>
                    <textarea name="adres" class="form-control" rows="3">{{ $kargoFirmasi->adres }}</textarea>
                </div>
                
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" name="aktif" class="form-check-input" value="1" {{ $kargoFirmasi->aktif ? 'checked' : '' }}>
                        <label class="form-check-label">Aktif</label>
                    </div>
                </div>
                
                <hr class="my-4">
                
                <h5 class="mb-3">API Bilgileri</h5>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>API Key</label>
                            <input type="text" name="api_key" class="form-control" value="{{ $kargoFirmasi->api_key }}" placeholder="API Key giriniz">
                            <small class="form-text text-muted">Kargo firması API anahtarı</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>API Secret</label>
                            <input type="password" name="api_secret" class="form-control" placeholder="{{ $kargoFirmasi->api_secret ? 'Değiştirmek için yeni değer giriniz' : 'API Secret giriniz' }}">
                            <small class="form-text text-muted">
                                @if($kargoFirmasi->api_secret)
                                    Mevcut API Secret kayıtlı. Değiştirmek için yeni değer giriniz, aksi halde boş bırakın.
                                @else
                                    Kargo firması API gizli anahtarı
                                @endif
                            </small>
                        </div>
                    </div>
                </div>
                
                @if($kargoFirmasi->api_secret)
                <div class="alert alert-info">
                    <i class="fas fa-info-circle mr-2"></i>
                    <strong>Bilgi:</strong> API Secret değeri güvenlik nedeniyle gösterilmemektedir. Değiştirmek istemiyorsanız alanı boş bırakın.
                </div>
                @endif
                
                <div class="form-group">
                    <label>Notlar</label>
                    <textarea name="notlar" class="form-control" rows="3">{{ $kargoFirmasi->notlar }}</textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save mr-2"></i>Kaydet
                </button>
                <a href="{{ route('kargo-firmalari.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times mr-2"></i>İptal
                </a>
            </form>
        </div>
    </div>
@stop

@section('js')
<script>
    // API Secret için göster/gizle butonu
    document.addEventListener('DOMContentLoaded', function() {
        const apiSecretInput = document.querySelector('input[name="api_secret"]');
        if (apiSecretInput && apiSecretInput.value) {
            // Mevcut değer varsa, göster/gizle butonu ekle
            const wrapper = document.createElement('div');
            wrapper.className = 'input-group';
            apiSecretInput.parentNode.insertBefore(wrapper, apiSecretInput);
            wrapper.appendChild(apiSecretInput);
            
            const toggleBtn = document.createElement('button');
            toggleBtn.className = 'btn btn-outline-secondary';
            toggleBtn.type = 'button';
            toggleBtn.innerHTML = '<i class="fas fa-eye"></i>';
            toggleBtn.onclick = function() {
                if (apiSecretInput.type === 'password') {
                    apiSecretInput.type = 'text';
                    toggleBtn.innerHTML = '<i class="fas fa-eye-slash"></i>';
                } else {
                    apiSecretInput.type = 'password';
                    toggleBtn.innerHTML = '<i class="fas fa-eye"></i>';
                }
            };
            wrapper.appendChild(toggleBtn);
        }
    });
</script>
@stop

