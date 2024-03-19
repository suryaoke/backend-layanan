<?php

namespace App\Imports;

use App\Models\CatataWalas;
use App\Models\Jurusan;
use App\Models\Mapel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class PresensiImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Cari ID Jurusan berdasarkan nama


        // Update atau tambah data Mapel berdasarkan kode_mapel
        $cttnwalas = CatataWalas::updateOrCreate(
            ['id' => $row['kode_presensi']],
            [
                'alfa'      => $row['alfa'] ?? null,
                'izin'       => $row['izin'] ?? null,
                'sakit'         => $row['sakit'] ?? null,

            ]
        );

        return $cttnwalas;
    }
}
