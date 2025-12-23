@extends('adminlte::page')

@section('title', 'Yeni Müşteri Ekle')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-user-plus mr-2"></i>Yeni Müşteri Ekle</h1>
        <a href="{{ route('musteriler.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Geri Dön
        </a>
    </div>
@stop

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('musteriler.store') }}" method="POST" id="musteriForm">
                @csrf
                
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h5><i class="icon fas fa-ban"></i> Hata!</h5>
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
                            <label for="ad">Ad <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('ad') is-invalid @enderror" 
                                   id="ad" 
                                   name="ad" 
                                   value="{{ old('ad') }}" 
                                   required
                                   placeholder="Müşteri adını giriniz">
                            @error('ad')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="soyad">Soyad <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('soyad') is-invalid @enderror" 
                                   id="soyad" 
                                   name="soyad" 
                                   value="{{ old('soyad') }}" 
                                   required
                                   placeholder="Müşteri soyadını giriniz">
                            @error('soyad')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="telefon">Telefon</label>
                            <input type="text" 
                                   class="form-control @error('telefon') is-invalid @enderror" 
                                   id="telefon" 
                                   name="telefon" 
                                   value="{{ old('telefon') }}"
                                   placeholder="0555 555 55 55">
                            @error('telefon')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   placeholder="ornek@email.com">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="il">İl</label>
                            <input type="text" 
                                   class="form-control @error('il') is-invalid @enderror" 
                                   id="il" 
                                   name="il" 
                                   value="{{ old('il') }}"
                                   placeholder="İl adını giriniz">
                            @error('il')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="ilce">İlçe</label>
                            <input type="text" 
                                   class="form-control @error('ilce') is-invalid @enderror" 
                                   id="ilce" 
                                   name="ilce" 
                                   value="{{ old('ilce') }}"
                                   placeholder="İlçe adını giriniz">
                            @error('ilce')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="adres">Adres</label>
                    <textarea class="form-control @error('adres') is-invalid @enderror" 
                              id="adres" 
                              name="adres" 
                              rows="3"
                              placeholder="Adres bilgilerini giriniz">{{ old('adres') }}</textarea>
                    @error('adres')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="notlar">Notlar</label>
                    <textarea class="form-control @error('notlar') is-invalid @enderror" 
                              id="notlar" 
                              name="notlar" 
                              rows="4"
                              placeholder="Ek notlarınızı buraya yazabilirsiniz">{{ old('notlar') }}</textarea>
                    @error('notlar')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="custom-control custom-switch">
                        <input type="checkbox" 
                               class="custom-control-input" 
                               id="aktif" 
                               name="aktif" 
                               value="1"
                               {{ old('aktif', true) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="aktif">Aktif</label>
                    </div>
                </div>

                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save mr-2"></i>Kaydet
                    </button>
                    <a href="{{ route('musteriler.index') }}" class="btn btn-secondary btn-lg ml-2">
                        <i class="fas fa-times mr-2"></i>İptal
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop

@section('js')
    @include('includes.scripts')
    <script>
        setFormLoading('musteriForm', 'Kaydediliyor...');
    </script>
@stop

