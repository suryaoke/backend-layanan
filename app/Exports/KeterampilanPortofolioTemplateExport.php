<?php

namespace App\Exports;

use App\Models\Jadwalmapel;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class KeterampilanPortofolioTemplateExport implements WithMultipleSheets
{
    protected $rombelsiswa;
    protected $id;
    protected $tahun;
    protected $kd;


    public function __construct($rombelsiswa, $id, $tahun, $kd)
    {
        $this->rombelsiswa = $rombelsiswa;
        $this->id = $id;
        $this->tahun = $tahun;
        $this->kd = $kd;
    }

    public function sheets(): array
    {
        return [
            new TabelSatuuSheet($this->rombelsiswa, $this->id, $this->tahun, $this->kd),
            new TabelDuaaSheet($this->rombelsiswa, $this->id, $this->tahun, $this->kd),
            new TabelTigaSheet($this->rombelsiswa, $this->id, $this->tahun, $this->kd),
            new TabelEmpatSheet($this->rombelsiswa, $this->id, $this->tahun, $this->kd),
            new TabelLimaSheet($this->rombelsiswa, $this->id, $this->tahun, $this->kd),
        ];
    }
}

class TabelSatuuSheet implements FromView, WithTitle
{
    protected $rombelsiswa;
    protected $id;
    protected $tahun;
    protected $kd;

    public function __construct($rombelsiswa, $id, $tahun, $kd)
    {
        $this->rombelsiswa = $rombelsiswa;
        $this->id = $id;
        $this->tahun = $tahun;
        $this->kd = $kd;
    }

    public function view(): View
    {
        return view('backend.data.nilai.keterampilan_portofolio_excel_template', [
            'rombelsiswa' => $this->rombelsiswa,
            'id' => $this->id,
            'tahun' => $this->tahun,
            'kd' => $this->kd,
        ]);
    }

    public function title(): string
    {
        // Menambahkan 1 pada nilai kd untuk mendapatkan judul yang sesuai
        return 'kd ' . ($this->kd + 1);
    }
}

class TabelDuaaSheet implements FromView, WithTitle
{
    protected $rombelsiswa;
    protected $id;
    protected $tahun;
    protected $kd;

    public function __construct($rombelsiswa, $id, $tahun, $kd)
    {
        $this->rombelsiswa = $rombelsiswa;
        $this->id = $id;
        $this->tahun = $tahun;
        $this->kd = $kd;
    }

    public function view(): View
    {
        return view('backend.data.nilai.keterampilan_portofolio_excel_template', [
            'rombelsiswa' => $this->rombelsiswa,
            'id' => $this->id,
            'tahun' => $this->tahun,
            'kd' => $this->kd,

        ]);
    }

    public function title(): string
    {
        return 'kd ' . ($this->kd + 2);
    }
}
class TabelTigaSheet implements FromView, WithTitle
{
    protected $rombelsiswa;
    protected $id;
    protected $tahun;
    protected $kd;

    public function __construct($rombelsiswa, $id, $tahun, $kd)
    {
        $this->rombelsiswa = $rombelsiswa;
        $this->id = $id;
        $this->tahun = $tahun;
        $this->kd = $kd;
    }

    public function view(): View
    {
        return view('backend.data.nilai.keterampilan_portofolio_excel_template', [
            'rombelsiswa' => $this->rombelsiswa,
            'id' => $this->id,
            'tahun' => $this->tahun,
            'kd' => $this->kd,
        ]);
    }

    public function title(): string
    {
        return 'kd ' . ($this->kd + 3);
    }
}
class TabelEmpatSheet implements FromView, WithTitle
{
    protected $rombelsiswa;
    protected $id;
    protected $tahun;
    protected $kd;
    public function __construct($rombelsiswa, $id, $tahun, $kd)
    {
        $this->rombelsiswa = $rombelsiswa;
        $this->id = $id;
        $this->tahun = $tahun;
        $this->kd = $kd;
    }

    public function view(): View
    {
        return view('backend.data.nilai.keterampilan_portofolio_excel_template', [
            'rombelsiswa' => $this->rombelsiswa,
            'id' => $this->id,
            'tahun' => $this->tahun,
            'kd' => $this->kd,
        ]);
    }

    public function title(): string
    {
        return 'kd ' . ($this->kd + 4);
    }
}
class TabelLimaSheet implements FromView, WithTitle
{
    protected $rombelsiswa;
    protected $id;
    protected $tahun;
    protected $kd;

    public function __construct($rombelsiswa, $id, $tahun, $kd)
    {
        $this->rombelsiswa = $rombelsiswa;
        $this->id = $id;
        $this->tahun = $tahun;
        $this->kd = $kd;
    }

    public function view(): View
    {
        return view('backend.data.nilai.keterampilan_portofolio_excel_template', [
            'rombelsiswa' => $this->rombelsiswa,
            'id' => $this->id,
            'tahun' => $this->tahun,
            'kd' => $this->kd,
        ]);
    }

    public function title(): string
    {
        return 'kd ' . ($this->kd + 5);
    }
}
