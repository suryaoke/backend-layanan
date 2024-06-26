<?php

namespace App\Exports;


use App\Models\Jadwalmapel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class JadwalmapelsExport implements FromView, WithDrawings
{
    protected $jadwalmapel;
    protected $jadwal;
    protected $hari;

    public function __construct($jadwalmapel, $jadwal, $hari)
    {
        $this->jadwalmapel = $jadwalmapel;
        $this->jadwal = $jadwal;
        $this->hari = $hari;
    }

    public function view(): View
    {
        return view('backend.data.jadwalmapel.excel', [
            'jadwalmapel' => $this->jadwalmapel,
            'jadwal' => $this->jadwal,
            'hari' => $this->hari
        ]);
    }
    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/backend/dist/images/man1_copy.png'));
        $drawing->setHeight(85);
        $drawing->setCoordinates('B2');

        return $drawing;
    }
}
