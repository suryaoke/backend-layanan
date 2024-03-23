<?php

namespace App\Http\Controllers\Pos;

use App\Exports\SikapExport;
use App\Exports\SikapUploadExport;
use App\Exports\PresensiExport;
use App\Exports\PresensiUploadExport;
use App\Exports\PresensiUploadiExport;
use App\Exports\RombelExport;
use App\Exports\SosialExport;
use App\Exports\SosialUploadExport;
use App\Exports\SpiritualExport;
use App\Exports\SpiritualUploadExport;
use App\Http\Controllers\Controller;
use App\Imports\SikapImport;
use App\Imports\GuruImport;
use App\Imports\PresensiImport;
use App\Imports\SosialImport;
use App\Imports\SpiritualImport;
use App\Imports\UserImport;
use App\Models\CatataWalas;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Rapor;
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

class SikapController extends Controller
{
    public function SikapAll(request $request)
    {
        $searchTahun = $request->input('searchtahun');
        $searchNisn = $request->input('searchnisn');
        $searchNama = $request->input('searchnama');
        $searchJk = $request->input('searchjk');
        $query = Rapor::query();

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
            $rapor = $query->join('rombelsiswas', 'rapors.id_rombelsiswa', '=', 'rombelsiswas.id')
                ->join('rombels', 'rombelsiswas.id_rombel', '=', 'rombels.id')
                ->join('walas', 'rombels.id_walas', '=', 'walas.id')
                ->join('gurus', 'walas.id_guru', '=', 'gurus.id')
                ->where('gurus.id_user', '=', $userId)
                ->select('rapors.*') // Memilih semua kolom dari tabel catata_walas
                ->get();
            $rapors = $rapor->first();
        } elseif ($searchTahun) {

            $userId = Auth::user()->id;

            $rapor = $query->join('rombelsiswas', 'rapors.id_rombelsiswa', '=', 'rombelsiswas.id')
                ->join('rombels', 'rombelsiswas.id_rombel', '=', 'rombels.id')
                ->join('walas', 'rombels.id_walas', '=', 'walas.id')
                ->join('gurus', 'walas.id_guru', '=', 'gurus.id')
                ->where('gurus.id_user', '=', $userId)

                ->select('rapors.*') // Memilih semua kolom dari tabel catata_walas
                ->get();
            $rapors = $rapor->first();
        } else {

            $userId = Auth::user()->id;

            $rapor = $query->join('rombelsiswas', 'rapors.id_rombelsiswa', '=', 'rombelsiswas.id')
                ->join('rombels', 'rombelsiswas.id_rombel', '=', 'rombels.id')
                ->where('id_tahunajar', $tahunAjarSaatIni->id)
                ->join('walas', 'rombels.id_walas', '=', 'walas.id')
                ->join('gurus', 'walas.id_guru', '=', 'gurus.id')
                ->where('gurus.id_user', '=', $userId)
                ->select('rapors.*') // Memilih semua kolom dari tabel catata_walas
                ->get();
            $rapors = $rapor->first();
        }

