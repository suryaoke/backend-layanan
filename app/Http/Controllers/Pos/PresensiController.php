<?php

namespace App\Http\Controllers\Pos;

use App\Exports\PresensiExport;
use App\Exports\PresensiUploadExport;
use App\Exports\PresensiUploadiExport;
use App\Exports\RombelExport;
use App\Http\Controllers\Controller;
use App\Imports\GuruImport;
use App\Imports\PresensiImport;
use App\Imports\UserImport;
use App\Models\CatataWalas;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Rombel;
use App\Models\Rombelsiswa;
use App\Models\Tahunajar;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class PresensiController extends Controller
{
    public function PresensiAll(request $request)
    {
        $searchTahun = $request->input('searchtahun');
        $searchNisn = $request->input('searchnisn');
        $searchNama = $request->input('searchnama');
        $searchJk = $request->input('searchjk');
        $query = CatataWalas::query();

        if (!empty($searchTahun)) {
            $query->whereHas('tahun', function ($lecturerQuery) use ($searchTahun) {
                $lecturerQuery->where('id', 'LIKE', '%' . $searchTahun . '%');
            });
        }
        if (!empty($searchNisn)) {
            $query->whereHas('rombelsiswas', function ($lecturerQuery) use ($searchNisn) {
                $lecturerQuery->whereHas('siswas', function ($courseQuery) use ($searchNisn) {
                    $courseQuery->where('nisn', 'LIKE', '%' .  $searchNisn . '%');
                });
            });
        }
        if (!empty($searchNama)) {
            $query->whereHas('rombelsiswas', function ($lecturerQuery) use ($searchNama) {
                $lecturerQuery->whereHas('siswas', function ($courseQuery) use ($searchNama) {
                    $courseQuery->where('nama', 'LIKE', '%' .  $searchNama . '%');
                });
            });
        }
        if (!empty($searchJk)) {
            $query->whereHas('rombelsiswas', function ($lecturerQuery) use ($searchJk) {
                $lecturerQuery->whereHas('siswas', function ($courseQuery) use ($searchJk) {
                    $courseQuery->where('jk', 'LIKE', '%' .  $searchJk . '%');
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
            $cttnwalas = $query->join('rombelsiswas', 'catata_walas.id_rombelsiswa', '=', 'rombelsiswas.id')
                ->join('rombels', 'rombelsiswas.id_rombel', '=', 'rombels.id')
                ->join('walas', 'rombels.id_walas', '=', 'walas.id')
                ->join('gurus', 'walas.id_guru', '=', 'gurus.id')
                ->where('gurus.id_user', '=', $userId)
                ->orderBy('id')
                ->select('catata_walas.*') // Memilih semua kolom dari tabel catata_walas
                ->get();
            $datacttnwalas = $cttnwalas->first();
        } elseif ($searchTahun) {

            $userId = Auth::user()->id;

            $cttnwalas = $query->join('rombelsiswas', 'catata_walas.id_rombelsiswa', '=', 'rombelsiswas.id')
                ->join('rombels', 'rombelsiswas.id_rombel', '=', 'rombels.id')
                ->join('walas', 'rombels.id_walas', '=', 'walas.id')
                ->join('gurus', 'walas.id_guru', '=', 'gurus.id')
                ->where('gurus.id_user', '=', $userId)
                ->orderBy('id')
                ->select('catata_walas.*') // Memilih semua kolom dari tabel catata_walas
                ->get();
            $datacttnwalas = $cttnwalas->first();
        } else {

            $userId = Auth::user()->id;

            $cttnwalas = $query->join('rombelsiswas', 'catata_walas.id_rombelsiswa', '=', 'rombelsiswas.id')
                ->join('rombels', 'rombelsiswas.id_rombel', '=', 'rombels.id')
                ->where('id_tahunajar', $tahunAjarSaatIni->id)
                ->join('walas', 'rombels.id_walas', '=', 'walas.id')
                ->join('gurus', 'walas.id_guru', '=', 'gurus.id')
                ->where('gurus.id_user', '=', $userId)
                ->orderBy('id')
                ->select('catata_walas.*') // Memilih semua kolom dari tabel catata_walas
                ->get();
            $datacttnwalas = $cttnwalas->first();
        }

        $datatahun = Tahunajar::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('catata_walas')
                ->whereRaw('catata_walas.id_tahunajar = tahunajars.id');
        })->orderby('id', 'desc')
            ->get();




        return view('backend.data.presensi.presensi_all', compact('datacttnwalas', 'datatahun', 'cttnwalas', 'tahunAjarSaatIni'));
    } // end method



    public function PresensiExport(Request $request)
    {
        $tahunId =  $request->input('tahun');
        $userId = Auth::user()->id;

        $cttnwalas = CatataWalas::join('rombelsiswas', 'catata_walas.id_rombelsiswa', '=', 'rombelsiswas.id')
            ->join('rombels', 'rombelsiswas.id_rombel', '=', 'rombels.id')

            ->join('walas', 'rombels.id_walas', '=', 'walas.id')
            ->join('gurus', 'walas.id_guru', '=', 'gurus.id')
            ->where('rombels.id_tahunjar', $tahunId)
            ->where('gurus.id_user', '=', $userId)
            ->select('catata_walas.*') // Memilih semua kolom dari tabel catata_walas
            ->get();

        $datacttnwalas = $cttnwalas->first();
        $datarombelsiswa = Rombelsiswa::where('id', $datacttnwalas->id_rombelsiswa)->first();
        $rombel = Rombel::where('id', $datarombelsiswa->id_rombel)->first();
        $kelas = Kelas::where('id', $rombel->id_kelas)->first();
        $jurusan = Jurusan::where('id', $kelas->id_jurusan)->first();

        $tahun = Tahunajar::where('id', $tahunId)->first();

        $fileName = 'Data Presensi Siswa Kelas' . ' ' . $kelas->tingkat . $kelas->nama . $jurusan->nama . ' ' . 'Tahun Ajar ' . $tahun->tahun . ' Semester ' . $tahun->semester . '.xlsx';



        return Excel::download(new PresensiExport($cttnwalas, $tahun), $fileName);
    }


    public function presensiImport(Request $request)
    {
        // Pastikan file telah diunggah sebelum melanjutkan
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $namfile = date('YmdHi') . $file->getClientOriginalName();
            $file->move('DataPresensi', $namfile);
            Excel::import(new PresensiImport, public_path('/DataPresensi/' . $namfile));
        } else {
            // File tidak diunggah atau tidak valid
            $notification = [
                'message' => 'Presensi Upload Successfully',
                'alert-type' => 'success'
            ];
        }

        return redirect()->route('presensi.all')->with($notification);
    }
    public function PresensiUploadExport(Request $request)
    {
        $tahun =  $request->input('tahun');
        $userId = Auth::user()->id;

        $cttnwalas = CatataWalas::join('rombelsiswas', 'catata_walas.id_rombelsiswa', '=', 'rombelsiswas.id')
            ->join('rombels', 'rombelsiswas.id_rombel', '=', 'rombels.id')

            ->join('walas', 'rombels.id_walas', '=', 'walas.id')
            ->join('gurus', 'walas.id_guru', '=', 'gurus.id')
            ->where('gurus.id_user', '=', $userId)
            ->where('id_tahunajar', $tahun)
            ->orderBy('id')
            ->select('catata_walas.*') // Memilih semua kolom dari tabel catata_walas
            ->get();

        return Excel::download(new PresensiUploadExport($cttnwalas), 'Template Presensi.xlsx');
    }

    public function PresensiUpdate(Request $request)
    {
        $presensiid = $request->id; // Ambil array id dari permintaan
        foreach ($presensiid as $key => $presensiids) {
            $data = CatataWalas::findOrFail($presensiids); // Mencari data sesuai dengan id

            $data->alfa = $request->alfa[$key]; // Perbarui nilai
            $data->izin = $request->izin[$key]; // Perbarui remedial
            $data->sakit = $request->sakit[$key]; // Perbarui feedback      

            $data->save(); // Simpan perubahan
        }

        $notification = array(
            'message' => 'Presensi Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // end method
}
