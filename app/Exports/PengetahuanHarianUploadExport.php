<?php

namespace App\Exports;

use App\Models\Jadwalmapel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class PengetahuanHarianUploadExport implements WithMultipleSheets
{
    protected $rombelsiswa;
    protected $id;
    protected $tahun;
    protected $ph;


    public function __construct($rombelsiswa, $id, $tahun, $ph)
    {
        $this->rombelsiswa = $rombelsiswa;
        $this->id = $id;
        $this->tahun = $tahun;
        $this->ph = $ph;
    }

    public function sheets(): array
    {
        return [
            new TabelSatuuSheet($this->rombelsiswa, $this->id, $this->tahun, $this->ph),
            new TabelDuaaSheet($this->rombelsiswa, $this->id, $this->tahun, $this->ph),
            new TabelTigaSheet($this->rombelsiswa, $this->id, $this->tahun, $this->ph),
            new TabelEmpatSheet($this->rombelsiswa, $this->id, $this->tahun, $this->ph),
            new TabelLimaSheet($this->rombelsiswa, $this->id, $this->tahun, $this->ph),
        ];
    }
}

class TabelSatuuSheet implements FromView, WithTitle
{
    protected $rombelsiswa;
    protected $id;
    protected $tahun;
    protected $ph;

    public function __construct($rombelsiswa, $id, $tahun, $ph)
    {
        $this->rombelsiswa = $rombelsiswa;
        $this->id = $id;
        $this->tahun = $tahun;
        $this->ph = $ph;
    }

    public function view(): View
    {
        return view('backend.data.nilai.pengetahuan_harian_excel_template', [
            'rombelsiswa' => $this->rombelsiswa,
            'id' => $this->id,
            'tahun' => $this->tahun,
            'ph' => $this->ph,
        ]);
    }

    public function title(): string
    {
        // Menambahkan 1 pada nilai PH untuk mendapatkan judul yang sesuai
        return 'PH ' . ($this->ph + 1);
    }
}

class TabelDuaaSheet implements FromView, WithTitle
{
    protected $rombelsiswa;
    protected $id;
    protected $tahun;
    protected $ph;

    public function __construct($rombelsiswa, $id, $tahun, $ph)
    {
        $this->rombelsiswa = $rombelsiswa;
        $this->id = $id;
        $this->tahun = $tahun;
        $this->ph = $ph;
    }

    public function view(): View
    {
        return view('backend.data.nilai.pengetahuan_harian_excel_template', [
            'rombelsiswa' => $this->rombelsiswa,
            'id' => $this->id,
            'tahun' => $this->tahun,
            'ph' => $this->ph,

        ]);
    }

    public function title(): string
    {
        return 'PH ' . ($this->ph + 2);
    }
}
class TabelTigaSheet implements FromView, WithTitle
{
    protected $rombelsiswa;
    protected $id;
    protected $tahun;
    protected $ph;

    public function __construct($rombelsiswa, $id, $tahun, $ph)
    {
        $this->rombelsiswa = $rombelsiswa;
        $this->id = $id;
        $this->tahun = $tahun;
        $this->ph = $ph;
    }

    public function view(): View
    {
        return view('backend.data.nilai.pengetahuan_harian_excel_template', [
            'rombelsiswa' => $this->rombelsiswa,
            'id' => $this->id,
            'tahun' => $this->tahun,
            'ph' => $this->ph,
        ]);
    }

    public function title(): string
    {
        return 'PH ' . ($this->ph + 3);
    }
}
class TabelEmpatSheet implements FromView, WithTitle
{
    protected $rombelsiswa;
    protected $id;
    protected $tahun;
    protected $ph;
    public function __construct($rombelsiswa, $id, $tahun, $ph)
    {
        $this->rombelsiswa = $rombelsiswa;
        $this->id = $id;
        $this->tahun = $tahun;
        $this->ph = $ph;
    }

    public function view(): View
    {
        return view('backend.data.nilai.pengetahuan_harian_excel_template', [
            'rombelsiswa' => $this->rombelsiswa,
            'id' => $this->id,
            'tahun' => $this->tahun,
            'ph' => $this->ph,
        ]);
    }

    public function title(): string
    {
        return 'PH ' . ($this->ph + 4);
    }
}
class TabelLimaSheet implements FromView, WithTitle
{
    protected $rombelsiswa;
    protected $id;
    protected $tahun;
    protected $ph;

    public function __construct($rombelsiswa, $id, $tahun, $ph)
    {
        $this->rombelsiswa = $rombelsiswa;
        $this->id = $id;
        $this->tahun = $tahun;
        $this->ph = $ph;
    }

    public function view(): View
    {
        return view('backend.data.nilai.pengetahuan_harian_excel_template', [
            'rombelsiswa' => $this->rombelsiswa,
            'id' => $this->id,
            'tahun' => $this->tahun,
            'ph' => $this->ph,
        ]);
    }

    public function title(): string
    {
        return 'PH ' . ($this->ph + 5);
    }
}
