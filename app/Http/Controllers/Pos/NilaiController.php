<?php

namespace App\Http\Controllers\Pos;

use App\Exports\KeterampilanExport;
use App\Exports\KeterampilanPortofolioExport;
use App\Exports\KeterampilanProyekExport;
use App\Exports\KeterampilanUnjukkerjaExport;
use App\Exports\PengetahuanAakhirExport;
use App\Exports\PengetahuanAkhirExport;
use App\Exports\PengetahuanExport;
use App\Exports\PengetahuanHarianExport;
use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Rombel;
use App\Models\Rombelsiswa;
use App\Models\Seksi;
use App\Models\Tahunajar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class NilaiController extends Controller
{
    public function NilaiAll(request $request, $id)
    {
        $searchSeksi = $request->input('searchseksi');
        $query = Seksi::query();

        if (!empty($searchSeksi)) {
            $query->where('id', '=', $searchSeksi);
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


        $userId = Auth::user()->id;
        $seksi = $query

            ->join('jadwalmapels', 'jadwalmapels.id', '=', 'seksis.id_jadwal')
            ->join('pengampus', 'pengampus.id', '=', 'jadwalmapels.id_pengampu')
            ->join('gurus', 'gurus.id', '=', 'pengampus.id_guru')

            ->where('seksis.semester', $tahunAjarSaatIni->id)
            ->where('seksis.id', $id)
            ->where('gurus.id_user', '=', $userId)
            ->select('seksis.*') // Memilih semua kolom dari tabel catata_walas
            ->get();
        $dataseksi = $seksi->first();

        $datatahun = Tahunajar::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('catata_walas')
                ->whereRaw('catata_walas.id_tahunajar = tahunajars.id');
        })->orderby('id', 'desc')
            ->get();




        return view('backend.data.nilai.nilai_all', compact('dataseksi', 'datatahun', 'seksi'));
    } // end method

    public function NilaiAlll(request $request, $id)
    {



        $userId = Auth::user()->id;
        $seksi = Seksi::join('jadwalmapels', 'jadwalmapels.id', '=', 'seksis.id_jadwal')
            ->join('pengampus', 'pengampus.id', '=', 'jadwalmapels.id_pengampu')
            ->join('gurus', 'gurus.id', '=', 'pengampus.id_guru')
            ->where('seksis.id', $id)
            ->where('gurus.id_user', '=', $userId)
            ->select('seksis.*') // Memilih semua kolom dari tabel catata_walas
            ->get();
        $dataseksi = $seksi->first();

        $datatahun = Tahunajar::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('catata_walas')
                ->whereRaw('catata_walas.id_tahunajar = tahunajars.id');
        })->orderby('id', 'desc')
            ->get();




        return view('backend.data.nilai.nilai_all', compact('dataseksi', 'datatahun', 'seksi'));
    } // end method


    public function NilaiHarianPengetahuanAdd(request $request, $id)
    {
        $searchTahun = $request->input('searchtahun');
        $query = Seksi::query();

        if (!empty($searchTahun)) {
            $query->whereHas('tahun', function ($lecturerQuery) use ($searchTahun) {
                $lecturerQuery->where('id', 'LIKE', '%' . $searchTahun . '%');
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

        $userId = Auth::user()->id;



        $seksi = $query

            ->join('jadwalmapels', 'jadwalmapels.id', '=', 'seksis.id_jadwal')
            ->join('pengampus', 'pengampus.id', '=', 'jadwalmapels.id_pengampu')
            ->join('gurus', 'gurus.id', '=', 'pengampus.id_guru')

            ->where('seksis.semester', $tahunAjarSaatIni->id)
            ->where('seksis.id', $id)
            ->where('gurus.id_user', '=', $userId)
            ->select('seksis.*') // Memilih semua kolom dari tabel catata_walas
            ->get();
        $dataseksi = $seksi->first();


        $datatahun = Tahunajar::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('catata_walas')
                ->whereRaw('catata_walas.id_tahunajar = tahunajars.id');
        })->orderby('id', 'desc')
            ->get();




        return view('backend.data.nilai.nilai_pengetahuan_harian', compact('dataseksi', 'datatahun', 'seksi'));
    } // end method


    public function NilaiAkhirPengetahuanAdd(request $request, $id)
    {
        $searchTahun = $request->input('searchtahun');
        $query = Seksi::query();

        if (!empty($searchTahun)) {
            $query->whereHas('tahun', function ($lecturerQuery) use ($searchTahun) {
                $lecturerQuery->where('id', 'LIKE', '%' . $searchTahun . '%');
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

        $userId = Auth::user()->id;


        $seksi = $query

            ->join('jadwalmapels', 'jadwalmapels.id', '=', 'seksis.id_jadwal')
            ->join('pengampus', 'pengampus.id', '=', 'jadwalmapels.id_pengampu')
            ->join('gurus', 'gurus.id', '=', 'pengampus.id_guru')

            ->where('seksis.semester', $tahunAjarSaatIni->id)
            ->where('seksis.id', $id)
            ->where('gurus.id_user', '=', $userId)
            ->select('seksis.*') // Memilih semua kolom dari tabel catata_walas
            ->get();
        $dataseksi = $seksi->first();


        $datatahun = Tahunajar::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('catata_walas')
                ->whereRaw('catata_walas.id_tahunajar = tahunajars.id');
        })->orderby('id', 'desc')
            ->get();




        return view('backend.data.nilai.nilai_pengetahuan_akhir', compact('dataseksi', 'datatahun', 'seksi'));
    } // end method


    public function NilaiHarianPengetahuanStore(Request $request)
    {
        $selectedSeksi = $request->input('id_seksi');
        $nilai_pengetahuan = $request->input('nilai_pengetahuan');

        // Mendapatkan semua nilai PH untuk id_seksi yang sama
        $existingPHValues = Nilai::where('id_seksi', $selectedSeksi)->pluck('ph')->toArray();

        // Mengecek apakah ada nilai PH yang sama
        if (in_array($request->ph, $existingPHValues)) {
            $notification = array(
                'message' => 'PH Sudah Ada.!!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        $seksi = Seksi::where('id', $selectedSeksi)->first();
        $rombel = Rombel::where('id', $seksi->id_rombel)->first();
        $rombelsiswa = Rombelsiswa::where('id_rombel', $rombel->id)->get();
        foreach ($rombelsiswa as $index => $rombelsiswaId) {
            $nilai = new Nilai();
            $nilai->id_seksi =  $selectedSeksi;
            $nilai->id_rombelsiswa = $rombelsiswaId->id;
            $nilai->id_tahunajar = $seksi->semester;
            $nilai->nilai_pengetahuan = $nilai_pengetahuan[$index];
            $nilai->catatan_pengetahuan = $request->catatan_pengetahuan;
            $nilai->type_nilai = 1;
            $nilai->ph = $request->ph;
            $nilai->save();
        }

        $notification = array(
            'message' => 'Nilai Pengetahuan Harian Create Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function NilaiHarianPengetahuanDelete($id)
    {
        // Menghapus nilai sesuai dengan id_seksi
        $nilai = Nilai::where('ph', $id)
            ->whereHas('seksis', function ($query) {
                $query->where('id_seksi', request()->id_seksi);
            })
            ->delete();

        $notification = array(
            'message' => 'Nilai Pengetahuan Harian Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function NilaiHarianPengetahuanUpdate(Request $request)
    {
        $nilaiid = $request->id; // Ambil array id dari permintaan
        foreach ($nilaiid as $key => $nilaiids) {
            $data = Nilai::findOrFail($nilaiids); // Mencari data sesuai dengan id

            $data->nilai_pengetahuan = $request->nilai_pengetahuan[$key]; // Perbarui nilai
            $data->catatan_pengetahuan = $request->catatan_pengetahuan;
            $data->ph = $request->ph;
            $data->save(); // Simpan perubahan
        }

        $notification = array(
            'message' => 'Nilai Pengetahuan Harian Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // end method


    public function NilaiAkhirPengetahuanStore(Request $request)
    {
        $selectedSeksi = $request->input('id_seksi');
        $nilai_pengetahuan_akhir = $request->input('nilai_pengetahuan_akhir');


        $seksi = Seksi::where('id', $selectedSeksi)->first();
        $rombel = Rombel::where('id', $seksi->id_rombel)->first();
        $rombelsiswa = Rombelsiswa::where('id_rombel', $rombel->id)->get();
        foreach ($rombelsiswa as $index => $rombelsiswaId) {
            $nilai = new Nilai();
            $nilai->id_seksi =  $selectedSeksi;
            $nilai->id_rombelsiswa = $rombelsiswaId->id;
            $nilai->id_tahunajar = $seksi->semester;
            $nilai->nilai_pengetahuan_akhir = $nilai_pengetahuan_akhir[$index];
            $nilai->type_nilai = 2;
            $nilai->save();
        }

        $notification = array(
            'message' => 'Nilai Pengetahuan PAS Create Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }



    public function NilaiAkhirPengetahuanUpdate(Request $request)
    {
        $nilaiid = $request->id; // Ambil array id dari permintaan
        foreach ($nilaiid as $key => $nilaiids) {
            $data = Nilai::findOrFail($nilaiids); // Mencari data sesuai dengan id

            $data->nilai_pengetahuan_akhir = $request->nilai_pengetahuan_akhir[$key]; // Perbarui nilai

            $data->save(); // Simpan perubahan
        }

        $notification = array(
            'message' => 'Nilai Pengetahuan PAS Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // end method


    public function NilaiAkhirPengetahuanDelete($id)
    {
        // Menghapus nilai sesuai dengan id_seksi
        $nilai = Nilai::where('id_seksi', $id)
            ->where('type_nilai', 2)
            ->delete();

        $notification = array(
            'message' => 'Nilai Pengetahuan Harian Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }


    public function NilaiPortofolioKeterampilanAdd(request $request, $id)
    {
        $searchTahun = $request->input('searchtahun');
        $query = Seksi::query();

        if (!empty($searchTahun)) {
            $query->whereHas('tahun', function ($lecturerQuery) use ($searchTahun) {
                $lecturerQuery->where('id', 'LIKE', '%' . $searchTahun . '%');
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

        $userId = Auth::user()->id;



        $seksi = $query

            ->join('jadwalmapels', 'jadwalmapels.id', '=', 'seksis.id_jadwal')
            ->join('pengampus', 'pengampus.id', '=', 'jadwalmapels.id_pengampu')
            ->join('gurus', 'gurus.id', '=', 'pengampus.id_guru')

            ->where('seksis.semester', $tahunAjarSaatIni->id)
            ->where('seksis.id', $id)
            ->where('gurus.id_user', '=', $userId)
            ->select('seksis.*') // Memilih semua kolom dari tabel catata_walas
            ->get();
        $dataseksi = $seksi->first();


        $datatahun = Tahunajar::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('catata_walas')
                ->whereRaw('catata_walas.id_tahunajar = tahunajars.id');
        })->orderby('id', 'desc')
            ->get();




        return view('backend.data.nilai.nilai_keterampilan_portofolio', compact('dataseksi', 'datatahun', 'seksi'));
    } // end method





    public function NilaiPortofolioKeterampilanStore(Request $request)
    {
        $selectedSeksi = $request->input('id_seksi');
        $nilai_keterampilan = $request->input('nilai_keterampilan');

        // Mendapatkan semua nilai PH untuk id_seksi yang sama
        $existingPHValues = Nilai::where('id_seksi', $selectedSeksi)->pluck('kd')->where('type_keterampilan', '1')->toArray();

        // Mengecek apakah ada nilai PH yang sama
        if (in_array($request->kd, $existingPHValues)) {
            $notification = array(
                'message' => 'KD Sudah Ada.!!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        $seksi = Seksi::where('id', $selectedSeksi)->first();
        $rombel = Rombel::where('id', $seksi->id_rombel)->first();
        $rombelsiswa = Rombelsiswa::where('id_rombel', $rombel->id)->get();
        foreach ($rombelsiswa as $index => $rombelsiswaId) {
            $nilai = new Nilai();
            $nilai->id_seksi =  $selectedSeksi;
            $nilai->id_rombelsiswa = $rombelsiswaId->id;
            $nilai->id_tahunajar = $seksi->semester;
            $nilai->nilai_keterampilan = $nilai_keterampilan[$index];
            $nilai->catatan_keterampilan = $request->catatan_keterampilan;
            $nilai->type_nilai = 3;
            $nilai->kd = $request->kd;
            $nilai->type_keterampilan = 1;
            $nilai->save();
        }

        $notification = array(
            'message' => 'Nilai Keterampilan Portofolio Create Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // end method



    public function NilaiPortofolioKeterampilanUpdate(Request $request)
    {
        $nilaiid = $request->id; // Ambil array id dari permintaan
        foreach ($nilaiid as $key => $nilaiids) {
            $data = Nilai::findOrFail($nilaiids); // Mencari data sesuai dengan id

            $data->nilai_keterampilan = $request->nilai_keterampilan[$key]; // Perbarui nilai
            $data->catatan_keterampilan = $request->catatan_keterampilan;
            $data->kd = $request->kd;
            $data->save(); // Simpan perubahan
        }

        $notification = array(
            'message' => 'Nilai Keterampilan Portofolio Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // end method


    public function NilaiPortofolioKeterampilanDelete($id)
    {
        // Menghapus nilai sesuai dengan id_seksi
        $nilai = Nilai::where('kd', $id)
            ->where('type_keterampilan', '1')
            ->whereHas('seksis', function ($query) {
                $query->where('id_seksi', request()->id_seksi);
            })
            ->delete();

        $notification = array(
            'message' => 'Nilai Keterampilan Portofolio Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // end method


    public function NilaiProyekKeterampilanAdd(request $request, $id)
    {
        $searchTahun = $request->input('searchtahun');
        $query = Seksi::query();

        if (!empty($searchTahun)) {
            $query->whereHas('tahun', function ($lecturerQuery) use ($searchTahun) {
                $lecturerQuery->where('id', 'LIKE', '%' . $searchTahun . '%');
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

        $userId = Auth::user()->id;



        $seksi = $query

            ->join('jadwalmapels', 'jadwalmapels.id', '=', 'seksis.id_jadwal')
            ->join('pengampus', 'pengampus.id', '=', 'jadwalmapels.id_pengampu')
            ->join('gurus', 'gurus.id', '=', 'pengampus.id_guru')

            ->where('seksis.semester', $tahunAjarSaatIni->id)
            ->where('seksis.id', $id)
            ->where('gurus.id_user', '=', $userId)
            ->select('seksis.*') // Memilih semua kolom dari tabel catata_walas
            ->get();
        $dataseksi = $seksi->first();


        $datatahun = Tahunajar::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('catata_walas')
                ->whereRaw('catata_walas.id_tahunajar = tahunajars.id');
        })->orderby('id', 'desc')
            ->get();




        return view('backend.data.nilai.nilai_keterampilan_proyek', compact('dataseksi', 'datatahun', 'seksi'));
    } // end method


    public function NilaiProyekKeterampilanStore(Request $request)
    {
        $selectedSeksi = $request->input('id_seksi');
        $nilai_keterampilan = $request->input('nilai_keterampilan');

        // Mendapatkan semua nilai PH untuk id_seksi yang sama
        $existingPHValues = Nilai::where('id_seksi', $selectedSeksi)->where('type_keterampilan', '2')->pluck('kd')->toArray();

        // Mengecek apakah ada nilai PH yang sama
        if (in_array($request->kd, $existingPHValues)) {
            $notification = array(
                'message' => 'KD Sudah Ada.!!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        $seksi = Seksi::where('id', $selectedSeksi)->first();
        $rombel = Rombel::where('id', $seksi->id_rombel)->first();
        $rombelsiswa = Rombelsiswa::where('id_rombel', $rombel->id)->get();
        foreach ($rombelsiswa as $index => $rombelsiswaId) {
            $nilai = new Nilai();
            $nilai->id_seksi =  $selectedSeksi;
            $nilai->id_rombelsiswa = $rombelsiswaId->id;
            $nilai->id_tahunajar = $seksi->semester;
            $nilai->nilai_keterampilan = $nilai_keterampilan[$index];
            $nilai->catatan_keterampilan = $request->catatan_keterampilan;
            $nilai->type_nilai = 3;
            $nilai->kd = $request->kd;
            $nilai->type_keterampilan = 2;
            $nilai->save();
        }

        $notification = array(
            'message' => 'Nilai Keterampilan Proyek Create Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // end method

    public function NilaiProyekKeterampilanUpdate(Request $request)
    {
        $nilaiid = $request->id; // Ambil array id dari permintaan
        foreach ($nilaiid as $key => $nilaiids) {
            $data = Nilai::findOrFail($nilaiids); // Mencari data sesuai dengan id

            $data->nilai_keterampilan = $request->nilai_keterampilan[$key]; // Perbarui nilai
            $data->catatan_keterampilan = $request->catatan_keterampilan;
            $data->kd = $request->kd;
            $data->save(); // Simpan perubahan
        }

        $notification = array(
            'message' => 'Nilai Keterampilan Portofolio Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // end method


    public function NilaiProyekKeterampilanDelete($id)
    {
        // Menghapus nilai sesuai dengan id_seksi
        $nilai = Nilai::where('kd', $id)
            ->where('type_keterampilan', '2')
            ->whereHas('seksis', function ($query) {
                $query->where('id_seksi', request()->id_seksi);
            })
            ->delete();

        $notification = array(
            'message' => 'Nilai Keterampilan Proyek Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // end method

    public function NilaiUnjukkerjaKeterampilanAdd(request $request, $id)
    {
        $searchTahun = $request->input('searchtahun');
        $query = Seksi::query();

        if (!empty($searchTahun)) {
            $query->whereHas('tahun', function ($lecturerQuery) use ($searchTahun) {
                $lecturerQuery->where('id', 'LIKE', '%' . $searchTahun . '%');
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

        $userId = Auth::user()->id;



        $seksi = $query

            ->join('jadwalmapels', 'jadwalmapels.id', '=', 'seksis.id_jadwal')
            ->join('pengampus', 'pengampus.id', '=', 'jadwalmapels.id_pengampu')
            ->join('gurus', 'gurus.id', '=', 'pengampus.id_guru')

            ->where('seksis.semester', $tahunAjarSaatIni->id)
            ->where('seksis.id', $id)
            ->where('gurus.id_user', '=', $userId)
            ->select('seksis.*') // Memilih semua kolom dari tabel catata_walas
            ->get();
        $dataseksi = $seksi->first();


        $datatahun = Tahunajar::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('catata_walas')
                ->whereRaw('catata_walas.id_tahunajar = tahunajars.id');
        })->orderby('id', 'desc')
            ->get();




        return view('backend.data.nilai.nilai_keterampilan_unjukkerja', compact('dataseksi', 'datatahun', 'seksi'));
    } // end method


    public function NilaiUnjukkerjaKeterampilanStore(Request $request)
    {
        $selectedSeksi = $request->input('id_seksi');
        $nilai_keterampilan = $request->input('nilai_keterampilan');

        // Mendapatkan semua nilai PH untuk id_seksi yang sama
        $existingPHValues = Nilai::where('id_seksi', $selectedSeksi)->where('type_keterampilan', '3')->pluck('kd')->toArray();

        // Mengecek apakah ada nilai PH yang sama
        if (in_array($request->kd, $existingPHValues)) {
            $notification = array(
                'message' => 'KD Sudah Ada.!!',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        $seksi = Seksi::where('id', $selectedSeksi)->first();
        $rombel = Rombel::where('id', $seksi->id_rombel)->first();
        $rombelsiswa = Rombelsiswa::where('id_rombel', $rombel->id)->get();
        foreach ($rombelsiswa as $index => $rombelsiswaId) {
            $nilai = new Nilai();
            $nilai->id_seksi =  $selectedSeksi;
            $nilai->id_rombelsiswa = $rombelsiswaId->id;
            $nilai->id_tahunajar = $seksi->semester;
            $nilai->nilai_keterampilan = $nilai_keterampilan[$index];
            $nilai->catatan_keterampilan = $request->catatan_keterampilan;
            $nilai->type_nilai = 3;
            $nilai->kd = $request->kd;
            $nilai->type_keterampilan = 3;
            $nilai->save();
        }

        $notification = array(
            'message' => 'Nilai Keterampilan Unjuk Kerja Create Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // end method


    public function NilaiUnjukkerjaKeterampilanUpdate(Request $request)
    {
        $nilaiid = $request->id; // Ambil array id dari permintaan
        foreach ($nilaiid as $key => $nilaiids) {
            $data = Nilai::findOrFail($nilaiids); // Mencari data sesuai dengan id

            $data->nilai_keterampilan = $request->nilai_keterampilan[$key]; // Perbarui nilai
            $data->catatan_keterampilan = $request->catatan_keterampilan;
            $data->kd = $request->kd;
            $data->save(); // Simpan perubahan
        }

        $notification = array(
            'message' => 'Nilai Keterampilan Unjuk Kerja Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // end method

    public function NilaiUnjukkerjaKeterampilanDelete($id)
    {
        // Menghapus nilai sesuai dengan id_seksi
        $nilai = Nilai::where('kd', $id)
            ->where('type_keterampilan', '3')
            ->whereHas('seksis', function ($query) {
                $query->where('id_seksi', request()->id_seksi);
            })
            ->delete();

        $notification = array(
            'message' => 'Nilai Keterampilan Unjuk Kerja Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // end method


    public function PengetahuanExport(Request $request)
    {

        $id = $request->input('id');

        $rombelsiswa = Rombelsiswa::join('rombels', 'rombels.id', '=', 'rombelsiswas.id_rombel')

            ->join('seksis', 'seksis.id_rombel', '=', 'rombels.id')
            ->where('seksis.id', $id)
            ->select('rombelsiswas.*')
            ->get();


        $data = $rombelsiswa->first();
        $rombel = Rombel::where('id', $data->id_rombel)->first();
        $kelas = Kelas::where('id', $rombel->id_kelas)->first();
        $jurusan = Jurusan::where('id', $kelas->id_jurusan)->first();
        $dataseksi = Seksi::where('id', $id)->first();

        $tahun = Tahunajar::where('id', $dataseksi->semester)->first();

        $fileName = 'Data Nilai Pengetahuan Siswa Kelas' . ' ' . $kelas->tingkat . $kelas->nama . $jurusan->nama . ' ' . 'Tahun Ajar ' . $tahun->tahun . ' Semester ' . $tahun->semester . '.xlsx';



        return Excel::download(new PengetahuanExport($rombelsiswa, $id, $tahun), $fileName);
    }


    public function KeterampilanExport(Request $request)
    {

        $id = $request->input('id');

        $rombelsiswa = Rombelsiswa::join('rombels', 'rombels.id', '=', 'rombelsiswas.id_rombel')
            ->join('seksis', 'seksis.id_rombel', '=', 'rombels.id')
            ->where('seksis.id', $id)
            ->select('rombelsiswas.*')
            ->get();


        $data = $rombelsiswa->first();
        $rombel = Rombel::where('id', $data->id_rombel)->first();
        $kelas = Kelas::where('id', $rombel->id_kelas)->first();
        $jurusan = Jurusan::where('id', $kelas->id_jurusan)->first();
        $dataseksi = Seksi::where('id', $id)->first();

        $tahun = Tahunajar::where('id', $dataseksi->semester)->first();

        $fileName = 'Data Nilai Keterampilan Siswa Kelas' . ' ' . $kelas->tingkat . $kelas->nama . $jurusan->nama . ' ' . 'Tahun Ajar ' . $tahun->tahun . ' Semester ' . $tahun->semester . '.xlsx';


        return Excel::download(new KeterampilanExport($rombelsiswa, $id, $tahun), $fileName);
    }

    public function PengetahuanHarianExport(Request $request)
    {

        $id = $request->input('id');

        $rombelsiswa = Rombelsiswa::join('rombels', 'rombels.id', '=', 'rombelsiswas.id_rombel')

            ->join('seksis', 'seksis.id_rombel', '=', 'rombels.id')
            ->where('seksis.id', $id)
            ->select('rombelsiswas.*')
            ->get();

        $data = $rombelsiswa->first();
        $rombel = Rombel::where('id', $data->id_rombel)->first();
        $kelas = Kelas::where('id', $rombel->id_kelas)->first();
        $jurusan = Jurusan::where('id', $kelas->id_jurusan)->first();
        $dataseksi = Seksi::where('id', $id)->first();

        $tahun = Tahunajar::where('id', $dataseksi->semester)->first();

        $fileName = 'Data Nilai Pengetahuan Harian Siswa Kelas' . ' ' . $kelas->tingkat . $kelas->nama . $jurusan->nama . ' ' . 'Tahun Ajar ' . $tahun->tahun . ' Semester ' . $tahun->semester . '.xlsx';

        return Excel::download(new PengetahuanHarianExport($rombelsiswa, $id, $tahun), $fileName);
    }

    public function PengetahuanAkhirExport(Request $request)
    {
        // $tahun =  $request->input('tahun');
        $id = $request->input('id');

        $rombelsiswa = Rombelsiswa::join('rombels', 'rombels.id', '=', 'rombelsiswas.id_rombel')

            ->join('seksis', 'seksis.id_rombel', '=', 'rombels.id')
            ->where('seksis.id', $id)
            ->select('rombelsiswas.*')
            ->get();


        $data = $rombelsiswa->first();
        $rombel = Rombel::where('id', $data->id_rombel)->first();
        $kelas = Kelas::where('id', $rombel->id_kelas)->first();
        $jurusan = Jurusan::where('id', $kelas->id_jurusan)->first();
        $dataseksi = Seksi::where('id', $id)->first();

        $tahun = Tahunajar::where('id', $dataseksi->semester)->first();

        $fileName = 'Data Nilai Pengetahuan PAS Siswa Kelas' . ' ' . $kelas->tingkat . $kelas->nama . $jurusan->nama . ' ' . 'Tahun Ajar ' . $tahun->tahun . ' Semester ' . $tahun->semester . '.xlsx';

        return Excel::download(new PengetahuanAkhirExport($rombelsiswa, $id, $tahun), $fileName);
    }


    public function KeterampilanPortofolioExport(Request $request)
    {
        $id = $request->input('id');

        $rombelsiswa = Rombelsiswa::join('rombels', 'rombels.id', '=', 'rombelsiswas.id_rombel')
            ->join('seksis', 'seksis.id_rombel', '=', 'rombels.id')
            ->where('seksis.id', $id)
            ->select('rombelsiswas.*')
            ->get();
        $data = $rombelsiswa->first();
        $rombel = Rombel::where('id', $data->id_rombel)->first();
        $kelas = Kelas::where('id', $rombel->id_kelas)->first();
        $jurusan = Jurusan::where('id', $kelas->id_jurusan)->first();
        $dataseksi = Seksi::where('id', $id)->first();

        $tahun = Tahunajar::where('id', $dataseksi->semester)->first();

        $fileName = 'Data Nilai Keterampilan Portofolio Siswa Kelas' . ' ' . $kelas->tingkat . $kelas->nama . $jurusan->nama . ' ' . 'Tahun Ajar ' . $tahun->tahun . ' Semester ' . $tahun->semester . '.xlsx';


        return Excel::download(new KeterampilanPortofolioExport($rombelsiswa, $id, $tahun), $fileName);
    }

    public function KeterampilanProyekExport(Request $request)
    {
        // $tahun =  $request->input('tahun');
        $id = $request->input('id');

        $rombelsiswa = Rombelsiswa::join('rombels', 'rombels.id', '=', 'rombelsiswas.id_rombel')
            ->join('seksis', 'seksis.id_rombel', '=', 'rombels.id')
            ->where('seksis.id', $id)
            ->select('rombelsiswas.*')
            ->get();
        $data = $rombelsiswa->first();
        $rombel = Rombel::where('id', $data->id_rombel)->first();
        $kelas = Kelas::where('id', $rombel->id_kelas)->first();
        $jurusan = Jurusan::where('id', $kelas->id_jurusan)->first();
        $dataseksi = Seksi::where('id', $id)->first();

        $tahun = Tahunajar::where('id', $dataseksi->semester)->first();

        $fileName = 'Data Nilai Keterampilan Proyek Siswa Kelas' . ' ' . $kelas->tingkat . $kelas->nama . $jurusan->nama . ' ' . 'Tahun Ajar ' . $tahun->tahun . ' Semester ' . $tahun->semester . '.xlsx';


        return Excel::download(new KeterampilanProyekExport($rombelsiswa, $id, $tahun), $fileName);
    }

    public function KeterampilanUnjukkerjaExport(Request $request)
    {
        // $tahun =  $request->input('tahun');
        $id = $request->input('id');

        $rombelsiswa = Rombelsiswa::join('rombels', 'rombels.id', '=', 'rombelsiswas.id_rombel')
            ->join('seksis', 'seksis.id_rombel', '=', 'rombels.id')
            ->where('seksis.id', $id)
            ->select('rombelsiswas.*')
            ->get();
        $data = $rombelsiswa->first();
        $rombel = Rombel::where('id', $data->id_rombel)->first();
        $kelas = Kelas::where('id', $rombel->id_kelas)->first();
        $jurusan = Jurusan::where('id', $kelas->id_jurusan)->first();
        $dataseksi = Seksi::where('id', $id)->first();

        $tahun = Tahunajar::where('id', $dataseksi->semester)->first();

        $fileName = 'Data Nilai Pengetahuan Unjuk Kerja Siswa Kelas' . ' ' . $kelas->tingkat . $kelas->nama . $jurusan->nama . ' ' . 'Tahun Ajar ' . $tahun->tahun . ' Semester ' . $tahun->semester . '.xlsx';


        return Excel::download(new KeterampilanUnjukkerjaExport($rombelsiswa, $id), $fileName);
    }
}
