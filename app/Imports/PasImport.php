<?php

namespace App\Imports;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Pengampu;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PasImport implements ToModel, WithHeadingRow
{

    protected $id_seksi;
    protected $id_tahunajar;

    // Constructor untuk menginisialisasi $id
    public function __construct($id_seksi, $id_tahunajar)
    {
        $this->id_seksi = $id_seksi;
        $this->id_tahunajar = $id_tahunajar;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Hanya impor jika data pada heading yang spesifik tidak kosong
        if (!empty($row['kode_siswa'])) {


            return new Nilai([
                'id_seksi' =>  $this->id_seksi,
                'id_rombelsiswa' => $row['kode_siswa'],
                'id_tahunajar' => $this->id_tahunajar,
                'nilai_pengetahuan_akhir' => $row['nilai'],
                'type_nilai' => 2,
                'status' => 0,

            ]);
        }

        // Jika data pada heading yang spesifik kosong, kembalikan null (tidak ada yang diimpor)
        return null;
    }
}
