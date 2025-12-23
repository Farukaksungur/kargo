<?php

namespace App\Exports;

use App\Models\Marka;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class MarkaExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $markalar;

    public function __construct($markalar)
    {
        $this->markalar = $markalar;
    }

    public function collection()
    {
        return $this->markalar;
    }

    public function headings(): array
    {
        return [
            'Marka Adı',
            'Firma Adı',
            'Telefon',
            'Email',
            'Adres',
            'Toplam Borç',
            'Ödenen Tutar',
            'Kalan Tutar',
            'Toplam Kargo Sayısı',
            'Aktif',
            'Notlar'
        ];
    }

    public function map($marka): array
    {
        return [
            $marka->ad ?? '-',
            $marka->firma_adi ?? '-',
            $marka->telefon ?? '-',
            $marka->email ?? '-',
            $marka->adres ?? '-',
            number_format($marka->toplam_borc ?? 0, 2, ',', '.') . ' ₺',
            number_format($marka->odenen_tutar ?? 0, 2, ',', '.') . ' ₺',
            number_format($marka->kalan_tutar ?? 0, 2, ',', '.') . ' ₺',
            $marka->kargolar()->count(),
            $marka->aktif ? 'Evet' : 'Hayır',
            $marka->notlar ?? '-',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 25,
            'C' => 15,
            'D' => 25,
            'E' => 30,
            'F' => 15,
            'G' => 15,
            'H' => 15,
            'I' => 18,
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

