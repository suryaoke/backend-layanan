<?php

namespace App\Exports;


use App\Models\Jadwalmapel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;



class SeksiExport implements FromView
{
    protected $seksi;
    protected $dataseksi;

    public function __construct($seksi, $dataseksi)
    {
        $this->seksi = $seksi;
        $this->dataseksi = $dataseksi;
    }

    public function view(): View
    {
        return view('backend.data.seksi.excel', [
            'seksi' => $this->seksi,
            'dataseksi' => $this->dataseksi
        ]);
    }
}
