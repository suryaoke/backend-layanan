<?php

namespace App\Imports;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Pengampu;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class HarianImport implements WithMultipleSheets
{
    protected $id_seksi;
    protected $id_tahunajar;
    protected $ph;
    // Constructor untuk menginisialisasi $id
    public function __construct($id_seksi, $id_tahunajar, $ph)
    {
        $this->id_seksi = $id_seksi;
        $this->id_tahunajar = $id_tahunajar;
        $this->ph = $ph;
    }

    /**
     * @param array $sheets
     */
    public function sheets(): array
    {
        return [
            0 => new FirstSheetImport($this->id_seksi, $this->id_tahunajar, $this->ph),
            1 => new SecondSheetImport($this->id_seksi, $this->id_tahunajar, $this->ph),
            2 => new TigaSheetImport($this->id_seksi, $this->id_tahunajar, $this->ph),
            3 => new EmpatSheetImport($this->id_seksi, $this->id_tahunajar, $this->ph),
            4 => new LimaSheetImport($this->id_seksi, $this->id_tahunajar, $this->ph),

        ];
    }
}

class FirstSheetImport implements ToModel, WithHeadingRow
{
    protected $id_seksi;
    protected $id_tahunajar;
    protected $ph;
    public function __construct($id_seksi, $id_tahunajar, $ph)
    {
        $this->id_seksi = $id_seksi;
        $this->id_tahunajar = $id_tahunajar;
        $this->ph = $ph;
    }

    public function model(array $row)
    {

        if (!empty($row['kode_siswa']) && !empty($row['materi'])) {
            return new Nilai([
                'id_seksi' =>  $this->id_seksi,
                'id_rombelsiswa' => $row['kode_siswa'],
                'id_tahunajar' => $this->id_tahunajar,
                'nilai_pengetahuan' => $row['nilai'],
                'catatan_pengetahuan' => $row['materi'],
                'type_nilai' => 1,
                'ph' => $this->ph + 1,
                'status' => 0,
            ]);
        }
    }
}

class SecondSheetImport implements ToModel, WithHeadingRow
{
    protected $id_seksi;
    protected $id_tahunajar;
    protected $ph;

    public function __construct($id_seksi, $id_tahunajar, $ph)
    {
        $this->id_seksi = $id_seksi;
        $this->id_tahunajar = $id_tahunajar;
        $this->ph = $ph;
    }

    public function model(array $row)
    {
        // Logic untuk mengimpor data dari sheet pertama
        if (!empty($row['kode_siswa']) && !empty($row['materi'])) {

            return new Nilai([
                'id_seksi' =>  $this->id_seksi,
                'id_rombelsiswa' => $row['kode_siswa'],
                'id_tahunajar' => $this->id_tahunajar,
                'nilai_pengetahuan' => $row['nilai'],
                'catatan_pengetahuan' => $row['materi'],
                'type_nilai' => 1,
                'ph' => $this->ph + 2,
                'status' => 0,
            ]);
        }
    }
}

class TigaSheetImport implements ToModel, WithHeadingRow
{
    protected $id_seksi;
    protected $id_tahunajar;
    protected $ph;

    public function __construct($id_seksi, $id_tahunajar, $ph)
    {
        $this->id_seksi = $id_seksi;
        $this->id_tahunajar = $id_tahunajar;
        $this->ph = $ph;
    }

    public function model(array $row)
    {
        // Logic untuk mengimpor data dari sheet pertama
        if (!empty($row['kode_siswa']) && !empty($row['materi'])) {


            return new Nilai([
                'id_seksi' =>  $this->id_seksi,
                'id_rombelsiswa' => $row['kode_siswa'],
                'id_tahunajar' => $this->id_tahunajar,
                'nilai_pengetahuan' => $row['nilai'],
                'catatan_pengetahuan' => $row['materi'],
                'type_nilai' => 1,
                'ph' => $this->ph + 3,
                'status' => 0,
            ]);
        }
    }
}

class EmpatSheetImport implements ToModel, WithHeadingRow
{
    protected $id_seksi;
    protected $id_tahunajar;
    protected $ph;

    public function __construct($id_seksi, $id_tahunajar, $ph)
    {
        $this->id_seksi = $id_seksi;
        $this->id_tahunajar = $id_tahunajar;
        $this->ph = $ph;
    }

    public function model(array $row)
    {
        // Logic untuk mengimpor data dari sheet pertama
        if (!empty($row['kode_siswa']) && !empty($row['materi'])) {


            return new Nilai([
                'id_seksi' =>  $this->id_seksi,
                'id_rombelsiswa' => $row['kode_siswa'],
                'id_tahunajar' => $this->id_tahunajar,
                'nilai_pengetahuan' => $row['nilai'],
                'catatan_pengetahuan' => $row['materi'],
                'type_nilai' => 1,
                'ph' => $this->ph + 4,
                'status' => 0,
            ]);
        }
    }
}


class LimaSheetImport implements ToModel, WithHeadingRow
{
    protected $id_seksi;
    protected $id_tahunajar;
    protected $ph;

    public function __construct($id_seksi, $id_tahunajar, $ph)
    {
        $this->id_seksi = $id_seksi;
        $this->id_tahunajar = $id_tahunajar;
        $this->ph = $ph;
    }

    public function model(array $row)
    {
        // Logic untuk mengimpor data dari sheet pertama
        if (!empty($row['kode_siswa']) && !empty($row['materi'])) {


            return new Nilai([
                'id_seksi' =>  $this->id_seksi,
                'id_rombelsiswa' => $row['kode_siswa'],
                'id_tahunajar' => $this->id_tahunajar,
                'nilai_pengetahuan' => $row['nilai'],
                'catatan_pengetahuan' => $row['materi'],
                'type_nilai' => 1,
                'ph' => $this->ph + 5,
                'status' => 0,
            ]);
        }
    }
}
