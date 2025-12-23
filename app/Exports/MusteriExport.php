<?php

namespace App\Exports;

use App\Models\Musteri;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class MusteriExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $musteriler;

    public function __construct($musteriler)
    {
        $this->musteriler = $musteriler;
    }

    public function collection()
    {
        return $this->musteriler;
    }

    public function headings(): array
    {
        return [
            'Ad',
            'Soyad',
            'Email',
            'Telefon',
            'İl',
            'İlçe',
            'Adres',
            'Toplam Ürün Sayısı',
            'Toplam Harcama',
            'Aktif',
            'Notlar'
        ];
    }

    public function map($musteri): array
    {
        $toplamHarcama = $musteri->kargolar->sum('tutar') + $musteri->kargolar->sum('kargo_ucreti');
        
        return [
            $musteri->ad ?? '-',
            $musteri->soyad ?? '-',
            $musteri->email ?? '-',
            $musteri->telefon ?? '-',
            $musteri->il ?? '-',
            $musteri->ilce ?? '-',
            $musteri->adres ?? '-',
            $musteri->kargolar->count(),
            number_format($toplamHarcama, 2, ',', '.') . ' ₺',
            $musteri->aktif ? 'Evet' : 'Hayır',
            $musteri->notlar ?? '-',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 15,
            'C' => 25,
            'D' => 15,
            'E' => 12,
            'F' => 12,
            'G' => 30,
            'H' => 18,
            'I' => 15,
            'J' => 10,
            'K' => 40,
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
}

