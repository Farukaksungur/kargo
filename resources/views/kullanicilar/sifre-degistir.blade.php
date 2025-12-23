@extends('adminlte::page')

@section('title', 'Şifre Değiştir')

@section('content_header')
    <h1><i class="fas fa-key mr-2"></i>Şifre Değiştir</h1>
@stop

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('kullanicilar.sifre-guncelle') }}" method="POST">
                        @csrf
                        
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        <div class="form-group">
                            <label>Mevcut Şifre</label>
                            <input type="password" name="mevcut_sifre" class="form-control @error('mevcut_sifre') is-invalid @enderror" required autofocus>
                            @error('mevcut_sifre')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Yeni Şifre</label>
                            <input type="password" name="yeni_sifre" class="form-control @error('yeni_sifre') is-invalid @enderror" required>
                            <small class="form-text text-muted">En az 6 karakter olmalıdır.</small>
                            @error('yeni_sifre')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Yeni Şifre (Tekrar)</label>
                            <input type="password" name="yeni_sifre_confirmation" class="form-control" required>
                            <small class="form-text text-muted">Yeni şifrenizi tekrar giriniz.</small>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>Güvenlik İpucu:</strong> Güçlü bir şifre için büyük harf, küçük harf, rakam ve özel karakter kullanın.
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-save mr-2"></i>Şifreyi Değiştir
                        </button>
                        <a href="{{ route('kullanicilar.index') }}" class="btn btn-secondary btn-block mt-2">
                            <i class="fas fa-times mr-2"></i>İptal
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
<style>
    .card {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
</style>
@stop

