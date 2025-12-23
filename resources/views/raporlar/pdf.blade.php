<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapor - {{ ucfirst($tip) }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #667eea;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .info-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .info-box h3 {
            margin-top: 0;
            color: #667eea;
        }
        .stats {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .stat-item {
            display: table-cell;
            text-align: center;
            padding: 15px;
            background: #f8f9fa;
            border-right: 1px solid #ddd;
        }
        .stat-item:last-child {
            border-right: none;
        }
        .stat-item h4 {
            margin: 0;
            color: #667eea;
            font-size: 14px;
        }
        .stat-item p {
            margin: 5px 0 0 0;
            font-size: 18px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th {
            background: #667eea;
            color: white;
            padding: 10px;
            text-align: left;
        }
        table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        table tr:nth-child(even) {
            background: #f8f9fa;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #ddd;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
        .text-right {
            text-align: right;
        }
        .text-success {
            color: #28a745;
        }
        .text-danger {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Kargo Yönetim Sistemi</h1>
        <p><strong>{{ ucfirst($tip) }} Raporu</strong></p>
        <p>Tarih Aralığı: {{ \Carbon\Carbon::parse($baslangic)->format('d.m.Y') }} - {{ \Carbon\Carbon::parse($bitis)->format('d.m.Y') }}</p>
        <p>Oluşturulma Tarihi: {{ \Carbon\Carbon::now()->format('d.m.Y H:i') }}</p>
    </div>

    @if($tip == 'satis')
        <div class="stats">
            <div class="stat-item">
                <h4>Toplam Sipariş</h4>
                <p>{{ $rapor['toplam_siparis'] }}</p>
            </div>
            <div class="stat-item">
                <h4>Toplam Tutar</h4>
                <p>{{ number_format($rapor['toplam_tutar'], 2, ',', '.') }} ₺</p>
            </div>
            <div class="stat-item">
                <h4>Kargo Ücreti</h4>
                <p>{{ number_format($rapor['toplam_kargo_ucreti'], 2, ',', '.') }} ₺</p>
            </div>
            <div class="stat-item">
                <h4>Genel Toplam</h4>
                <p>{{ number_format($rapor['genel_toplam'], 2, ',', '.') }} ₺</p>
            </div>
        </div>

        <div class="info-box">
            <h3>Kargo Durumları</h3>
            <p>Hazırlanan: {{ $rapor['hazirlanan'] }} | Yolda: {{ $rapor['yolda'] }} | Teslim Edilen: {{ $rapor['teslim_edilen'] }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Takip No</th>
                    <th>Tarih</th>
                    <th>Müşteri</th>
                    <th>Durum</th>
                    <th class="text-right">Tutar</th>
                    <th class="text-right">Kargo Ücreti</th>
                    <th class="text-right">Toplam</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rapor['detaylar'] as $kargo)
                <tr>
                    <td>{{ $kargo->takip_no }}</td>
                    <td>{{ $kargo->created_at->format('d.m.Y') }}</td>
                    <td>{{ $kargo->alici_ad }} {{ $kargo->alici_soyad }}</td>
                    <td>
                        @if($kargo->durum == 'hazirlaniyor')
                            Hazırlanıyor
                        @elseif($kargo->durum == 'yolda')
                            Yolda
                        @else
                            Teslim Edildi
                        @endif
                    </td>
                    <td class="text-right">{{ number_format($kargo->tutar, 2, ',', '.') }} ₺</td>
                    <td class="text-right">{{ number_format($kargo->kargo_ucreti, 2, ',', '.') }} ₺</td>
                    <td class="text-right"><strong>{{ number_format($kargo->tutar + $kargo->kargo_ucreti, 2, ',', '.') }} ₺</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>

    @elseif($tip == 'kargo')
        <div class="stats">
            <div class="stat-item">
                <h4>Toplam Kargo</h4>
                <p>{{ $rapor['toplam_kargo'] }}</p>
            </div>
            <div class="stat-item">
                <h4>Hazırlanan</h4>
                <p>{{ $rapor['durum_bazli']['hazirlanan'] }}</p>
            </div>
            <div class="stat-item">
                <h4>Yolda</h4>
                <p>{{ $rapor['durum_bazli']['yolda'] }}</p>
            </div>
            <div class="stat-item">
                <h4>Teslim Edilen</h4>
                <p>{{ $rapor['durum_bazli']['teslim_edilen'] }}</p>
            </div>
        </div>

        @if(isset($rapor['firma_bazli']) && count($rapor['firma_bazli']) > 0)
        <table>
            <thead>
                <tr>
                    <th>Kargo Firması</th>
                    <th class="text-right">Kargo Sayısı</th>
                    <th class="text-right">Toplam Tutar</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rapor['firma_bazli'] as $firma => $veri)
                <tr>
                    <td>{{ $firma }}</td>
                    <td class="text-right">{{ $veri['sayi'] }}</td>
                    <td class="text-right">{{ number_format($veri['tutar'], 2, ',', '.') }} ₺</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif

    @elseif($tip == 'finansal')
        <div class="stats">
            <div class="stat-item">
                <h4>Toplam Gelir</h4>
                <p class="text-success">{{ number_format($rapor['toplam_gelir'], 2, ',', '.') }} ₺</p>
            </div>
            <div class="stat-item">
                <h4>Toplam Gider</h4>
                <p class="text-danger">{{ number_format($rapor['toplam_gider'], 2, ',', '.') }} ₺</p>
            </div>
            <div class="stat-item">
                <h4>Net Kar</h4>
                <p>{{ number_format($rapor['net_kar'], 2, ',', '.') }} ₺</p>
            </div>
        </div>

        <div class="row" style="display: table; width: 100%;">
            <div style="display: table-cell; width: 50%; padding-right: 10px;">
                <h3>Gelirler</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Tarih</th>
                            <th>Başlık</th>
                            <th class="text-right">Tutar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rapor['gelirler'] as $gelir)
                        <tr>
                            <td>{{ $gelir->tarih->format('d.m.Y') }}</td>
                            <td>{{ $gelir->baslik }}</td>
                            <td class="text-right text-success">{{ number_format($gelir->tutar, 2, ',', '.') }} ₺</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div style="display: table-cell; width: 50%; padding-left: 10px;">
                <h3>Giderler</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Tarih</th>
                            <th>Başlık</th>
                            <th class="text-right">Tutar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rapor['giderler'] as $gider)
                        <tr>
                            <td>{{ $gider->tarih->format('d.m.Y') }}</td>
                            <td>{{ $gider->baslik }}</td>
                            <td class="text-right text-danger">{{ number_format($gider->tutar, 2, ',', '.') }} ₺</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    @elseif($tip == 'musteri')
        <div class="stats">
            <div class="stat-item">
                <h4>Toplam Müşteri</h4>
                <p>{{ $rapor['toplam_musteri'] }}</p>
            </div>
            <div class="stat-item">
                <h4>Aktif Müşteri</h4>
                <p>{{ $rapor['aktif_musteri'] }}</p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Müşteri</th>
                    <th class="text-right">Sipariş Sayısı</th>
                    <th class="text-right">Toplam Harcama</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rapor['musteri_bazli'] as $musteri)
                <tr>
                    <td>{{ $musteri['ad'] }}</td>
                    <td class="text-right">{{ $musteri['siparis_sayisi'] }}</td>
                    <td class="text-right"><strong>{{ number_format($musteri['toplam_harcama'], 2, ',', '.') }} ₺</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>

    @elseif($tip == 'marka')
        <div class="stats">
            <div class="stat-item">
                <h4>Toplam Marka</h4>
                <p>{{ $rapor['toplam_marka'] }}</p>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Marka</th>
                    <th class="text-right">Sipariş Sayısı</th>
                    <th class="text-right">Toplam Tutar</th>
                    <th class="text-right">Toplam Borç</th>
                    <th class="text-right">Ödenen</th>
                    <th class="text-right">Kalan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rapor['marka_bazli'] as $marka)
                <tr>
                    <td><strong>{{ $marka['ad'] }}</strong></td>
                    <td class="text-right">{{ $marka['siparis_sayisi'] }}</td>
                    <td class="text-right">{{ number_format($marka['toplam_tutar'], 2, ',', '.') }} ₺</td>
                    <td class="text-right">{{ number_format($marka['toplam_borc'], 2, ',', '.') }} ₺</td>
                    <td class="text-right text-success">{{ number_format($marka['odenen_tutar'], 2, ',', '.') }} ₺</td>
                    <td class="text-right {{ $marka['kalan_tutar'] > 0 ? 'text-danger' : 'text-success' }}">
                        {{ number_format($marka['kalan_tutar'], 2, ',', '.') }} ₺
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="footer">
        <p>Bu rapor Kargo Yönetim Sistemi tarafından otomatik olarak oluşturulmuştur.</p>
        <p>Sayfa 1</p>
    </div>
</body>
</html>

