<?php

namespace App\Exports;


use App\Models\Siswa;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;


class LeggerExport implements FromView, WithDrawings
{
    protected $seksi;
    protected $tahun;
    protected $rombelsiswa;
    protected $dataseksi;
    public function __construct($seksi, $tahun, $rombelsiswa, $dataseksi)
    {
        $this->seksi = $seksi;
        $this->tahun = $tahun;
        $this->rombelsiswa = $rombelsiswa;
        $this->dataseksi = $dataseksi;
    }

    public function view(): View
    {
        return view('backend.data.rapor.legger_excel', [
            'seksi' => $this->seksi,
            'tahun' => $this->tahun,
            'rombelsiswa' => $this->rombelsiswa,
            'dataseksi' => $this->dataseksi
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
