<?php

namespace App\Exports;


use App\Models\Jadwalmapel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;



class PengetahuanAkhirUploadExport implements FromView
{

    protected $rombelsiswa;
    protected $id;
    protected $tahun;

    public function __construct($rombelsiswa, $id, $tahun)
    {
        $this->rombelsiswa = $rombelsiswa;
        $this->id = $id;
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        return view('backend.data.nilai.pengetahuan_akhir_excel_template', [
            'rombelsiswa' => $this->rombelsiswa,
            'id' => $this->id,
            'tahun' => $this->tahun,
        ]);
    }
}
