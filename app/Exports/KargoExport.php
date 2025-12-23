<?php

namespace App\Exports;

use App\Models\Kargo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class KargoExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $kargolar;

    public function __construct($kargolar)
    {
        $this->kargolar = $kargolar;
    }

    public function collection()
    {
        return $this->kargolar;
    }

    public function headings(): array
    {
        return [
            'Takip No',
            'Kargo Kodu',
            'Kargo Firması',
            'Durum',
            'Alıcı Ad',
            'Alıcı Soyad',
            'Alıcı Telefon',
            'İl',
            'İlçe',
            'Adres',
            'Ürün Bilgisi',
            'Tutar',
            'Ödeme Tutarı',
            'Kargo Ücreti',
            'Toplam',
            'Marka',
            'Müşteri',
            'Oluşturulma Tarihi',
            'Hazırlanma Tarihi',
            'Yola Çıkış Tarihi',
            'Teslim Tarihi',
            'Notlar'
        ];
    }

    public function map($kargo): array
    {
        return [
            $kargo->takip_no ?? '-',
            $kargo->kargo_kodu ?? '-',
            $kargo->kargo_firmasi ?? '-',
            $this->durumText($kargo->durum),
            $kargo->alici_ad ?? '-',
            $kargo->alici_soyad ?? '-',
            $kargo->alici_telefon ?? '-',
            $kargo->il ?? '-',
            $kargo->ilce ?? '-',
            $kargo->adres ?? '-',
            $kargo->urun_bilgisi ?? '-',
            number_format($kargo->tutar ?? 0, 2, ',', '.') . ' ₺',
            number_format($kargo->odeme_tutari ?? 0, 2, ',', '.') . ' ₺',
            number_format($kargo->kargo_ucreti ?? 0, 2, ',', '.') . ' ₺',
            number_format(($kargo->tutar ?? 0) + ($kargo->kargo_ucreti ?? 0), 2, ',', '.') . ' ₺',
            $kargo->marka->ad ?? '-',
            ($kargo->musteri->ad ?? '') . ' ' . ($kargo->musteri->soyad ?? ''),
            $kargo->created_at ? $kargo->created_at->format('d.m.Y H:i') : '-',
            $kargo->hazirlanma_tarihi ? $kargo->hazirlanma_tarihi->format('d.m.Y H:i') : '-',
            $kargo->yola_cikis_tarihi ? $kargo->yola_cikis_tarihi->format('d.m.Y H:i') : '-',
            $kargo->teslim_tarihi ? $kargo->teslim_tarihi->format('d.m.Y H:i') : '-',
            $kargo->notlar ?? '-',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 15,
            'C' => 15,
            'D' => 15,
            'E' => 15,
            'F' => 15,
            'G' => 15,
            'H' => 12,
            'I' => 12,
            'J' => 30,
            'K' => 30,
            'L' => 12,
            'M' => 12,
            'N' => 12,
            'O' => 12,
            'P' => 15,
            'Q' => 20,
            'R' => 18,
            'S' => 18,
            'T' => 18,
            'U' => 18,
            'V' => 40,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4472C4']
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    private function durumText($durum)
    {
        return match($durum) {
            'hazirlaniyor' => 'Hazırlanıyor',
            'yolda' => 'Yolda',
            'teslim_edildi' => 'Teslim Edildi',
            default => $durum
        };
    }
}

