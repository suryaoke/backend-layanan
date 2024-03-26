<?php

namespace App\Http\Controllers\Pos;

use App\Exports\LeggerExport;
use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Rapor;
use App\Models\Rombel;
use App\Models\Rombelsiswa;
use App\Models\Seksi;
use App\Models\Siswa;
use App\Models\Tahunajar;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class RaporController extends Controller
{
    public function RaporSiswa(request $request)
    {

        $searchTahun = $request->input('searchtahun');
        $searchNisn = $request->input('searchnisn');
        $searchNama = $request->input('searchnama');
        $searchJk = $request->input('searchjk');
        $query = Rombelsiswa::query();

        if (!empty($searchTahun)) {
            $query->whereHas('rombels', function ($teachQuery) use ($searchTahun) {
                $teachQuery->whereHas('tahuns', function ($courseQuery) use ($searchTahun) {
                    $courseQuery->where('id', 'LIKE', '%' .   $searchTahun . '%');
                });
            });
        }

        if (!empty($searchNisn)) {
            $query->whereHas('siswas', function ($lecturerQuery) use ($searchNisn) {
                $lecturerQuery->where('nisn', 'LIKE', '%' . $searchNisn . '%');
            });
        }
        if (!empty($searchNama)) {
            $query->whereHas('siswas', function ($lecturerQuery) use ($searchNama) {
                $lecturerQuery->where('nama', 'LIKE', '%' . $searchNama . '%');
            });
        }

        if (!empty($searchJk)) {
            $query->whereHas('siswas', function ($lecturerQuery) use ($searchJk) {
                $lecturerQuery->where('jk', 'LIKE', '%' . $searchJk . '%');
            });
        }
        $tanggalSaatIni = Carbon::now();

        // Mendapatkan semester saat ini berdasarkan bulan
        $semesterSaatIni = ($tanggalSaatIni->month >= 1 && $tanggalSaatIni->month <= 6) ? 'Genap' : 'Ganjil';

        // Mendapatkan tahun saat ini
        $tahunSaatIni = $tanggalSaatIni->format('Y');

        // Mendapatkan data tahun ajar yang sesuai dengan tahun dan semester saat ini
        $tahunAjarSaatIni = Tahunajar::where('tahun', 'like', '%' . $tahunSaatIni . '%')
            ->where('semester', $semesterSaatIni)
            ->first();
        $tahunAjartidakSaatIni = Tahunajar::whereNotIn('tahun', [$tahunSaatIni])
            ->where('semester', $semesterSaatIni)
            ->first();

        if (
            $searchTahun ==  $tahunAjartidakSaatIni->id
        ) {


            $userId = Auth::user()->id;

            $rombelsiswa = $query->join('rombels', 'rombelsiswas.id_rombel', '=', 'rombels.id')
                ->join('walas', 'rombels.id_walas', '=', 'walas.id')
                ->join('gurus', 'walas.id_guru', '=', 'gurus.id')
                ->where('gurus.id_user', '=', $userId)
                ->select('rombelsiswas.*') // Memilih semua kolom dari tabel catata_walas
                ->get();
            $datarombelsiswa =
                $rombelsiswa->first();
        } elseif ($searchTahun) {

            $userId = Auth::user()->id;

            $rombelsiswa = $query->join('rombels', 'rombelsiswas.id_rombel', '=', 'rombels.id')
                ->join('walas', 'rombels.id_walas', '=', 'walas.id')
                ->join('gurus', 'walas.id_guru', '=', 'gurus.id')
                ->where('gurus.id_user', '=', $userId)
                ->select('rombelsiswas.*') // Memilih semua kolom dari tabel catata_walas
                ->get();
            $datarombelsiswa =
                $rombelsiswa->first();
        } else {

            $userId = Auth::user()->id;

            $rombelsiswa = $query->join('rombels', 'rombelsiswas.id_rombel', '=', 'rombels.id')
                ->join('walas', 'rombels.id_walas', '=', 'walas.id')
                ->join('gurus', 'walas.id_guru', '=', 'gurus.id')
                ->where('rombels.id_tahunjar', $tahunAjarSaatIni->id)
                ->where('gurus.id_user', '=', $userId)
                ->select('rombelsiswas.*') // Memilih semua kolom dari tabel catata_walas
                ->get();
            $datarombelsiswa =
                $rombelsiswa->first();
        }

        $datatahun = Tahunajar::whereHas('rombels', function ($query) use ($userId) {
            $query->join('walas', 'rombels.id_walas', '=', 'walas.id')
                ->join('gurus', 'walas.id_guru', '=', 'gurus.id')
                ->where('gurus.id_user', '=', $userId);
        })->orderBy('id', 'desc')
            ->get();

        return view('backend.data.rapor.rapor_siswa', compact('datarombelsiswa', 'datatahun', 'rombelsiswa'));
    }

    public function IdentitasSiswaPdf($id)
    {
        $siswa = Siswa::where('id', $id)->first();

        $fileName = 'Identitas ' . $siswa->nama . ' Nisn ' . $siswa->nisn . '.pdf';

        // Menggunakan kelas PDF dari paket Barryvdh\DomPDF\PDF
        $pdf = PDF::loadView('backend.data.rapor.identitas_pdf', compact('siswa'));

        return $pdf->download($fileName);
    }

    public function SampulSiswaPdf($id)
    {
        $siswa = Siswa::where('id', $id)->first();

        $fileName = 'Sampul Rapor ' . $siswa->nama . ' Nisn ' . $siswa->nisn . '.pdf';

        // Menggunakan kelas PDF dari paket Barryvdh\DomPDF\PDF
        $pdf = PDF::loadView('backend.data.rapor.sampul_pdf', compact('siswa'));

        return $pdf->download($fileName);
    }

    public function LeggerExport(Request $request)
    {
        $tahunId =  $request->input('tahun');
        $userId = Auth::user()->id;

        $seksi = Seksi::join('rombels', 'seksis.id_rombel', '=', 'rombels.id')
            ->join('walas', 'rombels.id_walas', '=', 'walas.id')
            ->join('gurus', 'walas.id_guru', '=', 'gurus.id')
            ->where('rombels.id_tahunjar', $tahunId)
            ->where('gurus.id_user', '=', $userId)
            ->select('seksis.*') // Memilih semua kolom dari tabel catata_walas
            ->get();
        $dataseksi = $seksi->first();
        $rombel = Rombel::where('id', $dataseksi->id_rombel)->first();
        $rombelsiswa = Rombelsiswa::where('id_rombel', $rombel->id)->get();
        $kelas = Kelas::where('id', $rombel->id_kelas)->first();
        $jurusan = Jurusan::where('id', $kelas->id_jurusan)->first();

        $tahun = Tahunajar::where('id', $tahunId)->first();
        $fileName = 'Legger Nilai' . ' ' . $kelas->tingkat .  $kelas->nama . ' ' . $jurusan->nama . ' ' . 'Tahun Ajar' . ' ' . $tahun->tahun . ' ' . 'Semester' . ' ' . $tahun->semester . '.xlsx';


        return Excel::download(new LeggerExport($seksi, $tahun, $rombelsiswa, $dataseksi), $fileName);
    }

    public function LeggerPdf(request $request)
    {
        $tahunId = $request->input('tahun');
        $userId = Auth::user()->id;

        $seksi = Seksi::join('rombels', 'seksis.id_rombel', '=', 'rombels.id')
            ->join('walas', 'rombels.id_walas', '=', 'walas.id')
            ->join('gurus', 'walas.id_guru', '=', 'gurus.id')
            ->where('rombels.id_tahunjar', $tahunId)
            ->where('gurus.id_user', '=', $userId)
            ->select('seksis.*')
            ->get();

        $dataseksi = $seksi->first();
        $rombel = Rombel::where('id', $dataseksi->id_rombel)->first();
        $rombelsiswa = Rombelsiswa::where('id_rombel', $rombel->id)->get();
        $kelas = Kelas::where('id', $rombel->id_kelas)->first();
        $jurusan = Jurusan::where('id', $kelas->id_jurusan)->first();
        $tahun = Tahunajar::where('id', $tahunId)->first();

        $fileName = 'Legger Nilai' . ' ' . $kelas->tingkat .  $kelas->nama . ' ' . $jurusan->nama . ' ' . 'Tahun Ajar' . ' ' . $tahun->tahun . ' ' . 'Semester' . ' ' . $tahun->semester . '.pdf';

        // Mengatur orientasi kertas menjadi landscape
        $pdf = PDF::loadView('backend.data.rapor.legger_pdf', [
            'seksi' => $seksi,
            'tahun' => $tahun,
            'rombelsiswa' => $rombelsiswa,
            'dataseksi' => $dataseksi
        ])->setPaper('a4', 'landscape');

        return $pdf->download($fileName);
    }

    public function NilaiSiswaPdf($id)
    {
        $rombelsiswa = Rombelsiswa::where('id', $id)->first();

        $seksiA = Seksi::join('rombels', 'seksis.id_rombel', '=', 'rombels.id')
            ->join('rombelsiswas', 'rombels.id', '=', 'rombelsiswas.id_rombel')
            ->join('jadwalmapels', 'seksis.id_jadwal', '=', 'jadwalmapels.id')
            ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
            ->join('mapels', 'pengampus.id_mapel', '=', 'mapels.id')
            ->where('mapels.jenis', 'A')
            ->orderby('mapels.nama')
            ->where('rombelsiswas.id', $id)
            ->select('seksis.*') // 
            ->get();

        $seksiB = Seksi::join('rombels', 'seksis.id_rombel', '=', 'rombels.id')
            ->join('rombelsiswas', 'rombels.id', '=', 'rombelsiswas.id_rombel')
            ->join('jadwalmapels', 'seksis.id_jadwal', '=', 'jadwalmapels.id')
            ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
            ->join('mapels', 'pengampus.id_mapel', '=', 'mapels.id')
            ->where('mapels.jenis', 'B')
            ->orderby('mapels.nama')
            ->where('rombelsiswas.id', $id)
            ->select('seksis.*') // 
            ->get();

        $seksiC = Seksi::join('rombels', 'seksis.id_rombel', '=', 'rombels.id')
            ->join('rombelsiswas', 'rombels.id', '=', 'rombelsiswas.id_rombel')
            ->join('jadwalmapels', 'seksis.id_jadwal', '=', 'jadwalmapels.id')
            ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
            ->join('mapels', 'pengampus.id_mapel', '=', 'mapels.id')
            ->where('mapels.jenis', 'C')
            ->orderby('mapels.nama')
            ->where('rombelsiswas.id', $id)
            ->select('seksis.*') // 
            ->get();

        $seksiall = Seksi::join('rombels', 'seksis.id_rombel', '=', 'rombels.id')
            ->join('rombelsiswas', 'rombels.id', '=', 'rombelsiswas.id_rombel')
            ->where('rombelsiswas.id', $id)
            ->select('seksis.*') // 
            ->get();

        $fileName = 'Nilai Siswa ' . $rombelsiswa->siswas->nama . ' Nisn ' . $rombelsiswa->siswas->nisn . '.pdf';


        $pdf = PDF::loadView('backend.data.rapor.nilai_pdf', compact('seksiall', 'rombelsiswa', 'seksiA', 'seksiB', 'seksiC', 'id'));

        return $pdf->download($fileName);
    }

    public function RaporSiswaPdf($id)
    {
        $rombelsiswa = Rombelsiswa::where('id', $id)->first();

        $seksiA = Seksi::join('rombels', 'seksis.id_rombel', '=', 'rombels.id')
            ->join('rombelsiswas', 'rombels.id', '=', 'rombelsiswas.id_rombel')
            ->join('jadwalmapels', 'seksis.id_jadwal', '=', 'jadwalmapels.id')
            ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
            ->join('mapels', 'pengampus.id_mapel', '=', 'mapels.id')
            ->where('mapels.jenis', 'A')
            ->orderby('mapels.nama')
            ->where('rombelsiswas.id', $id)
            ->select('seksis.*') // 
            ->get();

        $seksiB = Seksi::join('rombels', 'seksis.id_rombel', '=', 'rombels.id')
            ->join('rombelsiswas', 'rombels.id', '=', 'rombelsiswas.id_rombel')
            ->join('jadwalmapels', 'seksis.id_jadwal', '=', 'jadwalmapels.id')
            ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
            ->join('mapels', 'pengampus.id_mapel', '=', 'mapels.id')
            ->where('mapels.jenis', 'B')
            ->orderby('mapels.nama')
            ->where('rombelsiswas.id', $id)
            ->select('seksis.*') // 
            ->get();

        $seksiC = Seksi::join('rombels', 'seksis.id_rombel', '=', 'rombels.id')
            ->join('rombelsiswas', 'rombels.id', '=', 'rombelsiswas.id_rombel')
            ->join('jadwalmapels', 'seksis.id_jadwal', '=', 'jadwalmapels.id')
            ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
            ->join('mapels', 'pengampus.id_mapel', '=', 'mapels.id')
            ->where('mapels.jenis', 'C')
            ->orderby('mapels.nama')
            ->where('rombelsiswas.id', $id)
            ->select('seksis.*') // 
            ->get();

        $seksiall = Seksi::join('rombels', 'seksis.id_rombel', '=', 'rombels.id')
            ->join('rombelsiswas', 'rombels.id', '=', 'rombelsiswas.id_rombel')
            ->where('rombelsiswas.id', $id)
            ->select('seksis.*') // 
            ->get();

        $fileName = 'Rapor Siswa ' . $rombelsiswa->siswas->nama . ' Nisn ' . $rombelsiswa->siswas->nisn . '.pdf';


        $pdf = PDF::loadView('backend.data.rapor.rapor_pdf', compact('seksiall', 'rombelsiswa', 'seksiA', 'seksiB', 'seksiC', 'id'));

        return $pdf->download($fileName);
    }

    public function NaikKelas($id)
    {

        Rapor::where('id_rombelsiswa', $id)

            ->update(['naik_kelas' => 1]);

        $notification = array(
            'message' => 'Siswa Naik Kelas',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function TinggalKelas($id)
    {

        Rapor::where('id_rombelsiswa', $id)

            ->update(['naik_kelas' => 0]);

        $notification = array(
            'message' => 'Siswa Tinggal Kelas',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }


    public function RaporDataSiswa(request $request)
    {

        $searchTahun = $request->input('searchtahun');
        $query = Rombelsiswa::query();

        if (!empty($searchTahun)) {
            $query->whereHas('rombels', function ($teachQuery) use ($searchTahun) {
                $teachQuery->whereHas('tahuns', function ($courseQuery) use ($searchTahun) {
                    $courseQuery->where('id', 'LIKE', '%' .   $searchTahun . '%');
                });
            });
        }

        $tanggalSaatIni = Carbon::now();

        // Mendapatkan semester saat ini berdasarkan bulan
        $semesterSaatIni = ($tanggalSaatIni->month >= 1 && $tanggalSaatIni->month <= 6) ? 'Genap' : 'Ganjil';

        // Mendapatkan tahun saat ini
        $tahunSaatIni = $tanggalSaatIni->format('Y');

        // Mendapatkan data tahun ajar yang sesuai dengan tahun dan semester saat ini
        $tahunAjarSaatIni = Tahunajar::where('tahun', 'like', '%' . $tahunSaatIni . '%')
            ->where('semester', $semesterSaatIni)
            ->first();
        $tahunAjartidakSaatIni = Tahunajar::whereNotIn('tahun', [$tahunSaatIni])
            ->where('semester', $semesterSaatIni)
            ->first();

        if (
            $searchTahun ==  $tahunAjartidakSaatIni->id
        ) {


            $userId = Auth::user()->id;

            $rombelsiswa = $query
                ->join('siswas', 'siswas.id', '=', 'rombelsiswas.id_siswa')
                ->where('siswas.id_user', '=', $userId)
                ->select('rombelsiswas.*') // Memilih semua kolom dari tabel catata_walas
                ->get();
            $datarombelsiswa =
                $rombelsiswa->first();
        } elseif ($searchTahun) {

            $userId = Auth::user()->id;

            $rombelsiswa = $query->join('siswas', 'siswas.id', '=', 'rombelsiswas.id_siswa')
                ->where('siswas.id_user', '=', $userId)
                ->select('rombelsiswas.*') // Memilih semua kolom dari tabel catata_walas
                ->get();
            $datarombelsiswa =
                $rombelsiswa->first();
        } else {

            $userId = Auth::user()->id;

            $rombelsiswa = $query->join('rombels', 'rombelsiswas.id_rombel', '=', 'rombels.id')
                ->join('siswas', 'siswas.id', '=', 'rombelsiswas.id_siswa')
                ->where('siswas.id_user', '=', $userId)
                ->where('rombels.id_tahunjar', $tahunAjarSaatIni->id)

                ->select('rombelsiswas.*') // Memilih semua kolom dari tabel catata_walas
                ->get();
            $datarombelsiswa =
                $rombelsiswa->first();
        }

        $datatahun = Tahunajar::whereHas('rombels', function ($query) use ($userId) {
            $query->join('rombelsiswas', 'rombels.id', '=', 'rombelsiswas.id_rombel')
                ->join('siswas', 'rombelsiswas.id_siswa', '=', 'siswas.id')
                ->where('siswas.id_user', '=', $userId);
        })->orderBy('id', 'desc')
            ->get();

        return view('backend.data.rapor.rapor_siswa', compact('datarombelsiswa', 'datatahun', 'rombelsiswa'));
    }

    public function RaporDataSiswaOrangtua(request $request)
    {

        $searchTahun = $request->input('searchtahun');
        $query = Rombelsiswa::query();

        if (!empty($searchTahun)) {
            $query->whereHas('rombels', function ($teachQuery) use ($searchTahun) {
                $teachQuery->whereHas('tahuns', function ($courseQuery) use ($searchTahun) {
                    $courseQuery->where('id', 'LIKE', '%' .   $searchTahun . '%');
                });
            });
        }

        $tanggalSaatIni = Carbon::now();

        // Mendapatkan semester saat ini berdasarkan bulan
        $semesterSaatIni = ($tanggalSaatIni->month >= 1 && $tanggalSaatIni->month <= 6) ? 'Genap' : 'Ganjil';

        // Mendapatkan tahun saat ini
        $tahunSaatIni = $tanggalSaatIni->format('Y');

        // Mendapatkan data tahun ajar yang sesuai dengan tahun dan semester saat ini
        $tahunAjarSaatIni = Tahunajar::where('tahun', 'like', '%' . $tahunSaatIni . '%')
            ->where('semester', $semesterSaatIni)
            ->first();
        $tahunAjartidakSaatIni = Tahunajar::whereNotIn('tahun', [$tahunSaatIni])
            ->where('semester', $semesterSaatIni)
            ->first();

        if (
            $searchTahun ==  $tahunAjartidakSaatIni->id
        ) {


            $userId = Auth::user()->id;

            $rombelsiswa = $query
                ->join('siswas', 'siswas.id', '=', 'rombelsiswas.id_siswa')
                ->join('orang_tuas', 'siswas.id', '=', 'orang_tuas.id_siswa')
                ->where('orang_tuas.id_user', '=', $userId)
                ->select('rombelsiswas.*') // Memilih semua kolom dari tabel catata_walas
                ->get();
            $datarombelsiswa =
                $rombelsiswa->first();
        } elseif ($searchTahun) {

            $userId = Auth::user()->id;

            $rombelsiswa = $query
                ->join('siswas', 'siswas.id', '=', 'rombelsiswas.id_siswa')
                ->join('orang_tuas', 'siswas.id', '=', 'orang_tuas.id_siswa')
                ->where('orang_tuas.id_user', '=', $userId)
                ->select('rombelsiswas.*') // Memilih semua kolom dari tabel catata_walas
                ->get();
            $datarombelsiswa =
                $rombelsiswa->first();
        } else {

            $userId = Auth::user()->id;

            $rombelsiswa = $query->join('rombels', 'rombelsiswas.id_rombel', '=', 'rombels.id')
                ->join('siswas', 'siswas.id', '=', 'rombelsiswas.id_siswa')
                ->join('orang_tuas', 'siswas.id', '=', 'orang_tuas.id_siswa')
                ->where('orang_tuas.id_user', '=', $userId)
                ->where('rombels.id_tahunjar', $tahunAjarSaatIni->id)

                ->select('rombelsiswas.*') // Memilih semua kolom dari tabel catata_walas
                ->get();
            $datarombelsiswa =
                $rombelsiswa->first();
        }

        $datatahun = Tahunajar::whereHas('rombels', function ($query) use ($userId) {
            $query->join('rombelsiswas', 'rombels.id', '=', 'rombelsiswas.id_rombel')
                ->join('siswas', 'rombelsiswas.id_siswa', '=', 'siswas.id')
                ->join('orang_tuas', 'siswas.id', '=', 'orang_tuas.id_siswa')
                ->where('orang_tuas.id_user', '=', $userId);
        })->orderBy('id', 'desc')
            ->get();

        return view('backend.data.rapor.rapor_siswa', compact('datarombelsiswa', 'datatahun', 'rombelsiswa'));
    }
}
