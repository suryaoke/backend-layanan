<?php

namespace App\Http\Controllers\Pos;

use App\Exports\EkstraExport;
use App\Exports\EkstraUploadExport;
use App\Exports\PresensiExport;
use App\Exports\PresensiUploadExport;
use App\Exports\PresensiUploadiExport;
use App\Exports\RombelExport;
use App\Http\Controllers\Controller;
use App\Imports\EkstraImport;
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

class EkstraController extends Controller
{
    public function EkstraAll(request $request)
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




        return view('backend.data.ekstra.ekstra_all', compact('datacttnwalas', 'datatahun', 'cttnwalas', 'tahunAjarSaatIni'));
    } // end method



    public function EkstraExport(Request $request)
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

        $fileName = 'Data Nilai Ekstrakulikuler Siswa Kelas' . ' ' . $kelas->tingkat . $kelas->nama . $jurusan->nama . ' ' . 'Tahun Ajar ' . $tahun->tahun . ' Semester ' . $tahun->semester . '.xlsx';

        return Excel::download(new EkstraExport($cttnwalas, $tahun), $fileName);
    }


    public function ekstraImport(Request $request)
    {
        // Pastikan file telah diunggah sebelum melanjutkan
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $namfile = date('YmdHi') . $file->getClientOriginalName();
            $file->move('DataEkstra', $namfile);
            Excel::import(new EkstraImport, public_path('/DataEkstra/' . $namfile));
        } else {
            // File tidak diunggah atau tidak valid
            $notification = [
                'message' => 'Ekstra Upload Successfully',
                'alert-type' => 'success'
            ];
        }

        return redirect()->route('ekstra.all')->with($notification);
    }
    public function EkstraUploadExport(Request $request)
    {
        $tahun =  $request->input('tahun');
        $userId = Auth::user()->id;

        $cttnwalas = CatataWalas::join('rombelsiswas', 'catata_walas.id_rombelsiswa', '=', 'rombelsiswas.id')
            ->join('rombels', 'rombelsiswas.id_rombel', '=', 'rombels.id')
            ->join('walas', 'rombels.id_walas', '=', 'walas.id')
            ->join('gurus', 'walas.id_guru', '=', 'gurus.id')
            ->where('gurus.id_user', '=', $userId)
            ->where('id_tahunajar', $tahun)
            ->select('catata_walas.*') // Memilih semua kolom dari tabel catata_walas
            ->get();

        return Excel::download(new EkstraUploadExport($cttnwalas), 'Template Ekstra.xlsx');
    }

    public function EkstraUpdate(Request $request)
    {
        $ekstraid = $request->id; // Ambil array id dari permintaan
        foreach ($ekstraid as $key => $ekstraids) {
            $data = CatataWalas::findOrFail($ekstraids); // Mencari data sesuai dengan id

            $data->ekstra = $request->ekstra[$key]; // Perbarui nilai
            $data->nilai_ekstra = $request->nilai_ekstra[$key];

            $data->save(); // Simpan perubahan
        }

        $notification = array(
            'message' => 'Ekstra Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // end method
}
