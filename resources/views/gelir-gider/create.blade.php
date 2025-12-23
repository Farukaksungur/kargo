@extends('adminlte::page')

@section('title', 'Yeni Gelir/Gider')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-exchange-alt mr-2"></i>Yeni Gelir/Gider Ekle</h1>
        <a href="{{ route('gelir-gider.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Geri Dön
        </a>
    </div>
@stop

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('gelir-gider.store') }}" method="POST" id="gelirGiderForm">
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
                            <label for="tip">Tip <span class="text-danger">*</span></label>
                            <select name="tip" class="form-control @error('tip') is-invalid @enderror" required>
                                <option value="gelir" {{ old('tip') == 'gelir' ? 'selected' : '' }}>Gelir</option>
                                <option value="gider" {{ old('tip') == 'gider' ? 'selected' : '' }}>Gider</option>
                            </select>
                            @error('tip')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tarih">Tarih <span class="text-danger">*</span></label>
                            <input type="date" name="tarih" class="form-control @error('tarih') is-invalid @enderror" value="{{ old('tarih', date('Y-m-d')) }}" required>
                            @error('tarih')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="baslik">Başlık <span class="text-danger">*</span></label>
                    <input type="text" name="baslik" class="form-control @error('baslik') is-invalid @enderror" value="{{ old('baslik') }}" required>
                    @error('baslik')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="aciklama">Açıklama</label>
                    <textarea name="aciklama" class="form-control @error('aciklama') is-invalid @enderror" rows="3">{{ old('aciklama') }}</textarea>
                    @error('aciklama')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tutar">Tutar (₺) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="tutar" class="form-control @error('tutar') is-invalid @enderror" value="{{ old('tutar') }}" required min="0">
                            @error('tutar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <input type="text" name="kategori" class="form-control @error('kategori') is-invalid @enderror" value="{{ old('kategori') }}">
                            @error('kategori')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="marka_id">Marka</label>
                            <select name="marka_id" class="form-control">
                                <option value="">Seçiniz</option>
                                @foreach($markalar as $marka)
                                <option value="{{ $marka->id }}" {{ old('marka_id') == $marka->id ? 'selected' : '' }}>{{ $marka->ad }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="musteri_id">Müşteri</label>
                            <select name="musteri_id" class="form-control">
                                <option value="">Seçiniz</option>
                                @foreach($musteriler as $musteri)
                                <option value="{{ $musteri->id }}" {{ old('musteri_id') == $musteri->id ? 'selected' : '' }}>{{ $musteri->ad }} {{ $musteri->soyad }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="odeme_yontemi">Ödeme Yöntemi</label>
                            <select name="odeme_yontemi" class="form-control">
                                <option value="">Seçiniz</option>
                                <option value="nakit" {{ old('odeme_yontemi') == 'nakit' ? 'selected' : '' }}>Nakit</option>
                                <option value="havale" {{ old('odeme_yontemi') == 'havale' ? 'selected' : '' }}>Havale</option>
                                <option value="cek" {{ old('odeme_yontemi') == 'cek' ? 'selected' : '' }}>Çek</option>
                                <option value="senet" {{ old('odeme_yontemi') == 'senet' ? 'selected' : '' }}>Senet</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="fatura_no">Fatura No</label>
                    <input type="text" name="fatura_no" class="form-control" value="{{ old('fatura_no') }}">
                </div>
                <div class="form-group">
                    <label for="notlar">Notlar</label>
                    <textarea name="notlar" class="form-control" rows="3">{{ old('notlar') }}</textarea>
                </div>
                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save mr-2"></i>Kaydet
                    </button>
                    <a href="{{ route('gelir-gider.index') }}" class="btn btn-secondary btn-lg ml-2">
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
        setFormLoading('gelirGiderForm', 'Kaydediliyor...');
    </script>
@stop
