@extends('adminlte::page')

@section('title', 'İşlem Logları')

@section('content_header')
    <h1><i class="fas fa-history mr-2"></i>İşlem Logları</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tarih</th>
                        <th>Kullanıcı</th>
                        <th>İşlem Tipi</th>
                        <th>Modül</th>
                        <th>Açıklama</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($loglar as $log)
                    <tr>
                        <td>{{ $log->created_at->format('d.m.Y H:i') }}</td>
                        <td>{{ $log->user ? $log->user->name : '-' }}</td>
                        <td>{{ $log->islem_tipi }}</td>
                        <td>{{ $log->modul }}</td>
                        <td>{{ $log->aciklama ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $loglar->links() }}
        </div>
    </div>
@stop

