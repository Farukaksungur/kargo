@extends('adminlte::page')

@section('title', 'Yeni Kullanıcı')

@section('content_header')
    <h1><i class="fas fa-user-plus mr-2"></i>Yeni Kullanıcı Ekle</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('kullanicilar.store') }}" method="POST">
                        @csrf

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

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Ad Soyad <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required placeholder="Örn: Ahmet Yılmaz">
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="ornek@email.com">
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Şifre <span class="text-danger">*</span></label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required minlength="6">
                                    <small class="form-text text-muted">En az 6 karakter olmalıdır.</small>
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Şifre (Tekrar) <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" class="form-control" required minlength="6">
                                    <small class="form-text text-muted">Şifrenizi tekrar giriniz.</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Rol <span class="text-danger">*</span></label>
                            <select name="rol_id" class="form-control @error('rol_id') is-invalid @enderror" required>
                                <option value="">Rol Seçiniz</option>
                                @foreach($roller as $rol)
                                <option value="{{ $rol->id }}" {{ old('rol_id') == $rol->id ? 'selected' : '' }}>
                                    {{ $rol->ad }}
                                    @if($rol->aciklama)
                                        - {{ $rol->aciklama }}
                                    @endif
                                </option>
                                @endforeach
                            </select>
                            @error('rol_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Kullanıcının sistemdeki yetkilerini belirler.</small>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            <strong>Bilgi:</strong> Kullanıcı oluşturulduktan sonra bilgileri düzenlenebilir ve şifresi değiştirilebilir.
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save mr-2"></i>Kullanıcı Ekle
                            </button>
                            <a href="{{ route('kullanicilar.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times mr-2"></i>İptal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-info-circle mr-2"></i>Bilgilendirme</h5>
                </div>
                <div class="card-body">
                    <h6>Rol Seçimi</h6>
                    <p class="small text-muted mb-3">
                        Kullanıcıya atanacak rol, sistemdeki yetkilerini belirler. Her rolün farklı yetkileri vardır.
                    </p>
                    
                    <h6>Şifre Güvenliği</h6>
                    <p class="small text-muted mb-3">
                        Güçlü bir şifre için:
                    </p>
                    <ul class="small text-muted">
                        <li>En az 6 karakter</li>
                        <li>Büyük ve küçük harf</li>
                        <li>Rakam ve özel karakter</li>
                    </ul>
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
    .text-danger {
        color: #dc3545 !important;
    }
</style>
@stop


