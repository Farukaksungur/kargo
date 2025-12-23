@extends('adminlte::page')

@section('title', $marka->ad . ' - Detay')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1 class="m-0"><i class="fas fa-tag mr-2"></i>{{ $marka->ad }}</h1>
            <small class="text-muted">{{ $marka->firma_adi }}</small>
        </div>
        <div>
            <button type="button" class="btn btn-success mr-2" data-toggle="modal" data-target="#odemeModal">
                <i class="fas fa-plus mr-2"></i>Ödeme Ekle
            </button>
            <a href="{{ route('markalar.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i>Geri Dön
            </a>
        </div>
    </div>
@stop

@section('content')
    <!-- Filtreleme -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body py-2">
                    <div class="btn-group" role="group">
                        <a href="{{ route('markalar.show', ['markalar' => $marka->id, 'filtre' => 'gunluk']) }}" 
                           class="btn btn-sm {{ $filtre == 'gunluk' ? 'btn-primary' : 'btn-outline-primary' }}">
                            <i class="fas fa-calendar-day mr-1"></i>Günlük
                        </a>
                        <a href="{{ route('markalar.show', ['markalar' => $marka->id, 'filtre' => 'haftalik']) }}" 
                           class="btn btn-sm {{ $filtre == 'haftalik' ? 'btn-primary' : 'btn-outline-primary' }}">
                            <i class="fas fa-calendar-week mr-1"></i>Haftalık
                        </a>
                        <a href="{{ route('markalar.show', ['markalar' => $marka->id, 'filtre' => 'aylik']) }}" 
                           class="btn btn-sm {{ $filtre == 'aylik' ? 'btn-primary' : 'btn-outline-primary' }}">
                            <i class="fas fa-calendar-alt mr-1"></i>Aylık
                        </a>
                        <a href="{{ route('markalar.show', ['markalar' => $marka->id, 'filtre' => 'yillik']) }}" 
                           class="btn btn-sm {{ $filtre == 'yillik' ? 'btn-primary' : 'btn-outline-primary' }}">
                            <i class="fas fa-calendar mr-1"></i>Yıllık
                        </a>
                    </div>
                    <span class="ml-3 text-muted">
                        <i class="fas fa-calendar-check mr-1"></i>
                        {{ $baslangic->locale('tr')->isoFormat('D MMMM YYYY') }} - {{ $bitis->locale('tr')->isoFormat('D MMMM YYYY') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Genel Özet -->
    <div class="row mb-3">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card shadow-sm border-0 bg-gradient-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0 text-white-50">Toplam Borç</h6>
                            <h3 class="mb-0 mt-2">{{ number_format($marka->toplam_borc, 2, ',', '.') }} ₺</h3>
                        </div>
                        <i class="fas fa-money-bill-wave fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card shadow-sm border-0 bg-gradient-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0 text-white-50">Ödenen Tutar</h6>
                            <h3 class="mb-0 mt-2">{{ number_format($marka->odenen_tutar, 2, ',', '.') }} ₺</h3>
                        </div>
                        <i class="fas fa-check-circle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card shadow-sm border-0 bg-gradient-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0 text-white-50">Kalan Tutar</h6>
                            <h3 class="mb-0 mt-2">{{ number_format($marka->kalan_tutar, 2, ',', '.') }} ₺</h3>
                        </div>
                        <i class="fas fa-exclamation-triangle fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card shadow-sm border-0 bg-gradient-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-0 text-white-50">Toplam Kargo</h6>
                            <h3 class="mb-0 mt-2">{{ $toplamKargo }}</h3>
                        </div>
                        <i class="fas fa-boxes fa-2x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kargo İstatistikleri -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-2">
                    <h6 class="mb-0 font-weight-bold">
                        <i class="fas fa-shipping-fast mr-2"></i>Kargo İstatistikleri
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="stat-mini-card stat-mini-info">
                                <div class="stat-mini-content">
                                    <div class="stat-mini-icon">
                                        <i class="fas fa-box-open"></i>
                                    </div>
                                    <div class="stat-mini-info">
                                        <h4 class="stat-mini-number">{{ $hazirlanan }}</h4>
                                        <p class="stat-mini-label">Hazırlanan</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="stat-mini-card stat-mini-warning">
                                <div class="stat-mini-content">
                                    <div class="stat-mini-icon">
                                        <i class="fas fa-truck"></i>
                                    </div>
                                    <div class="stat-mini-info">
                                        <h4 class="stat-mini-number">{{ $yolda }}</h4>
                                        <p class="stat-mini-label">Yolda</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mb-3">
                            <div class="stat-mini-card stat-mini-success">
                                <div class="stat-mini-content">
                                    <div class="stat-mini-icon">
                                        <i class="fas fa-check-double"></i>
                                    </div>
                                    <div class="stat-mini-info">
                                        <h4 class="stat-mini-number">{{ $teslimEdilen }}</h4>
                                        <p class="stat-mini-label">Teslim Edilen</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ödeme İstatistikleri -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-2">
                    <h6 class="mb-0 font-weight-bold">
                        <i class="fas fa-money-check-alt mr-2"></i>Ödeme İstatistikleri ({{ $filtre }})
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="stat-mini-card stat-mini-success">
                                <div class="stat-mini-content">
                                    <div class="stat-mini-icon">
                                        <i class="fas fa-money-bill-wave"></i>
                                    </div>
                                    <div class="stat-mini-info">
                                        <h4 class="stat-mini-number">{{ number_format($toplamOdenen, 2, ',', '.') }} ₺</h4>
                                        <p class="stat-mini-label">Toplam Ödenen</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="stat-mini-card stat-mini-primary">
                                <div class="stat-mini-content">
                                    <div class="stat-mini-icon">
                                        <i class="fas fa-wallet"></i>
                                    </div>
                                    <div class="stat-mini-info">
                                        <h4 class="stat-mini-number">{{ number_format($nakitOdenen, 2, ',', '.') }} ₺</h4>
                                        <p class="stat-mini-label">Nakit</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="stat-mini-card stat-mini-info">
                                <div class="stat-mini-content">
                                    <div class="stat-mini-icon">
                                        <i class="fas fa-university"></i>
                                    </div>
                                    <div class="stat-mini-info">
                                        <h4 class="stat-mini-number">{{ number_format($havaleOdenen, 2, ',', '.') }} ₺</h4>
                                        <p class="stat-mini-label">Havale</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="stat-mini-card stat-mini-warning">
                                <div class="stat-mini-content">
                                    <div class="stat-mini-icon">
                                        <i class="fas fa-file-invoice-dollar"></i>
                                    </div>
                                    <div class="stat-mini-info">
                                        <h4 class="stat-mini-number">{{ number_format($cekOdenen + $senetOdenen, 2, ',', '.') }} ₺</h4>
                                        <p class="stat-mini-label">Çek/Senet</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kargo Listesi ve Ödeme Listesi -->
    <div class="row">
        <div class="col-lg-6 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-2">
                    <h6 class="mb-0 font-weight-bold">
                        <i class="fas fa-boxes mr-2"></i>Kargo Listesi
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0">Takip Kodu</th>
                                    <th class="border-0">Kargo Firması</th>
                                    <th class="border-0">Durum</th>
                                    <th class="border-0">Kargolanma Tarihi</th>
                                    <th class="border-0">Teslim Tarihi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kargolar as $kargo)
                                <tr class="table-row-clickable" data-href="{{ route('markalar.kargo.detay', ['markaId' => $marka->id, 'kargoId' => $kargo->id]) }}" style="cursor: pointer;">
                                    <td>
                                        <strong>{{ $kargo->takip_no }}</strong>
                                        @if($kargo->kargo_kodu)
                                            <br><small class="text-muted">Kod: {{ $kargo->kargo_kodu }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $kargo->kargo_firmasi ?? '-' }}
                                    </td>
                                    <td>
                                        @if($kargo->durum == 'hazirlaniyor')
                                            <span class="badge badge-info">Hazırlanıyor</span>
                                        @elseif($kargo->durum == 'yolda')
                                            <span class="badge badge-warning">Yolda</span>
                                        @else
                                            <span class="badge badge-success">Teslim Edildi</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($kargo->kargolanma_tarihi)
                                            <small class="text-muted">{{ $kargo->kargolanma_tarihi->format('d.m.Y') }}</small>
                                        @else
                                            <small class="text-muted">-</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($kargo->teslim_tarihi)
                                            <small class="text-success font-weight-bold">{{ $kargo->teslim_tarihi->format('d.m.Y') }}</small>
                                        @else
                                            <small class="text-muted">-</small>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-3">Bu dönemde kargo kaydı bulunmamaktadır.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-3">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-0 py-2">
                    <h6 class="mb-0 font-weight-bold">
                        <i class="fas fa-money-check-alt mr-2"></i>Ödeme Geçmişi
                    </h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-0">Tarih</th>
                                    <th class="border-0">Tutar</th>
                                    <th class="border-0">Tip</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($odemeler as $odeme)
                                <tr>
                                    <td><small>{{ $odeme->odeme_tarihi->format('d.m.Y') }}</small></td>
                                    <td><strong class="text-success">{{ number_format($odeme->tutar, 2, ',', '.') }} ₺</strong></td>
                                    <td>
                                        @if($odeme->odeme_tipi == 'nakit')
                                            <span class="badge badge-primary">Nakit</span>
                                        @elseif($odeme->odeme_tipi == 'havale')
                                            <span class="badge badge-info">Havale</span>
                                        @elseif($odeme->odeme_tipi == 'cek')
                                            <span class="badge badge-warning">Çek</span>
                                        @else
                                            <span class="badge badge-secondary">Senet</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-3">Bu dönemde ödeme kaydı bulunmamaktadır.</td>
                                </tr>
                                @endforelse
                            </tbody>
                            @if($odemeler->count() > 0)
                            <tfoot class="thead-light">
                                <tr>
                                    <th class="text-right">TOPLAM:</th>
                                    <th class="text-success">{{ number_format($toplamOdenen, 2, ',', '.') }} ₺</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <style>
        .stat-mini-card {
            background: #ffffff;
            border-radius: 8px;
            padding: 16px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .stat-mini-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .stat-mini-content {
            display: flex;
            align-items: center;
        }

        .stat-mini-icon {
            width: 48px;
            height: 48px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-size: 20px;
            flex-shrink: 0;
        }

        .stat-mini-info {
            flex: 1;
        }

        .stat-mini-number {
            font-size: 20px;
            font-weight: 700;
            margin: 0 0 4px 0;
            line-height: 1.2;
        }

        .stat-mini-label {
            font-size: 12px;
            color: #6c757d;
            margin: 0;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-mini-info .stat-mini-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .stat-mini-info .stat-mini-number { color: #667eea; }

        .stat-mini-warning .stat-mini-icon {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }
        .stat-mini-warning .stat-mini-number { color: #f5576c; }

        .stat-mini-success .stat-mini-icon {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }
        .stat-mini-success .stat-mini-number { color: #00c9ff; }

        .stat-mini-primary .stat-mini-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .stat-mini-primary .stat-mini-number { color: #667eea; }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%) !important;
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%) !important;
        }

        .bg-gradient-info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%) !important;
        }

        .table {
            font-size: 14px;
        }

        .table thead th {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 15px;
        }

        .table tbody td {
            padding: 12px 15px;
            vertical-align: middle;
        }
    </style>
@stop

<!-- Ödeme Ekleme Modal -->
<div class="modal fade" id="odemeModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fas fa-money-check-alt mr-2"></i>Ödeme Ekle</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="odemeForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tutar">Tutar (₺) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control" id="tutar" name="tutar" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="odeme_tarihi">Ödeme Tarihi <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="odeme_tarihi" name="odeme_tarihi" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="odeme_tipi">Ödeme Tipi <span class="text-danger">*</span></label>
                                <select class="form-control" id="odeme_tipi" name="odeme_tipi" required>
                                    <option value="nakit">Nakit</option>
                                    <option value="havale">Havale</option>
                                    <option value="cek">Çek</option>
                                    <option value="senet">Senet</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="fatura_no">Fatura No</label>
                                <input type="text" class="form-control" id="fatura_no" name="fatura_no">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="aciklama">Açıklama</label>
                        <input type="text" class="form-control" id="aciklama" name="aciklama">
                    </div>
                    <div class="form-group">
                        <label for="notlar">Notlar</label>
                        <textarea class="form-control" id="notlar" name="notlar" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save mr-2"></i>Kaydet
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        console.log('Marka detay sayfası yüklendi');
        
        // Satıra tıklayınca kargo detay sayfasına git
        document.addEventListener('DOMContentLoaded', function() {
            const rows = document.querySelectorAll('.table-row-clickable');
            rows.forEach(row => {
                row.addEventListener('click', function(e) {
                    if (e.target.tagName !== 'A' && e.target.tagName !== 'BUTTON' && !e.target.closest('a') && !e.target.closest('button')) {
                        window.location.href = this.dataset.href;
                    }
                });
                
                row.addEventListener('mouseenter', function() {
                    this.style.backgroundColor = '#f8f9fa';
                });
                row.addEventListener('mouseleave', function() {
                    this.style.backgroundColor = '';
                });
            });
        });

        // Ödeme ekleme formu
        $('#odemeForm').on('submit', function(e) {
            e.preventDefault();
            
            const formData = {
                marka_id: {{ $marka->id }},
                tutar: $('#tutar').val(),
                odeme_tarihi: $('#odeme_tarihi').val(),
                odeme_tipi: $('#odeme_tipi').val(),
                aciklama: $('#aciklama').val(),
                fatura_no: $('#fatura_no').val(),
                notlar: $('#notlar').val(),
                _token: '{{ csrf_token() }}'
            };

            $.ajax({
                url: '{{ route("odemeler.store") }}',
                method: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        $('#odemeModal').modal('hide');
                        $('#odemeForm')[0].reset();
                        location.reload();
                    }
                },
                error: function(xhr) {
                    let errors = '';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        $.each(xhr.responseJSON.errors, function(key, value) {
                            errors += value[0] + '\n';
                        });
                    } else {
                        errors = 'Bir hata oluştu.';
                    }
                    alert(errors);
                }
            });
        });
    </script>
@stop

