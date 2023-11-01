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

class SiswaExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $siswa;
    protected $counter = 1;
    public function __construct($siswa)
    {
        $this->siswa = $siswa;
    }

    public function collection()
    {
        return $this->siswa;
    }
    public function map($siswa): array
    {
        

        return [
            'No' => $this->counter++,
            'Nama' => isset($siswa->nama) ? $siswa->nama : '',
            'Nisn' => isset($siswa->nisn) ? $siswa->nisn : '',
            'Jk' => isset($siswa->jk) ? $siswa->jk : '',
            'Username' => isset($siswa->users->username) ? $siswa->users->username : '',
        

        ];
    }


    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Nisn',
            'No Hp',
            'Username',
   

        ];
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A1:E1')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        $sheet->getStyle('A2:' . $highestColumn . $highestRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        return [
            'A1:E1' => [
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
