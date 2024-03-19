<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class MapelExport implements FromView
{
    protected $mapel;

    public function __construct($mapel)
    {
        $this->mapel = $mapel;
    }

    public function view(): View
    {
        return view('backend.data.mapel.excel', [
            'mapel' => $this->mapel
        ]);
    }
}
