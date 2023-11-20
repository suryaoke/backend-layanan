<?php

namespace App\Http\Controllers\Pos;

use App\Exports\GuruExport;
use App\Exports\JadwalExport;
use App\Exports\JadwalkepsekExport;
use App\Exports\JadwalmapelExport;
use App\Exports\JadwalsiswaExport;
use App\Exports\OrangtuaExport;
use App\Exports\SiswaExport;
use App\Exports\SiswaWalasExport;
use App\Exports\UserExport;
use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Guru;
use App\Models\Jadwalmapel;
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
use App\Models\User;
use App\Models\Walas;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class ExportController extends Controller
{
    public function Userpdf()
    {
        $user = User::orderby('role')->get();

        $pdf = PDF::loadView('backend.data.export.export_pdf_user', ['user' => $user]); // Pastikan Anda mengirimkan data dalam bentuk array assosiatif
        return $pdf->download('user.pdf');
    }

    public function Userexcel()
    {
        $user = User::orderby('role')->get();

        $export = new UserExport($user);
        return Excel::download($export, 'user.xlsx');
    }

    public function Gurupdf()
    {
        $guru = Guru::orderby('nama')->get();

        $pdf = PDF::loadView('backend.data.export.export_pdf_guru', ['guru' => $guru]); // Pastikan Anda mengirimkan data dalam bentuk array assosiatif
        return $pdf->download('guru.pdf');
    }

    public function Guruexcel()
    {
        $guru = Guru::orderby('nama')->get();



        $export = new GuruExport($guru);
        return Excel::download($export, 'guru.xlsx');
    }

    public function Orangtuapdf()
    {
        $orangtua = OrangTua::orderby('nama')->get();

        $pdf = PDF::loadView('backend.data.export.export_pdf_orangtua', ['orangtua' => $orangtua]); // Pastikan Anda mengirimkan data dalam bentuk array assosiatif
        return $pdf->download('orangtua.pdf');
    }

    public function Orangtuaexcel()
    {
        $orangtua = Orangtua::orderby('nama')->get();

        $export = new OrangtuaExport($orangtua);
        return Excel::download($export, 'orangtua.xlsx');
    }

    public function Siswapdf()
    {
        $siswa = Siswa::orderby('nama')->get();

        $pdf = PDF::loadView('backend.data.export.export_pdf_siswa', ['siswa' => $siswa]); // Pastikan Anda mengirimkan data dalam bentuk array assosiatif
        return $pdf->download('siswa.pdf');
    }

    public function Siswaexcel()
    {
        $siswa = Siswa::orderby('nama')->get();

        $export = new SiswaExport($siswa);
        return Excel::download($export, 'siswa.xlsx');
    }


    public function Siswawalaspdf()
    {
        $userId = Auth::user()->id;

        // Ambil ID guru berdasarkan ID user yang aktif
        $guruId = Guru::where('id_user', $userId)->value('id');

        $walas = Walas::where('id_guru', $guruId)->first();
        $siswa = null; // inisialisasi variabel $siswa

        if ($walas) {
            $rombe = Rombel::where('id_walas', $walas->id)->first();
            if ($rombe) {
                $rombelsiswa = Rombelsiswa::where('id_rombel', $rombe->id)->get();
                if ($rombelsiswa) {
                    $siswaIds = $rombelsiswa->pluck('id_siswa')->toArray();
                    $siswa = Siswa::whereIn('id', $siswaIds)->get();
                }
            }
        }


        $pdf = PDF::loadView('backend.data.export.export_pdf_siswawalas', ['siswa' => $siswa]); // Pastikan Anda mengirimkan data dalam bentuk array assosiatif
        return $pdf->download('siswa.pdf');
    }

    public function Siswawalasexcel()
    {
        $userId = Auth::user()->id;

        // Ambil ID guru berdasarkan ID user yang aktif
        $guruId = Guru::where('id_user', $userId)->value('id');

        $walas = Walas::where('id_guru', $guruId)->first();
        $siswa = null; // inisialisasi variabel $siswa

        if ($walas) {
            $rombe = Rombel::where('id_walas', $walas->id)->first();
            if ($rombe) {
                $rombelsiswa = Rombelsiswa::where('id_rombel', $rombe->id)->get();
                if ($rombelsiswa) {
                    $siswaIds = $rombelsiswa->pluck('id_siswa')->toArray();
                    $siswa = Siswa::whereIn('id', $siswaIds)->get();
                }
            }
        }


        $export = new SiswaWalasExport($siswa);
        return Excel::download($export, 'siswa.xlsx');
    }


    public function Jadwalkepsekpdf()
    {

        $jadwalmapel = Jadwalmapel::join('haris', 'jadwalmapels.id_hari', '=', 'haris.id')
            ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
            ->join('kelas', 'pengampus.kelas', '=', 'kelas.id')
            ->where('status', '>=', 1)
            ->where('status', '<=', 3)
            ->orderBy('kelas.tingkat', 'asc')
            ->orderBy('kelas.nama', 'asc')
            ->orderBy('haris.kode_hari', 'asc')
            ->get();

        $pdf = PDF::loadView('backend.data.export.export_pdf_jadwalkepsek', ['jadwalmapel' => $jadwalmapel]); // Pastikan Anda mengirimkan data dalam bentuk array assosiatif
        return $pdf->download('jadwal.pdf');
    }



    public function JadwalkepsekpdfCustom(Request $request)
    {
        $kelas =  $request->input('kelas');
        $semester =  $request->input('semester');

        $jadwalmapel = Jadwalmapel::join('haris', 'jadwalmapels.id_hari', '=', 'haris.id')
            ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
            ->join('kelas', 'pengampus.kelas',    '=',    'kelas.id')
            ->join('mapels', 'pengampus.id_mapel', '=', 'mapels.id')
            ->where('status', '>=', 1)
            ->where('status', '<=', 3)
            ->orderBy('kelas.tingkat', 'asc')
            ->orderBy('kelas.nama', 'asc')
            ->orderBy('haris.kode_hari', 'asc')
            ->where('pengampus.kelas', $kelas)
            ->where('mapels.semester', $semester)
            ->get();

        $pdf = PDF::loadView('backend.data.export.export_pdf_jadwal', ['jadwalmapel' => $jadwalmapel]); // Pastikan Anda mengirimkan data dalam bentuk array assosiatif
        return $pdf->download('jadwal.pdf');
    }



    public function Jadwalkepsekexcel()
    {
        $jadwalmapel = Jadwalmapel::join('haris', 'jadwalmapels.id_hari', '=', 'haris.id')
            ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
            ->join('kelas', 'pengampus.kelas', '=', 'kelas.id')
            ->where('status', '>=', 1)
            ->where('status', '<=', 3)
            ->orderBy('kelas.tingkat', 'asc')
            ->orderBy('kelas.nama', 'asc')
            ->orderBy('haris.kode_hari', 'asc')
            ->get();

        $export = new JadwalkepsekExport($jadwalmapel);
        return Excel::download($export, 'jadwal.xlsx');
    }

    public function Jadwalpdf()
    {

        $jadwalmapel = Jadwalmapel::join('haris', 'jadwalmapels.id_hari', '=', 'haris.id')
            ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
            ->join('kelas', 'pengampus.kelas',    '=',    'kelas.id')
            ->orderBy('kelas.tingkat', 'asc')
            ->orderBy('kelas.nama', 'asc')
            ->orderBy('haris.kode_hari', 'asc')
            ->get();

        $pdf = PDF::loadView('backend.data.export.export_pdf_jadwal', ['jadwalmapel' => $jadwalmapel]); // Pastikan Anda mengirimkan data dalam bentuk array assosiatif
        return $pdf->download('jadwal.pdf');
    }



    public function JadwalpdfCustom(Request $request)
    {
        $kelas =  $request->input('kelas');
        $semester =  $request->input('semester');

        $jadwalmapel = Jadwalmapel::join('haris', 'jadwalmapels.id_hari', '=', 'haris.id')
            ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
            ->join('kelas', 'pengampus.kelas',    '=',    'kelas.id')
            ->join('mapels', 'pengampus.id_mapel', '=', 'mapels.id')
            ->orderBy('kelas.tingkat', 'asc')
            ->orderBy('kelas.nama', 'asc')
            ->orderBy('haris.kode_hari', 'asc')
            ->where('pengampus.kelas', $kelas)
            ->where('mapels.semester', $semester)
            ->get();

        $pdf = PDF::loadView('backend.data.export.export_pdf_jadwal', ['jadwalmapel' => $jadwalmapel]); // Pastikan Anda mengirimkan data dalam bentuk array assosiatif
        return $pdf->download('jadwal.pdf');
    }




    public function Jadwalexcel()
    {
        $jadwalmapel = Jadwalmapel::join('haris', 'jadwalmapels.id_hari', '=', 'haris.id')
            ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
            ->join('kelas', 'pengampus.kelas',    '=',    'kelas.id')
            ->orderBy('kelas.tingkat', 'asc')
            ->orderBy('kelas.nama', 'asc')
            ->orderBy('haris.kode_hari', 'asc')
            ->get();

        $export = new JadwalExport($jadwalmapel);
        return Excel::download($export, 'jadwal.xlsx');
    }


    public function Jadwalmapelpdf()
    {
        $userId = Auth::user()->id;
        $jadwalmapel = Jadwalmapel::join('haris', 'jadwalmapels.id_hari', '=', 'haris.id')
            ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
            ->join('kelas', 'pengampus.kelas', '=', 'kelas.id')
            ->join('gurus', 'pengampus.id_guru', '=', 'gurus.id')
            ->where('status', '=', '2')
            ->where('gurus.id_user', '=', $userId)
            ->orderBy('kelas.tingkat', 'asc')
            ->orderBy('kelas.nama', 'asc')
            ->orderBy('haris.kode_hari', 'asc')
            ->get();


        $pdf = PDF::loadView('backend.data.export.export_pdf_jadwalmapel', ['jadwalmapel' => $jadwalmapel]); // Pastikan Anda mengirimkan data dalam bentuk array assosiatif
        return $pdf->download('jadwal.pdf');
    }

    public function Jadwalmapelexcel()
    {
        $userId = Auth::user()->id;
        $jadwalmapel = Jadwalmapel::join('haris', 'jadwalmapels.id_hari', '=', 'haris.id')
            ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
            ->join('kelas', 'pengampus.kelas', '=', 'kelas.id')
            ->join('gurus', 'pengampus.id_guru', '=', 'gurus.id')
            ->where('status', '=', '2')
            ->where('gurus.id_user', '=', $userId)
            ->orderBy('kelas.tingkat', 'asc')
            ->orderBy('kelas.nama', 'asc')
            ->orderBy('haris.kode_hari', 'asc')
            ->get();


        $export = new JadwalmapelExport($jadwalmapel);
        return Excel::download($export, 'jadwal.xlsx');
    }


    public function Nilaipdf()
    {
        $nilaiSiswaKd3 = NilaisiswaKd3::orderby('id')->get();
        $nilaiSiswaKd4 = NilaisiswaKd4::orderby('id')->get();


        $pdf = PDF::loadView('backend.data.export.export_pdf_nilaisiswa', compact('nilaiSiswaKd3', 'nilaiSiswaKd4'));

        return $pdf->download('nilaisiswa.pdf');
    }


    public function Nilaimapelpdf()
    {

        $userId = Auth::user()->id;
        $guru = Guru::where('id_user', $userId)->first();

        if ($guru) {
            $pengampu = Pengampu::where('id_guru', $guru->id)->pluck('id')->toArray();

            $jadwal = Jadwalmapel::whereIn('id_pengampu', $pengampu)->pluck('id')->toArray();

            $seksi = Seksi::whereIn('id_jadwal', $jadwal)->pluck('id')->toArray();

            $nilaikd3 = NilaiKd3::whereIn('id_seksi', $seksi)->get();
            $idNilaikad3 = $nilaikd3->pluck('id')->toArray();
            $nilaiSiswaKd3 = NilaisiswaKd3::whereIn('id_nilaikd3', $idNilaikad3)->get();

            $nilaikd4 = NilaiKd4::whereIn('id_seksi', $seksi)->get();
            $idNilaikad4 = $nilaikd4->pluck('id')->toArray();
            $nilaiSiswaKd4 = NilaisiswaKd4::whereIn('id_nilaikd4', $idNilaikad4)->get();
        }


        $pdf = PDF::loadView('backend.data.export.export_pdf_nilaisiswamapel', compact('nilaiSiswaKd3', 'nilaiSiswaKd4'));

        return $pdf->download('nilaisiswa.pdf');
    }


    public function Nilaiwalaspdf()
    {

        $userId = Auth::user()->id;
        $guru = Guru::where('id_user', $userId)->first();
        $walas = $guru ? Walas::where('id_guru', $guru->id)->first() : null;

        if ($walas) {
            $rombel = Rombel::where('id_walas', $walas->id)->first();
            if ($rombel) {
                $rombelSiswaIds = Rombelsiswa::where('id_rombel', $rombel->id)->pluck('id')->toArray();
                if ($rombelSiswaIds) {
                    $rombelSiswa = RombelSiswa::whereIn('id', $rombelSiswaIds)->get();
                    if ($rombelSiswa) {
                        $nilaiSiswaKd3 = NilaisiswaKd3::whereIn('id_rombelsiswa', $rombelSiswaIds)->get();
                        $nilaiSiswaKd4 = NilaisiswaKd4::whereIn('id_rombelsiswa', $rombelSiswaIds)->get();
                    }
                }
            }
        }

        $pdf = PDF::loadView('backend.data.export.export_pdf_nilaisiswawalas', compact('nilaiSiswaKd3', 'nilaiSiswaKd4'));

        return $pdf->download('nilaisiswa.pdf');
    }

    public function Absensiallpdf()
    {

        $userId = Auth::user()->id;
        $absensi = Absensi::join('jadwalmapels', 'absensis.id_jadwal', '=', 'jadwalmapels.id')
            ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
            ->join('gurus', 'pengampus.id_guru', '=', 'gurus.id')
            ->join('users', 'gurus.id_user', '=', 'users.id')
            ->where('users.id', $userId)
            ->select('absensis.*')
            ->orderby('id', 'desc')
            ->orderByRaw("STR_TO_DATE(tanggal, '%d/%m/%Y') DESC")
            ->get();


        $pdf = PDF::loadView('backend.data.export.export_pdf_absensiall', compact('absensi'));

        return $pdf->download('absensisiswa.pdf');
    }

    public function Absensidataallpdf()
    {

        $userId = Auth::user()->id;
        $absensi = Absensi::orderby('id', 'desc')
            ->orderByRaw("STR_TO_DATE(tanggal, '%d/%m/%Y') DESC")
            ->get();


        $pdf = PDF::loadView('backend.data.export.export_pdf_absensidataall', compact('absensi'));

        return $pdf->download('absensisiswa.pdf');
    }

    public function Absensiguruwalaspdf()
    {

        $userId = Auth::user()->id;

        $guru = Guru::where('id_user', $userId)->first();
        $walas = $guru ? Walas::where('id_guru', $guru->id)->first() : null;
        $siswa = null; // inisialisasi variabel $siswa
        $absensi = null; // inisialisasi variabel $absensi

        if ($walas) {
            $rombel = Rombel::where('id_walas', $walas->id)->first();
            if ($rombel) {
                $rombelSiswa = RombelSiswa::where('id_rombel', $rombel->id)->get();
                if ($rombelSiswa) {
                    $siswaIds = $rombelSiswa->pluck('id_siswa')->unique()->toArray();
                    $siswa = Siswa::whereIn('id', $siswaIds)->get();
                    if ($siswa) {
                        $absensi = Absensi::whereIn('id_siswa', $siswaIds)->orderby('id', 'desc')->get();
                    }
                }
            }
        }


        $pdf = PDF::loadView('backend.data.export.export_pdf_absensiguruwalas', compact('absensi'));

        return $pdf->download('absensisiswa.pdf');
    }


    public function Jadwalsiswapdf()
    {
        $userId = Auth::user()->id;

        $jadwalmapel = Jadwalmapel::join('haris', 'jadwalmapels.id_hari', '=', 'haris.id')
            ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
            ->join('kelas', 'pengampus.kelas', '=', 'kelas.id')
            ->join('rombels', 'pengampus.kelas', '=', 'rombels.id_kelas')
            ->join('rombelsiswas', 'rombels.id', '=', 'rombelsiswas.id_rombel')
            ->join('siswas', 'rombelsiswas.id_siswa', '=', 'siswas.id')
            ->where('status', '=', '2')
            ->where('siswas.id_user', '=', $userId)
            ->orderBy('kelas.tingkat', 'asc')
            ->orderBy('kelas.nama', 'asc')
            ->orderBy('haris.kode_hari', 'asc')
            ->get();



        $pdf = PDF::loadView('backend.data.export.export_pdf_jadwalmapel', ['jadwalmapel' => $jadwalmapel]); // Pastikan Anda mengirimkan data dalam bentuk array assosiatif
        return $pdf->download('jadwal.pdf');
    }

    public function Jadwalsiswaexcel()
    {
        $userId = Auth::user()->id;

        $jadwalmapel = Jadwalmapel::join('haris', 'jadwalmapels.id_hari', '=', 'haris.id')
            ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
            ->join('kelas', 'pengampus.kelas', '=', 'kelas.id')
            ->join('rombels', 'pengampus.kelas', '=', 'rombels.id_kelas')
            ->join('rombelsiswas', 'rombels.id', '=', 'rombelsiswas.id_rombel')
            ->join('siswas', 'rombelsiswas.id_siswa', '=', 'siswas.id')
            ->where('status', '=', '2')
            ->where('siswas.id_user', '=', $userId)
            ->orderBy('kelas.tingkat', 'asc')
            ->orderBy('kelas.nama', 'asc')
            ->orderBy('haris.kode_hari', 'asc')
            ->get();

        $export = new JadwalsiswaExport($jadwalmapel);
        return Excel::download($export, 'jadwal.xlsx');
    }



    public function Absensidatasiswapdf()
    {

        $userId = Auth::user()->id;
        $absensi = Absensi::join('siswas', 'absensis.id_siswa', '=', 'siswas.id')
            ->where('siswas.id_user', $userId)
            ->select('absensis.*')
            ->orderByRaw("STR_TO_DATE(tanggal, '%d/%m/%Y') DESC")
            ->get();

        $pdf = PDF::loadView('backend.data.export.export_pdf_absensidatasiswa', compact('absensi'));

        return $pdf->download('absensisiswa.pdf');
    }


    public function Nilaisiswapdf()
    {

        $userId = Auth::user()->id;
        $siswa = Siswa::where('id_user', $userId)->first();

        $rombelSiswaIds = RombelSiswa::where('id_siswa', $siswa->id)->pluck('id')->toArray();
        if ($rombelSiswaIds) {
            $rombelSiswa = RombelSiswa::whereIn('id', $rombelSiswaIds)->get();
            if ($rombelSiswa) {
                $nilaiSiswaKd3 = NilaisiswaKd3::whereIn('id_rombelsiswa', $rombelSiswaIds)->get();
                $nilaiSiswaKd4 = NilaisiswaKd4::whereIn('id_rombelsiswa', $rombelSiswaIds)->get();
            }
        }




        $pdf = PDF::loadView('backend.data.export.export_pdf_nilai', compact('nilaiSiswaKd3', 'nilaiSiswaKd4'));

        return $pdf->download('nilaisiswa.pdf');
    }
}
