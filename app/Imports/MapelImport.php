<?php

namespace App\Imports;

use App\Models\Jurusan;
use App\Models\Mapel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MapelImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Cari ID Jurusan berdasarkan nama
        $id_jurusan = null;
        if (isset($row['jurusan'])) {
            $jurusan = Jurusan::where('nama', $row['jurusan'])->first();
            if ($jurusan) {
                $id_jurusan = $jurusan->id;
            }
        }

        // Return instance of Mapel model
        return new Mapel([
            'kode_mapel' => $row['kode_mapel'] ?? null,
            'induk'      => $row['induk'] ?? null,
            'nama'       => $row['nama'] ?? null,
            'jp'         => $row['jp'] ?? null,
            'id_jurusan' => $id_jurusan,
            'jenis'      => $row['jenis'] ?? null
        ]);
    }
}
