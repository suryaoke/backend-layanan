<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Jadwalmapel;
use App\Models\Mapel;
use App\Models\OrangTua;
use App\Models\Pengampu;
use App\Models\Siswa;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiController extends Controller
{
    public function absensiSiswa(Request $request)
    {
        try {
            $userId = Auth::id();

            $ortu = OrangTua::where('id_user', $userId)->first();
            $siswa = Siswa::find($ortu->id_siswa);
            $absensi = Absensi::where('id_siswa', $siswa->id)->orderByRaw("STR_TO_DATE(tanggal, '%d/%m/%Y') DESC")->limit(7)->get();

            $responseAbsensi = [];
            foreach ($absensi as $absen) {
                $dataSiswa = Siswa::find($absen->id_siswa);
                $dataJadwal = Jadwalmapel::find($absen->id_jadwal);
                $dataPengampu = Pengampu::find($dataJadwal->id_pengampu);
                $dataMapel = Mapel::find($dataPengampu->id_mapel);
                $absen->siswa = $dataSiswa;
                $absen->mapel = $dataMapel;
                $responseAbsensi[] = $absen;
            }

            return response()->json([
                'absensi' => $responseAbsensi
            ], 200);
        } catch (Exception $e) {
            return ResponseFormatter::error($e->getMessage(), 500);
        }
    }

    public function absensiDataSiswa(Request $request)
    {
        try {
            $userId = Auth::id();

            $ortu = OrangTua::where('id_user', $userId)->first();

            if ($ortu) {
                $siswa = Siswa::find($ortu->id_siswa);

                if ($siswa) {
                    $absensi = Absensi::where('id_siswa', $siswa->id)->limit(1)->get();

                    if ($absensi->isNotEmpty()) {
                        $absen = $absensi->first();
                        $dataAlfa = Absensi::where('id_siswa', $siswa->id)->where('status', '0')->count();
                        $dataIzin = Absensi::where('id_siswa', $siswa->id)->where('status', '2')->count();
                        $dataSakit = Absensi::where('id_siswa', $siswa->id)->where('status', '3')->count();
                        $dataSiswa = Siswa::where('id', $absen->id_siswa)->first();
                        $absen->alfa = $dataAlfa;
                        $absen->izin = $dataIzin;
                        $absen->sakit = $dataSakit;
                        $absen->siswa  = $dataSiswa;
                        return response()->json([
                            'absensi' => $absen
                        ], 200);
                    } else {
                        return response()->json(['error' => 'Data absensi tidak ditemukan'], 404);
                    }
                }
            }

            return response()->json(['error' => 'Siswa tidak ditemukan'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}
