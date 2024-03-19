<?php

namespace App\Imports;

use App\Models\CatataWalas;
use App\Models\Jurusan;
use App\Models\Mapel;
use App\Models\Rapor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class SosialImport implements ToModel, WithHeadingRow
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
        $rapor = Rapor::updateOrCreate(
            ['id' => $row['kode_sosial']],
            [
                'nilai_sosial' => [
                    '0' => $row['kejujuran'],
                    '1' => $row['kedisiplinan'],
                    '2' => $row['tanggung_jawab'],
                    '3' => $row['toleransi'],
                    '4' => $row['gotong_royong'],
                    '5' => $row['kesantunan'],
                    '6' => $row['percaya_diri'],
                ],
            ]
        );

        return $rapor;
    }
}
