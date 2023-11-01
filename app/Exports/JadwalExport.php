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

class JadwalExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStyles
{
    protected $jadwalmapel;
    protected $counter = 1;
    public function __construct($jadwalmapel)
    {
        $this->jadwalmapel = $jadwalmapel;
    }

    public function collection()
    {
        return $this->jadwalmapel;
    }
    public function map($jadwalmapel): array
    {
        $jadwalmapelTingkat = isset($jadwalmapel->pengampus->kelass->tingkat) ? $jadwalmapel->pengampus->kelass->tingkat : '';
        $jadwalmapelNama = isset($jadwalmapel->pengampus->kelass->nama) ? $jadwalmapel->pengampus->kelass->nama : '';
        $jadwalmapelJurusan = isset($jadwalmapel->pengampus->kelass->jurusans->nama) ? $jadwalmapel->pengampus->kelass->jurusans->nama : '';

        $semester = isset($jadwalmapel->pengampus->mapels->tahunajars->semester) ? $jadwalmapel->pengampus->mapels->tahunajars->semester : '';
        $tahunsemester = isset($jadwalmapel->pengampus->mapels->tahunajars->tahun) ? $jadwalmapel->pengampus->mapels->tahunajars->tahun : '';
        return [
            'No' => $this->counter++,
            'Seksi' => isset($jadwalmapel->kode_jadwalmapel) ? $jadwalmapel->kode_jadwalmapel : '',
            'Kode' => isset($jadwalmapel->pengampus->kode_pengampu) ? $jadwalmapel->pengampus->kode_pengampu : '',
            'Hari' => isset($jadwalmapel->haris->nama) ? $jadwalmapel->haris->nama : '',
            'Waktu' => isset($jadwalmapel->waktus->range) ? $jadwalmapel->waktus->range : '',
            'Guru' => isset($jadwalmapel->pengampus->gurus->nama) ? $jadwalmapel->pengampus->gurus->nama : '',
            'Mata Pelajaran' => isset($jadwalmapel->pengampus->mapels->nama) ? $jadwalmapel->pengampus->mapels->nama : '',
            'Kelas' => $jadwalmapelTingkat . ' ' . $jadwalmapelNama . ' ' . $jadwalmapelJurusan,
            'Jp' => isset($jadwalmapel->pengampus->mapels->jp) ? $jadwalmapel->pengampus->mapels->jp : '',
            'Kode Ruangan' => isset($jadwalmapel->ruangans->kode_ruangan) ? $jadwalmapel->ruangans->kode_ruangan  : '',
            'Semester' => $semester . ' ' . '-' . ' ' . $tahunsemester,

        ];
    }


    public function headings(): array
    {
        return [
            'No',
            'Seksi',
            'Kode',
            'Hari',
            'Waktu',
            'Guru',
            'Mata Pelajaran',
            'Kelas',
            'Jp',
            'Kode Ruangan',
            'Semester',

        ];
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:K1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
            ],
        ]);

        $sheet->getStyle('A1:K1')->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        $sheet->getStyle('A2:' . $highestColumn . $highestRow)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        return [
            'A1:K1' => [
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
