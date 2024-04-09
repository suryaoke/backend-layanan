<?php

namespace App\Exports;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Tahunajar;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class PengampuUploadExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'Template Pengampu' => new TabelSatuSheet(),
            'Data' => new TabelDuaSheet()
        ];
    }
}


class TabelSatuSheet implements FromView, WithTitle
{
    public function view(): View
    {
        return view('backend.data.pengampu.excel');
    }

    public function title(): string
    {
        return 'Template Pengampu';
    }
}

class TabelDuaSheet implements FromView, WithTitle
{
    public function view(): View
    {
        $data['guru'] = Guru::latest()->get();
        $data['mapel'] = Mapel::latest()->get();
        $data['kelas'] = Kelas::latest()->get();
        $data['tahun'] = Tahunajar::latest()->get();

        return view('backend.data.pengampu.excel2', $data);
    }

    public function title(): string
    {
        return 'Data';
    }
}
