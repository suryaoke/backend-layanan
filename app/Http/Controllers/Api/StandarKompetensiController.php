<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Jadwalmapel;
use App\Models\Mapel;
use App\Models\NilaiKd3;
use App\Models\NilaiKd4;
use App\Models\NilaisiswaKd3;
use App\Models\NilaisiswaKd4;
use App\Models\OrangTua;
use App\Models\Pengampu;
use App\Models\Rombelsiswa;
use App\Models\Seksi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StandarKompetensiController extends Controller
{
    public function Kd3()
    {
        try {
            $userId = Auth::id();


            // Find the corresponding student record with the provided user ID
            $ortu = OrangTua::where('id_user', $userId)->first();
            $siswa = Siswa::where('id', $ortu->id_siswa)->first();
            $rombelSiswaIds = RombelSiswa::where('id_siswa', $siswa->id)->pluck('id')->toArray();
            $nilaiSiswaKd3 = NilaisiswaKd3::whereIn('id_rombelsiswa', $rombelSiswaIds)->get();



            $responseKd3 = [];
            foreach ($nilaiSiswaKd3 as $nilaisiswaId) {
                $rombelsiswaData = Rombelsiswa::find($nilaisiswaId->id_rombelsiswa);
                $siswaData = Siswa::find($rombelsiswaData->id_siswa);

                $nilaikd3Data = NilaiKd3::find($nilaisiswaId->id_nilaikd3);
                $seksiData = Seksi::find($nilaikd3Data->id_seksi);
                $dataJadwal = Jadwalmapel::find($seksiData->id_jadwal);
                $dataPengampu = Pengampu::find($dataJadwal->id_pengampu);
                $dataMapel = Mapel::find($dataPengampu->id_mapel);
                $nilaisiswaId->nilaikd3 =  $nilaikd3Data;
                $nilaisiswaId->siswa = $siswaData;
                $nilaisiswaId->mapel =      $dataMapel;
                $responseKd3[] = $nilaisiswaId;
            }


            return response()->json([
                'kd3' =>
                $responseKd3
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }


    public function Kd4()
    {
        try {
            $userId = Auth::id();


            // Find the corresponding student record with the provided user ID
            $ortu = OrangTua::where('id_user', $userId)->first();
            $siswa = Siswa::where('id', $ortu->id_siswa)->first();
            $rombelSiswaIds = RombelSiswa::where('id_siswa', $siswa->id)->pluck('id')->toArray();
            $nilaiSiswaKd4 = NilaisiswaKd4::whereIn('id_rombelsiswa', $rombelSiswaIds)->get();



            $responseKd4 = [];
            foreach ($nilaiSiswaKd4 as $nilaisiswaId) {
                $rombelsiswaData = Rombelsiswa::find($nilaisiswaId->id_rombelsiswa);
                $siswaData = Siswa::find($rombelsiswaData->id_siswa);

                $nilaikd4Data = NilaiKd4::find($nilaisiswaId->id_nilaikd4);
                $seksiData = Seksi::find($nilaikd4Data->id_seksi);
                $dataJadwal = Jadwalmapel::find($seksiData->id_jadwal);
                $dataPengampu = Pengampu::find($dataJadwal->id_pengampu);
                $dataMapel = Mapel::find($dataPengampu->id_mapel);
                $nilaisiswaId->nilaikd4 =  $nilaikd4Data;
                $nilaisiswaId->siswa = $siswaData;
                $nilaisiswaId->mapel =      $dataMapel;
                $responseKd4[] = $nilaisiswaId;
            }


            return response()->json([
                'kd4' =>
                $responseKd4
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function tugasKd3()
    {
        try {
            $userId = Auth::id();


            // Find the corresponding student record with the provided user ID
            $ortu = OrangTua::where('id_user', $userId)->first();
            $siswa = Siswa::where('id', $ortu->id_siswa)->first();
            $rombelSiswaIds = RombelSiswa::where('id_siswa', $siswa->id)->pluck('id')->toArray();
            $nilaiSiswaKd3 = NilaisiswaKd3::whereIn('id_rombelsiswa', $rombelSiswaIds)->whereNotNull('tugas')
                ->whereNotNull('materi')->get();



            $responseKd3 = [];
            foreach ($nilaiSiswaKd3 as $nilaisiswaId) {
                $rombelsiswaData = Rombelsiswa::find($nilaisiswaId->id_rombelsiswa);
                $siswaData = Siswa::find($rombelsiswaData->id_siswa);

                $nilaikd3Data = NilaiKd3::find($nilaisiswaId->id_nilaikd3);
                $seksiData = Seksi::find($nilaikd3Data->id_seksi);
                $dataJadwal = Jadwalmapel::find($seksiData->id_jadwal);
                $dataPengampu = Pengampu::find($dataJadwal->id_pengampu);
                $dataMapel = Mapel::find($dataPengampu->id_mapel);
                $nilaisiswaId->nilaikd3 =  $nilaikd3Data;
                $nilaisiswaId->siswa = $siswaData;
                $nilaisiswaId->mapel =      $dataMapel;
                $responseKd3[] = $nilaisiswaId;
            }


            return response()->json([
                'kd3' =>
                $responseKd3
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }


    public function tugasKd4()
    {
        try {
            $userId = Auth::id();


            // Find the corresponding student record with the provided user ID
            $ortu = OrangTua::where('id_user', $userId)->first();
            $siswa = Siswa::where('id', $ortu->id_siswa)->first();
            $rombelSiswaIds = RombelSiswa::where('id_siswa', $siswa->id)->pluck('id')->toArray();
            $nilaiSiswaKd4 = NilaisiswaKd4::whereIn('id_rombelsiswa', $rombelSiswaIds)->whereNotNull('tugas')
                ->whereNotNull('materi')->get();



            $responseKd4 = [];
            foreach ($nilaiSiswaKd4 as $nilaisiswaId) {
                $rombelsiswaData = Rombelsiswa::find($nilaisiswaId->id_rombelsiswa);
                $siswaData = Siswa::find($rombelsiswaData->id_siswa);

                $nilaikd4Data = NilaiKd4::find($nilaisiswaId->id_nilaikd4);
                $seksiData = Seksi::find($nilaikd4Data->id_seksi);
                $dataJadwal = Jadwalmapel::find($seksiData->id_jadwal);
                $dataPengampu = Pengampu::find($dataJadwal->id_pengampu);
                $dataMapel = Mapel::find($dataPengampu->id_mapel);
                $nilaisiswaId->nilaikd4 =  $nilaikd4Data;
                $nilaisiswaId->siswa = $siswaData;
                $nilaisiswaId->mapel =      $dataMapel;
                $responseKd4[] = $nilaisiswaId;
            }


            return response()->json([
                'kd4' =>
                $responseKd4
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}
