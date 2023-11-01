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

class UserExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $user;
    protected $counter = 1;
    public function __construct($user)
    {
        $this->user = $user;
    }

    public function collection()
    {
        return $this->user;
    }
    public function map($user): array
    {
        $role = '';
        if ($user->role  == 1) {
            $role = 'Admin';
        } elseif ($user->role  == 2) {
            $role = 'Kepala Sekolah';
        } elseif ($user->role  == 3) {
            $role = 'Operator';
        } elseif ($user->role  == 4) {
            $role = 'Guru';
        } elseif ($user->role  == 5) {
            $role = 'Orangtua';
        } elseif ($user->role  == 6) {
            $role = 'Siswa';
        }

        return [

            'No' => $this->counter++,
            'Nama' => isset($user->name) ? $user->name : '',
            'Username' => isset($user->username) ? $user->username : '',
            'Email' => isset($user->email) ? $user->email : '',
            'Role' => $role,
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Username',
            'Email',
            'Role',

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
