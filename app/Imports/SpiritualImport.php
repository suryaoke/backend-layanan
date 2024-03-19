<?php

namespace App\Imports;

use App\Models\CatataWalas;
use App\Models\Jurusan;
use App\Models\Mapel;
use App\Models\Rapor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

class SpiritualImport implements ToModel, WithHeadingRow
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
            ['id' => $row['kode_spiritual']],
            [
                'nilai_spiritual' => [
                    '0' => $row['berdoa'],
                    '1' => $row['memberi_salam'],
                    '2' => $row['sholat_berjamaah'],
                    '3' => $row['bersyukur'],

                ],
            ]
        );

        return $rapor;
    }
}
