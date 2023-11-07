<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\OrangTua;
use App\Models\Rombel;
use App\Models\Rombelsiswa;
use App\Models\Siswa;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    public function siswaAll(Request $request)
    {
        try {
            // TODO: Validate request, ensuring that the user is authenticated
            // Get the authenticated user's ID
            $userId = Auth::id();

            // Find the corresponding student record with the provided user ID
            $ortu = OrangTua::where('id_user', $userId)->first();
            $siswa = Siswa::where('id', $ortu->id_siswa)->first();
            $rombelsiswa = Rombelsiswa::where('id_siswa', $siswa->id)->first();
            $siswa = Siswa::where('id', $rombelsiswa->id_siswa)->get();

            $responseSiswa = [];
            foreach ($siswa as  $siswaId) {
                $rombelsiswaData = Rombelsiswa::where('id_siswa', $siswaId->id)->first();
                $rombelData = Rombel::find($rombelsiswaData->id_rombel);
                $kelasData = Kelas::find($rombelData->id_kelas);
                $jurusanData = Jurusan::find($kelasData->id_jurusan);


                $siswaId->kelas = $kelasData;
                $siswaId->jurusan =       $jurusanData;

                $responseSiswa[] = $siswaId;
            }

            return response()->json([
                'siswa' => $responseSiswa,

            ], 200);
        } catch (Exception $error) {
            // Catch any exceptions that might occur and return a general error message
            return ResponseFormatter::error('Failed to retrieve student data');
        }
    }
}
