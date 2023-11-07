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
            $siswa = Siswa::where('id', $ortu->id_siswa)->get();
            $siswaId = Siswa::where('id', $ortu->id_siswa)->first();
            $rombelsiswa = Rombelsiswa::where('id_siswa', $siswaId->id)->first();
            $rombel = Rombel::where('id', $rombelsiswa->id_rombel)->first();
            $kelasId = Kelas::where('id', $rombel->id_kelas)->first();
            $kelas = Kelas::where('id', $rombel->id_kelas)->get();
            $jurusan = Jurusan::where('id', $kelasId->id_jurusan)->get();
            $siswa = Siswa::where('id', $ortu->id_siswa)->get();

            if ($siswa) {
                // If the student record exists, return it as a success response

                return response()->json([
                    'siswa' => $siswa,
                    'kelas' => $kelas,
                    'jurusan' => $jurusan,
                ], 200);
            } else {
                // If the student record does not exist, return an appropriate error response
                return ResponseFormatter::error('Student data not found', 404);
            }
        } catch (Exception $error) {
            // Catch any exceptions that might occur and return a general error message
            return ResponseFormatter::error('Failed to retrieve student data');
        }
    }
}
