<?php

namespace App\Exports;


use App\Models\Jadwalmapel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;



class SpiritualExport implements FromView
{
    protected $rapor;
    protected $tahun;

    public function __construct($rapor, $tahun)
    {
        $this->rapor = $rapor;
        $this->tahun = $tahun;
    }

    public function view(): View
    {
        return view('backend.data.sikap.excel_spiritual', [
            'rapor' => $this->rapor,
            'tahun' => $this->tahun

        ]);
    }
}
