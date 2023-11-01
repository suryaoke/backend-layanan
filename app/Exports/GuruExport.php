<?php

namespace App\Exports;


use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GuruExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $guru;
    protected $counter = 1;
    public function __construct($guru)
    {
        $this->guru = $guru;
    }

    public function collection()
    {
        return $this->guru;
    }
    public function map($guru): array
    {
        $walasTingkat = isset($guru->walass->kelass->tingkat) ? $guru->walass->kelass->tingkat : '';
        $walasNama = isset($guru->walass->kelass->nama) ? $guru->walass->kelass->nama : '';
        $walasJurusan = isset($guru->walass->kelass->jurusans->nama) ? $guru->walass->kelass->jurusans->nama : '';

        return [
            'No' => $this->counter++,
            'Nama' => isset($guru->nama) ? $guru->nama : '',
            'Kode Guru' => isset($guru->kode_gr) ? $guru->kode_gr : '',
            'No Hp' => isset($guru->no_hp) ? $guru->no_hp : '',
            'Username' => isset($guru->users->username) ? $guru->users->username : '',
            'Walas' => $walasTingkat . ' ' . $walasNama . ' ' . $walasJurusan,
        ];
    }


    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'kode Guru',
            'No Hp',
            'Username',
            'Walas',

        ];
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A1:F1')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        $sheet->getStyle('A2:' . $highestColumn . $highestRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        return [
            'A1:F1' => [
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                ],
            ],
            'A2:' . $highestColumn . $highestRow => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                ],
            ],
        ];
    }
}
