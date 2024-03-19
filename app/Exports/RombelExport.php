<?php

namespace App\Exports;


use App\Models\Jadwalmapel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;



class RombelExport implements FromView
{
    protected $rombelsiswa;

    public function __construct($rombelsiswa)
    {
        $this->rombelsiswa = $rombelsiswa;
    }

    public function view(): View
    {
        return view('backend.data.rombel.excel', [
            'rombelsiswa' => $this->rombelsiswa
        ]);
    }
}
