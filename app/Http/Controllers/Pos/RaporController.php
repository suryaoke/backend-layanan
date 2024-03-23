<?php

namespace App\Http\Controllers\Pos;

use App\Exports\LeggerExport;
use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
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

        $fileName = 'Nilai Siswa ' . $rombelsiswa->nama . ' Nisn ' . $rombelsiswa->nisn . '.pdf';

        // Menggunakan kelas PDF dari paket Barryvdh\DomPDF\PDF
        $pdf = PDF::loadView('backend.data.rapor.nilai_pdf', compact('rombelsiswa'));

        return $pdf->download($fileName);
    }
}
