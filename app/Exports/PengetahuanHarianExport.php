<?php

namespace App\Exports;


use App\Models\Jadwalmapel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;



class PengetahuanHarianExport implements FromView
{
    protected $rombelsiswa;
    protected $id;

    public function __construct($rombelsiswa, $id)
    {
        $this->rombelsiswa = $rombelsiswa;
        $this->id = $id;
    }

    public function view(): View
    {
        return view('backend.data.nilai.pengetahuan_harian_excel', [
            'rombelsiswa' => $this->rombelsiswa,
            'id' => $this->id,
        ]);
    }
}
