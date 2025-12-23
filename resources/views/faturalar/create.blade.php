@extends('adminlte::page')

@section('title', 'Yeni Fatura')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1><i class="fas fa-file-invoice mr-2"></i>Yeni Fatura Oluştur</h1>
        <a href="{{ route('faturalar.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Geri Dön
        </a>
    </div>
@stop

@section('content')
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <form action="{{ route('faturalar.store') }}" method="POST" id="faturaForm">
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
                            <label for="fatura_no">Fatura No <span class="text-danger">*</span></label>
                            <input type="text" name="fatura_no" class="form-control @error('fatura_no') is-invalid @enderror" value="{{ old('fatura_no') }}" required>
                            @error('fatura_no')
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
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tip">Tip <span class="text-danger">*</span></label>
                            <select name="tip" class="form-control @error('tip') is-invalid @enderror" required>
                                <option value="satis" {{ old('tip') == 'satis' ? 'selected' : '' }}>Satış</option>
                                <option value="alis" {{ old('tip') == 'alis' ? 'selected' : '' }}>Alış</option>
                                <option value="iade" {{ old('tip') == 'iade' ? 'selected' : '' }}>İade</option>
                            </select>
                            @error('tip')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
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
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ara_toplam">Ara Toplam (₺) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="ara_toplam" class="form-control @error('ara_toplam') is-invalid @enderror" value="{{ old('ara_toplam') }}" required min="0">
                            @error('ara_toplam')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="kdv_orani">KDV Oranı (%)</label>
                            <input type="number" step="0.01" name="kdv_orani" class="form-control @error('kdv_orani') is-invalid @enderror" value="{{ old('kdv_orani', 18) }}" min="0" max="100">
                            @error('kdv_orani')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="genel_toplam">Genel Toplam (₺) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="genel_toplam" class="form-control @error('genel_toplam') is-invalid @enderror" value="{{ old('genel_toplam') }}" required min="0">
                            @error('genel_toplam')
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
                            <label for="durum">Durum <span class="text-danger">*</span></label>
                            <select name="durum" class="form-control @error('durum') is-invalid @enderror" required>
                                <option value="beklemede" {{ old('durum') == 'beklemede' ? 'selected' : '' }}>Beklemede</option>
                                <option value="odendi" {{ old('durum') == 'odendi' ? 'selected' : '' }}>Ödendi</option>
                                <option value="iptal" {{ old('durum') == 'iptal' ? 'selected' : '' }}>İptal</option>
                            </select>
                            @error('durum')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="odeme_yontemi">Ödeme Yöntemi</label>
                            <select name="odeme_yontemi" class="form-control">
                                <option value="">Seçiniz</option>
                                <option value="nakit" {{ old('odeme_yontemi') == 'nakit' ? 'selected' : '' }}>Nakit</option>
                                <option value="havale" {{ old('odeme_yontemi') == 'havale' ? 'selected' : '' }}>Havale</option>
                                <option value="kredi_karti" {{ old('odeme_yontemi') == 'kredi_karti' ? 'selected' : '' }}>Kredi Kartı</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="notlar">Notlar</label>
                    <textarea name="notlar" class="form-control" rows="3">{{ old('notlar') }}</textarea>
                </div>
                <div class="form-group mb-0">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-save mr-2"></i>Kaydet
                    </button>
                    <a href="{{ route('faturalar.index') }}" class="btn btn-secondary btn-lg ml-2">
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
        setFormLoading('faturaForm', 'Kaydediliyor...');
    </script>
@stop

