<?php

namespace App\Exports;


use App\Models\Jadwalmapel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;



class PrestasiExport implements FromView
{
    protected $cttnwalas;
    protected $tahun;

    public function __construct($cttnwalas, $tahun)
    {
        $this->cttnwalas = $cttnwalas;
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        return view('backend.data.prestasi.excel', [
            'cttnwalas' => $this->cttnwalas,
            'tahun' => $this->tahun
        ]);
    }
}
