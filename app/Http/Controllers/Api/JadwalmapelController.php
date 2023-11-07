<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Hari;
use App\Models\Jadwalmapel;
use App\Models\Mapel;
use App\Models\OrangTua;
use App\Models\Pengampu;
use App\Models\Rombel;
use App\Models\Rombelsiswa;
use App\Models\Siswa;
use App\Models\Waktu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalmapelController extends Controller
{
    public function jadwalMapel(Request $request)
    {
        try {
            $userId = Auth::id();

            $userId = Auth::id();

            // Find the corresponding student record with the provided user ID
            $ortu = OrangTua::where('id_user', $userId)->first();
            $siswa = Siswa::where('id', $ortu->id_siswa)->first();
            $rombelsiswa = Rombelsiswa::where('id_siswa', $siswa->id)->first();
            $rombel = Rombel::where('id', $rombelsiswa->id_rombel)->first();
            $pengampu = Pengampu::where('kelas', $rombel->id_kelas)->get();

            $pengampuId =   $pengampu->pluck('id')->toArray();
            $jadwalmapel = Jadwalmapel::whereIn('id_pengampu', $pengampuId)
                ->orderby('id', 'desc')->get();

            $responseJadwal = [];
            foreach ($jadwalmapel as $jadwalmapelId) {
                $pengampuData = Pengampu::find($jadwalmapelId->id_pengampu);
                $mapelData = Mapel::find($pengampuData->id_mapel);

                $waktuData = Waktu::find($jadwalmapelId->id_waktu);
                $hariData = Hari::find($jadwalmapelId->id_hari);
                $guruData = Guru::find($pengampuData->id_guru);
                $jadwalmapelId->mapel = $mapelData;
                $jadwalmapelId->waktu =   $waktuData;
                $jadwalmapelId->hari =    $hariData;
                $jadwalmapelId->guru =       $guruData;
                $responseJadwal[] = $jadwalmapelId;
            }


            return response()->json([
                'jadwal' =>
                $responseJadwal
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}