        $datatahun = Tahunajar::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('rapors')
                ->whereRaw('rapors.id_tahunajar = tahunajars.id');
        })->orderby('id', 'desc')
            ->get();




        return view('backend.data.sikap.sikap_all', compact('rapors', 'datatahun', 'rapor', 'tahunAjarSaatIni'));
    } // end method



    public function SosialExport(Request $request)
    {
        $tahunId =  $request->input('tahun');
        $userId = Auth::user()->id;

        $rapor = Rapor::join('rombelsiswas', 'rapors.id_rombelsiswa', '=', 'rombelsiswas.id')
            ->join('rombels', 'rombelsiswas.id_rombel', '=', 'rombels.id')

            ->join('walas', 'rombels.id_walas', '=', 'walas.id')
            ->join('gurus', 'walas.id_guru', '=', 'gurus.id')
            ->where('rombels.id_tahunjar', $tahunId)
            ->where('gurus.id_user', '=', $userId)
            ->select('rapors.*') // Memilih semua kolom dari tabel catata_walas
            ->get();

        $datarapor = $rapor->first();
        $datarombelsiswa = Rombelsiswa::where('id', $datarapor->id_rombelsiswa)->first();
        $rombel = Rombel::where('id', $datarombelsiswa->id_rombel)->first();
        $kelas = Kelas::where('id', $rombel->id_kelas)->first();
        $jurusan = Jurusan::where('id', $kelas->id_jurusan)->first();

        $tahun = Tahunajar::where('id', $tahunId)->first();

        $fileName = 'Data Nilai Sikap Sosial Siswa Kelas' . ' ' . $kelas->tingkat . $kelas->nama . $jurusan->nama . ' ' . 'Tahun Ajar ' . $tahun->tahun . ' Semester ' . $tahun->semester . '.xlsx';



        return Excel::download(new SosialExport($rapor, $tahun), $fileName);
    }


    public function sosialImport(Request $request)
    {
        // Pastikan file telah diunggah sebelum melanjutkan
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $namfile = date('YmdHi') . $file->getClientOriginalName();
            $file->move('DataSosial', $namfile);
            Excel::import(new SosialImport, public_path('/DataSosial/' . $namfile));
        } else {
            // File tidak diunggah atau tidak valid
            $notification = [
                'message' => 'Sikap Sosial Upload Successfully',
                'alert-type' => 'success'
            ];
        }

        return redirect()->route('sikap.all')->with($notification);
    }
    public function SosialUploadExport(Request $request)
    {
        $tahun =  $request->input('tahun');
        $userId = Auth::user()->id;

        $rapor = Rapor::join('rombelsiswas', 'rapors.id_rombelsiswa', '=', 'rombelsiswas.id')
            ->join('rombels', 'rombelsiswas.id_rombel', '=', 'rombels.id')
            ->join('walas', 'rombels.id_walas', '=', 'walas.id')
            ->join('gurus', 'walas.id_guru', '=', 'gurus.id')
            ->where('gurus.id_user', '=', $userId)
            ->where('id_tahunajar', $tahun)
            ->select('rapors.*') // Memilih semua kolom dari tabel catata_walas
            ->get();

        return Excel::download(new SosialUploadExport($rapor), 'Template Sosial.xlsx');
    }



    public function SikapSosialUpdate(Request $request)
    {
        $sosialid = $request->id; // Ambil array id dari permintaan
        foreach ($sosialid as $key => $sosialids) {
            $data = Rapor::findOrFail($sosialids); // Mencari data sesuai dengan id

            // Update nilai sosial sesuai dengan array nilai
            $nilaiArray = array(
                '0' => $request->input('kejujuran')[$key],
                '1' => $request->input('kedisiplinan')[$key],
                '2' => $request->input('tanggungjawab')[$key],
                '3' => $request->input('toleransi')[$key],
                '4' => $request->input('gotongroyong')[$key],
                '5' => $request->input('kesantunan')[$key],
                '6' => $request->input('percayadiri')[$key],
            );

            // Mengubah array nilai menjadi format JSON sebelum menyimpannya ke database
            $data->nilai_sosial = json_encode($nilaiArray);

            $data->save(); // Simpan perubahan
        }

        $notification = array(
            'message' => 'Sikap Sosial Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }



    public function SpiritualExport(Request $request)
    {
        $tahunId =  $request->input('tahun');
        $userId = Auth::user()->id;

        $rapor = Rapor::join('rombelsiswas', 'rapors.id_rombelsiswa', '=', 'rombelsiswas.id')
            ->join('rombels', 'rombelsiswas.id_rombel', '=', 'rombels.id')

            ->join('walas', 'rombels.id_walas', '=', 'walas.id')
            ->join('gurus', 'walas.id_guru', '=', 'gurus.id')
            ->where('rombels.id_tahunjar', $tahunId)
            ->where('gurus.id_user', '=', $userId)
            ->select('rapors.*') // Memilih semua kolom dari tabel catata_walas
            ->get();


        $datarapor = $rapor->first();
        $datarombelsiswa = Rombelsiswa::where('id', $datarapor->id_rombelsiswa)->first();
        $rombel = Rombel::where('id', $datarombelsiswa->id_rombel)->first();
        $kelas = Kelas::where('id', $rombel->id_kelas)->first();
        $jurusan = Jurusan::where('id', $kelas->id_jurusan)->first();

        $tahun = Tahunajar::where('id', $tahunId)->first();

        $fileName = 'Data Nilai Sikap Spiritual Siswa Kelas' . ' ' . $kelas->tingkat . $kelas->nama . $jurusan->nama . ' ' . 'Tahun Ajar ' . $tahun->tahun . ' Semester ' . $tahun->semester . '.xlsx';


        return Excel::download(new SpiritualExport($rapor, $tahun), $fileName);
    }

    public function SikapSpiritualUpdate(Request $request)
    {
        $sosialid = $request->id; // Ambil array id dari permintaan
        foreach ($sosialid as $key => $sosialids) {
            $data = Rapor::findOrFail($sosialids); // Mencari data sesuai dengan id

            // Update nilai sosial sesuai dengan array nilai
            $nilaiArray = array(
                '0' => $request->input('berdoa')[$key],
                '1' => $request->input('memberisalam')[$key],
                '2' => $request->input('sholatberjamaah')[$key],
                '3' => $request->input('bersyukur')[$key],

            );

            // Mengubah array nilai menjadi format JSON sebelum menyimpannya ke database
            $data->nilai_spiritual = json_encode($nilaiArray);

            $data->save(); // Simpan perubahan
        }

        $notification = array(
            'message' => 'Sikap Spiritual Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }


    public function SpiritualUploadExport(Request $request)
    {
        $tahun =  $request->input('tahun');
        $userId = Auth::user()->id;

        $rapor = Rapor::join('rombelsiswas', 'rapors.id_rombelsiswa', '=', 'rombelsiswas.id')
            ->join('rombels', 'rombelsiswas.id_rombel', '=', 'rombels.id')
            ->join('walas', 'rombels.id_walas', '=', 'walas.id')
            ->join('gurus', 'walas.id_guru', '=', 'gurus.id')
            ->where('gurus.id_user', '=', $userId)
            ->where('id_tahunajar', $tahun)
            ->select('rapors.*') // Memilih semua kolom dari tabel catata_walas
            ->get();

        return Excel::download(new SpiritualUploadExport($rapor), 'Template Spiritual.xlsx');
    }



    public function spiritualImport(Request $request)
    {
        // Pastikan file telah diunggah sebelum melanjutkan
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $namfile = date('YmdHi') . $file->getClientOriginalName();
            $file->move('DataSpiritual', $namfile);
            Excel::import(new SpiritualImport, public_path('/DataSpiritual/' . $namfile));
        } else {
            // File tidak diunggah atau tidak valid
            $notification = [
                'message' => 'Sikap Spiritual Upload Successfully',
                'alert-type' => 'success'
            ];
        }

        return redirect()->route('sikap.all')->with($notification);
    }
}
