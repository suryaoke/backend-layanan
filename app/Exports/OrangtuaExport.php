<?php

namespace App\Exports;


use App\Models\Jadwalmapel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;



class OrangtuaExport implements FromView
{
    protected $orangtua;

    public function __construct($orangtua)
    {
        $this->orangtua = $orangtua;
    }

    public function view(): View
    {
        return view('backend.data.orangtua.excel', [
            'orangtua' => $this->orangtua
        ]);
    }
}
