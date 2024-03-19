<?php

namespace App\Exports;


use App\Models\Jadwalmapel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;



class GuruExport implements FromView
{
    protected $guru;

    public function __construct($guru)
    {
        $this->guru = $guru;
    }

    public function view(): View
    {
        return view('backend.data.guru.excel', [
            'guru' => $this->guru
        ]);
    }
}
