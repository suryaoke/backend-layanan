<?php

namespace App\Exports;


use App\Models\Jadwalmapel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;



class CatatanUploadExport implements FromView
{
    protected $cttnwalas;

    public function __construct($cttnwalas)
    {
        $this->cttnwalas = $cttnwalas;
    }

    public function view(): View
    {
        return view('backend.data.catatan.excel1', [
            'cttnwalas' => $this->cttnwalas
        ]);
    }
}
