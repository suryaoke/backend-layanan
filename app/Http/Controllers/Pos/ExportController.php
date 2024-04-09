<?php

namespace App\Http\Controllers\Pos;

use App\Exports\GuruExport;
use App\Exports\JadwalExport;
use App\Exports\JadwalkepsekExport;
use App\Exports\JadwalmapelExport;
use App\Exports\JadwalsiswaExport;
use App\Exports\MapelExport;
use App\Exports\OrangtuaExport;
use App\Exports\PengampuExport;
use App\Exports\SiswaExport;
use App\Exports\SiswaWalasExport;
use App\Exports\UserExport;
use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Guru;
use App\Models\Hari;
use App\Models\Jadwalmapel;
use App\Models\Mapel;
use App\Models\NilaiKd3;
use App\Models\NilaiKd4;
use App\Models\NilaisiswaKd3;
use App\Models\NilaisiswaKd4;
use App\Models\OrangTua;
use App\Models\Pengampu;
use App\Models\Rombel;
use App\Models\Rombelsiswa;
use App\Models\Seksi;
use App\Models\Siswa;
use App\Models\Tahunajar;
use App\Models\User;
use App\Models\Walas;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ExportController extends Controller
{

    public function Jadwalsiswapdf(request $request)
    {

        $tahunId =  $request->input('tahun');

        $userId = Auth::user()->id;

        $jadwalmapel = Jadwalmapel::join('haris', 'jadwalmapels.id_hari', '=', 'haris.id')
            ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
            ->join('rombels', 'pengampus.kelas', '=', 'rombels.id_kelas')
            ->join('rombelsiswas', 'rombels.id', '=', 'rombelsiswas.id_rombel')
            ->join('siswas', 'rombelsiswas.id_siswa', '=', 'siswas.id')
            ->where('status', '=', '2')
            ->where('siswas.id_user', '=', $userId)
            ->orderBy('id_hari')
            ->orderBy('id_Waktu', 'desc')
            ->where('jadwalmapels.id_tahunajar', $tahunId)

            ->select('jadwalmapels.*')
            ->get();

        $datajadwal = $jadwalmapel->first();

        $tahun = Tahunajar::where('id', $tahunId)->first();

        $hari = Hari::orderby('kode_hari', 'asc')->get();

        $fileName = 'Jadwal Mata Pelajaran MAN 1 Kota Padang Tahun Ajar ' . $tahun->tahun . ' Semester ' . $tahun->semester . '.pdf';

        $pdf = PDF::loadView('backend.data.export.export_pdf_jadwalmapel', ['jadwalmapel' => $jadwalmapel, 'datajadwal' => $datajadwal, 'hari' => $hari]); // Mengirimkan $datajadwal ke tampilan PDF
        return $pdf->download($fileName);
    }



    public function Jadwalortupdf(request $request)
    {
        $tahunId =  $request->input('tahun');
        $userId = Auth::user()->id;

        $ortu = OrangTua::where('id_user', $userId)->first();
        $siswa = Siswa::where('id', $ortu->id_siswa)->first();
        $rombelsiswa = Rombelsiswa::where('id_siswa', $siswa->id)->first();
        $rombel = Rombel::where('id', $rombelsiswa->id_rombel)->first();
        $pengampu = Pengampu::where('kelas', $rombel->id_kelas)->get();

        $pengampuId =   $pengampu->pluck('id')->toArray();


        $jadwalmapel = Jadwalmapel::whereIn('id_pengampu', $pengampuId)
            ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
            ->where('status', '=', '2')
            ->orderBy('id_hari')
            ->orderBy('id_Waktu', 'desc')
            ->where('jadwalmapels.id_tahunajar', $tahunId)
            ->select('jadwalmapels.*')
            ->get();
        $datajadwal = $jadwalmapel->first();


        $tahun = Tahunajar::where('id', $tahunId)->first();

        $fileName = 'Jadwal Mata Pelajaran MAN 1 Kota Padang Tahun Ajar ' . $tahun->tahun . ' Semester ' . $tahun->semester . '.pdf';

        $pdf = PDF::loadView('backend.data.export.export_pdf_jadwalmapel', ['jadwalmapel' => $jadwalmapel, 'datajadwal' => $datajadwal]); // Mengirimkan $datajadwal ke tampilan PDF
        return $pdf->download($fileName);
    }
  
}
