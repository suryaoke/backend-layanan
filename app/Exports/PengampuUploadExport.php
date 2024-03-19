<?php

namespace App\Exports;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;



class PengampuUploadExport implements FromView
{
    public function view(): View
    {

        $data['guru'] = Guru::latest()->get();
        $data['mapel'] = Mapel::latest()->get();
        $data['kelas'] = Kelas::latest()->get();

        return view('backend.data.pengampu.excel', $data);
    }
}
