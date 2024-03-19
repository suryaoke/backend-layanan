<?php

namespace App\Exports;


use App\Models\Jadwalmapel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;



class SiswaExport implements FromView
{
    protected $siswa;

    public function __construct($siswa)
    {
        $this->siswa = $siswa;
    }

    public function view(): View
    {
        return view('backend.data.siswa.siswa_excel', [
            'siswa' => $this->siswa
        ]);
    }
}
