@extends('adminlte::page')

@section('title', 'Yeni Marka Ekle')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-tag mr-2"></i>Yeni Marka Ekle</h1>
        <a href="{{ route('markalar.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Geri Dön
        </a>
    </div>
@stop

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('markalar.store') }}" method="POST" id="markaForm">
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
                            <label for="ad">Marka Adı <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('ad') is-invalid @enderror" 
                                   id="ad" 
                                   name="ad" 
                                   value="{{ old('ad') }}" 
                                   required
                                   placeholder="Marka adını giriniz">
                            @error('ad')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="firma_adi">Firma Adı</label>
                            <input type="text" 
                                   class="form-control @error('firma_adi') is-invalid @enderror" 
                                   id="firma_adi" 
                                   name="firma_adi" 
                                   value="{{ old('firma_adi') }}"
                                   placeholder="Firma adını giriniz">
                            @error('firma_adi')
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

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="toplam_borc">Toplam Borç (₺)</label>
                            <input type="number" 
                                   step="0.01" 
                                   class="form-control @error('toplam_borc') is-invalid @enderror" 
                                   id="toplam_borc" 
                                   name="toplam_borc" 
                                   value="{{ old('toplam_borc', 0) }}"
                                   min="0">
                            @error('toplam_borc')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="odenen_tutar">Ödenen Tutar (₺)</label>
                            <input type="number" 
                                   step="0.01" 
                                   class="form-control @error('odenen_tutar') is-invalid @enderror" 
                                   id="odenen_tutar" 
                                   name="odenen_tutar" 
                                   value="{{ old('odenen_tutar', 0) }}"
                                   min="0">
                            @error('odenen_tutar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
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
                    <a href="{{ route('markalar.index') }}" class="btn btn-secondary btn-lg ml-2">
                        <i class="fas fa-times mr-2"></i>İptal
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop

@section('js')
<script>
    // Form submit loading state
    document.getElementById('markaForm').addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Kaydediliyor...';
    });
</script>
@stop

