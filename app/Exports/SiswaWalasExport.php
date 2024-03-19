<?php

namespace App\Exports;


use App\Models\Siswa;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;



class SiswaWalasExport implements FromView
{
    protected $rombelsiswa;
    protected $tahun;

    public function __construct($rombelsiswa, $tahun)
    {
        $this->rombelsiswa = $rombelsiswa;
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        return view('backend.data.siswa.excel', [
            'rombelsiswa' => $this->rombelsiswa,
            'tahun' => $this->tahun
        ]);
    }
}
