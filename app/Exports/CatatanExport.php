<?php

namespace App\Exports;


use App\Models\Jadwalmapel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;



class CatatanExport implements FromView
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
        return view('backend.data.catatan.excel', [
            'cttnwalas' => $this->cttnwalas,
            'tahun' => $this->tahun
        ]);
    }
}
