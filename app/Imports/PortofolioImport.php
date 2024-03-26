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

class PortofolioImport implements WithMultipleSheets
{
    protected $id_seksi;
    protected $id_tahunajar;
    protected $kd;
    // Constructor untuk menginisialisasi $id
    public function __construct($id_seksi, $id_tahunajar, $kd)
    {
        $this->id_seksi = $id_seksi;
        $this->id_tahunajar = $id_tahunajar;
        $this->kd = $kd;
    }

    /**
     * @param array $sheets
     */
    public function sheets(): array
    {
        return [
            0 => new FirstSheetImport($this->id_seksi, $this->id_tahunajar, $this->kd),
            1 => new SecondSheetImport($this->id_seksi, $this->id_tahunajar, $this->kd),
            2 => new TigaSheetImport($this->id_seksi, $this->id_tahunajar, $this->kd),
            3 => new EmpatSheetImport($this->id_seksi, $this->id_tahunajar, $this->kd),
            4 => new LimaSheetImport($this->id_seksi, $this->id_tahunajar, $this->kd),

        ];
    }
}

class FirstSheetImport implements ToModel, WithHeadingRow
{
    protected $id_seksi;
    protected $id_tahunajar;
    protected $kd;
    public function __construct($id_seksi, $id_tahunajar, $kd)
    {
        $this->id_seksi = $id_seksi;
        $this->id_tahunajar = $id_tahunajar;
        $this->kd = $kd;
    }

    public function model(array $row)
    {

        if (!empty($row['kode_siswa']) && !empty($row['materi'])) {
            return new Nilai([
                'id_seksi' =>  $this->id_seksi,
                'id_rombelsiswa' => $row['kode_siswa'],
                'id_tahunajar' => $this->id_tahunajar,
                'nilai_keterampilan' => $row['nilai'],
                'catatan_keterampilan' => $row['materi'],
                'type_nilai' => 3,
                'kd' => $this->kd + 1,
                'type_keterampilan' => 1,
                'status' => 0,
            ]);
        }
    }
}

class SecondSheetImport implements ToModel, WithHeadingRow
{
    protected $id_seksi;
    protected $id_tahunajar;
    protected $kd;

    public function __construct($id_seksi, $id_tahunajar, $kd)
    {
        $this->id_seksi = $id_seksi;
        $this->id_tahunajar = $id_tahunajar;
        $this->kd = $kd;
    }

    public function model(array $row)
    {
        // Logic untuk mengimpor data dari sheet pertama
        if (!empty($row['kode_siswa']) && !empty($row['materi'])) {

            return new Nilai([
                'id_seksi' =>  $this->id_seksi,
                'id_rombelsiswa' => $row['kode_siswa'],
                'id_tahunajar' => $this->id_tahunajar,
                'nilai_keterampilan' => $row['nilai'],
                'catatan_keterampilan' => $row['materi'],
                'type_nilai' => 3,
                'kd' => $this->kd + 2,
                'type_keterampilan' => 1,
                'status' => 0,
            ]);
        }
    }
}

class TigaSheetImport implements ToModel, WithHeadingRow
{
    protected $id_seksi;
    protected $id_tahunajar;
    protected $kd;

    public function __construct($id_seksi, $id_tahunajar, $kd)
    {
        $this->id_seksi = $id_seksi;
        $this->id_tahunajar = $id_tahunajar;
        $this->kd = $kd;
    }

    public function model(array $row)
    {
        // Logic untuk mengimpor data dari sheet pertama
        if (!empty($row['kode_siswa']) && !empty($row['materi'])) {


            return new Nilai([
                'id_seksi' =>  $this->id_seksi,
                'id_rombelsiswa' => $row['kode_siswa'],
                'id_tahunajar' => $this->id_tahunajar,
                'nilai_keterampilan' => $row['nilai'],
                'catatan_keterampilan' => $row['materi'],
                'type_nilai' => 3,
                'kd' => $this->kd + 3,
                'type_keterampilan' => 1,
                'status' => 0,
            ]);
        }
    }
}

class EmpatSheetImport implements ToModel, WithHeadingRow
{
    protected $id_seksi;
    protected $id_tahunajar;
    protected $kd;

    public function __construct($id_seksi, $id_tahunajar, $kd)
    {
        $this->id_seksi = $id_seksi;
        $this->id_tahunajar = $id_tahunajar;
        $this->kd = $kd;
    }

    public function model(array $row)
    {
        // Logic untuk mengimpor data dari sheet pertama
        if (!empty($row['kode_siswa']) && !empty($row['materi'])) {


            return new Nilai([
                'id_seksi' =>  $this->id_seksi,
                'id_rombelsiswa' => $row['kode_siswa'],
                'id_tahunajar' => $this->id_tahunajar,
                'nilai_keterampilan' => $row['nilai'],
                'catatan_keterampilan' => $row['materi'],
                'type_nilai' => 3,
                'kd' => $this->kd + 4,
                'type_keterampilan' => 1,
                'status' => 0,
            ]);
        }
    }
}


class LimaSheetImport implements ToModel, WithHeadingRow
{
    protected $id_seksi;
    protected $id_tahunajar;
    protected $kd;

    public function __construct($id_seksi, $id_tahunajar, $kd)
    {
        $this->id_seksi = $id_seksi;
        $this->id_tahunajar = $id_tahunajar;
        $this->kd = $kd;
    }

    public function model(array $row)
    {
        // Logic untuk mengimpor data dari sheet pertama
        if (!empty($row['kode_siswa']) && !empty($row['materi'])) {


            return new Nilai([
                'id_seksi' =>  $this->id_seksi,
                'id_rombelsiswa' => $row['kode_siswa'],
                'id_tahunajar' => $this->id_tahunajar,
                'nilai_keterampilan' => $row['nilai'],
                'catatan_keterampilan' => $row['materi'],
                'type_nilai' => 3,
                'kd' => $this->kd + 5,
                'type_keterampilan' => 1,
                'status' => 0,
            ]);
        }
    }
}
