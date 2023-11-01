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

class OrangtuaExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $orangtua;
    protected $counter = 1;
    public function __construct($orangtua)
    {
        $this->orangtua = $orangtua;
    }

    public function collection()
    {
        return $this->orangtua;
    }
    public function map($orangtua): array
    {

        return [
            'No' => $this->counter++,
            'Kode Orangtua' => isset($orangtua->kode_ortu) ? $orangtua->kode_ortu : '',
            'Nama' => isset($orangtua->nama) ? $orangtua->nama : '',
            'No Hp' => isset($orangtua->no_hp) ? $orangtua->no_hp : '',
            'Username' => isset($orangtua->users->username) ? $orangtua->users->username : '',
            'Nama Siswa' => isset($orangtua->siswas->nama) ? $orangtua->siswas->nama : '',

        ];
    }


    public function headings(): array
    {
        return [
            'No',
            'kode Orangtua',
            'Nama',
            'No Hp',
            'Username',
            'Nama Siswa',

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
