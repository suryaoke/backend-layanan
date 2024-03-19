<?php

namespace App\Imports;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Pengampu;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PengampuImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Hanya impor jika data pada heading yang spesifik tidak kosong
        if (!empty($row['template_kode_guru']) && !empty($row['template_kode_mapel']) && !empty($row['template_id_kelas'])) {
            $kode_gr = null;
            if (isset($row['template_kode_guru'])) {
                $kode_gr = Guru::where('kode_gr', $row['template_kode_guru'])->first();
                if ($kode_gr) {
                    $kode_gr = $kode_gr->id;
                }
            }

            $kode_mapel = null;
            if (isset($row['template_kode_mapel'])) {
                $kode_mapel = Mapel::where('kode_mapel', $row['template_kode_mapel'])->first();
                if ($kode_mapel) {
                    $kode_mapel = $kode_mapel->id;
                }
            }

            $kelas = null;
            if (isset($row['template_id_kelas'])) {
                $kelas = Kelas::where('id', $row['template_id_kelas'])->first();
                if ($kelas) {
                    $kelas = $kelas->id;
                }
            }

            // Return instance of Mapel model
            do {
                $kode_acak = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 4);
                $kode_pengampu =  $kode_mapel . '.' . $kode_gr . '.' . $kode_acak;
                $existingPengampu = Pengampu::where('kode_pengampu', $kode_pengampu)->first();
            } while (!empty($existingPengampu));

            return new Pengampu([
                'kode_pengampu' => $kode_pengampu,
                'id_guru' => $kode_gr,
                'id_mapel' => $kode_mapel,
                'kelas' => $kelas,
            ]);
        }

        // Jika data pada heading yang spesifik kosong, kembalikan null (tidak ada yang diimpor)
        return null;
    }
}
