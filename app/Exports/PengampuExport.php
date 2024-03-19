<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PengampuExport implements FromView
{
    protected $pengampu;

    public function __construct($pengampu)
    {
        $this->pengampu = $pengampu;
    }

    public function view(): View
    {
        return view('backend.data.pengampu.pengampu_excel', [
            'pengampu' => $this->pengampu
        ]);
    }
}
