<?php

namespace App\Exports;


use App\Models\Jadwalmapel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;



class SpiritualUploadExport implements FromView
{
    protected $rapor;

    public function __construct($rapor)
    {
        $this->rapor = $rapor;
    }

    public function view(): View
    {
        return view('backend.data.sikap.excel1_spiritual', [
            'rapor' => $this->rapor
        ]);
    }
}
