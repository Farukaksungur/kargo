@extends('adminlte::page')

@section('title', 'Kullanıcılar')

@section('content_header')
    <h1><i class="fas fa-user-friends mr-2"></i>Kullanıcı Yönetimi</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('kullanicilar.create') }}" class="btn btn-primary">
                        <i class="fas fa-user-plus mr-2"></i>Yeni Kullanıcı
                    </a>
                </div>
                <div>
                    <a href="{{ route('kullanicilar.sifre-degistir') }}" class="btn btn-warning">
                        <i class="fas fa-key mr-2"></i>Şifremi Değiştir
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Ad</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kullanicilar as $kullanici)
                    <tr>
                        <td>{{ $kullanici->name }}</td>
                        <td>{{ $kullanici->email }}</td>
                        <td>{{ $kullanici->rol ? $kullanici->rol->ad : '-' }}</td>
                        <td>
                            <a href="{{ route('kullanicilar.edit', $kullanici->id) }}" class="btn btn-sm btn-info">Düzenle</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

