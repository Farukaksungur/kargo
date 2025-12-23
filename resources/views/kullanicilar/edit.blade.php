@extends('adminlte::page')

@section('title', 'Kullanıcı Düzenle')

@section('content_header')
    <h1><i class="fas fa-user-friends mr-2"></i>Kullanıcı Düzenle</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('kullanicilar.update', $kullanici->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Ad</label>
                    <input type="text" name="name" class="form-control" value="{{ $kullanici->name }}" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $kullanici->email }}" required>
                </div>
                <div class="form-group">
                    <label>Şifre (Değiştirmek istemiyorsanız boş bırakın)</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                    <label>Rol</label>
                    <select name="rol_id" class="form-control" required>
                        <option value="">Seçiniz</option>
                        @foreach($roller as $rol)
                        <option value="{{ $rol->id }}" {{ $kullanici->rol_id == $rol->id ? 'selected' : '' }}>{{ $rol->ad }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Güncelle</button>
                <a href="{{ route('kullanicilar.index') }}" class="btn btn-secondary">İptal</a>
            </form>
        </div>
    </div>
@stop

