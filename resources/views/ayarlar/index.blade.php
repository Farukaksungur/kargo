@extends('adminlte::page')

@section('title', 'Ayarlar')

@section('content_header')
    <h1><i class="fas fa-cog mr-2"></i>Sistem Ayarları</h1>
@stop

@section('content')
    <form action="{{ route('ayarlar.store') }}" method="POST">
        @csrf
        @foreach($ayarlar as $grup => $grupAyarlari)
        <div class="card">
            <div class="card-header">
                <h5>{{ ucfirst($grup) }} Ayarları</h5>
            </div>
            <div class="card-body">
                @foreach($grupAyarlari as $ayar)
                <div class="form-group">
                    <label>{{ $ayar->aciklama ?? $ayar->anahtar }}</label>
                    <input type="text" name="{{ $ayar->anahtar }}" class="form-control" value="{{ $ayar->deger }}">
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
        <button type="submit" class="btn btn-primary mt-3">Kaydet</button>
    </form>
@stop

