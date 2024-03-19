<?php

namespace App\Http\Controllers\Pos;

use App\Exports\SeksiExport;
use App\Http\Controllers\Controller;
use App\Models\CatataWalas;
use App\Models\Guru;
use App\Models\Jadwalmapel;
use App\Models\Kd3;
use App\Models\Kd4;
use App\Models\Kelas;
use App\Models\Ki3;
use App\Models\Ki4;
use App\Models\NilaiKd3;
use App\Models\NilaiKd4;
use App\Models\NilaisiswaKd3;
use App\Models\NilaisiswaKd4;
use App\Models\Pengampu;
use App\Models\Rapor;
use App\Models\Rombel;
use App\Models\Rombelsiswa;
use App\Models\Seksi;
use App\Models\Tahunajar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use PhpParser\Node\Stmt\Else_;

class SeksiController extends Controller
{
    public function SeksiAll(Request $request)
    {

        $searchSeksi = $request->input('searchseksi');
        $searchGuru = $request->input('searchguru');
        $searchMapel = $request->input('searchmapel');
        $searchKelas = $request->input('searchkelas');
        $searchTahun = $request->input('searchtahun');

        $query = Seksi::query();


        // Filter berdasarkan nama hari 
        if (!empty($searchSeksi)) {
            $query->where('kode_seksi', '=', $searchSeksi);
        }

        // Filter berdasarkan nama guru 

        if (!empty($searchGuru)) {
            $query->whereHas('jadwalmapels', function ($teachQuery) use ($searchGuru) {
                $teachQuery->whereHas('pengampus', function ($courseQuery) use ($searchGuru) {

                    $courseQuery->whereHas('gurus', function ($course1Query) use ($searchGuru) {

                        $course1Query->where('nama', 'LIKE', '%' .   $searchGuru . '%');
                    });
                });
            });
        }


        // Filter berdasarkan nama mata Pelajaran jika searchcourse tidak kosong
        if (!empty($searchMapel)) {
            $query->whereHas('jadwalmapels', function ($teachQuery) use ($searchMapel) {
                $teachQuery->whereHas('pengampus', function ($courseQuery) use ($searchMapel) {

                    $courseQuery->whereHas('mapels', function ($course1Query) use ($searchMapel) {

                        $course1Query->where('nama', 'LIKE', '%' .   $searchMapel . '%');
                    });
                });
            });
        }



        // Filter berdasarkan nama kelas jika searchclass tidak kosong
        if (!empty($searchKelas)) {
            $query->whereHas('rombels', function ($lecturerQuery) use ($searchKelas) {
                $lecturerQuery->whereHas('kelass', function ($courseQuery) use ($searchKelas) {
                    $courseQuery->where('id', 'LIKE', '%' .  $searchKelas . '%');
                });
            });
        }

        if (!empty($searchTahun)) {
            $query->whereHas('semesters', function ($lecturerQuery) use ($searchTahun) {
                $lecturerQuery->where('id', 'LIKE', '%' . $searchTahun . '%');
            });
        }
        // End Bagian search Data //



        $seksi = $query->orderBy('id', 'asc')->get();

        $datatahun = Tahunajar::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('seksis')
                ->whereRaw('seksis.semester = tahunajars.id');
        })->orderby('id', 'desc')
            ->get();



        $kelas = Kelas::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('rombels')
                ->join('seksis', 'seksis.id_rombel', '=', 'rombels.id')
                ->whereRaw('rombels.id_kelas = kelas.id');
        })->orderBy('id', 'desc')
            ->get();


        return view('backend.data.seksi.seksi_all', compact('kelas', 'seksi', 'datatahun'));
    } // end method

    public function SeksiAdd()
    {



        $semester = Tahunajar::orderBy('tahun', 'asc')->get();
        $rombel = Rombel::orderBy('id', 'asc')->get();



        return view('backend.data.seksi.seksi_add', compact('rombel', 'semester'));
    } // end method


    public function SeksiStore(Request $request)
    {

        $semester = $request->semester;
        $id_rombel = $request->id_rombel;

        // Pastikan tidak ada kombinasi yang sama dari semester, id_rombel, dan id_jadwal
        // $existingSeksi = Seksi::where('semester', $semester)
        //     ->where('id_rombel', $id_rombel)

        //     ->first();

        // if ($existingSeksi) {
        //     $notification = array(
        //         'message' => 'Kombinasi data seksi sudah ada..!!',
        //         'alert-type' => 'warning'
        //     );
        //     return redirect()->back()->with($notification);
        // }


        $tanggal = Carbon::now()->toDateString(); // '2023-10-17'
        $tanggal_tanpa_strip = str_replace("-", "", $tanggal); // '20231017'
        // Menghasilkan 6 karakter acak yang terdiri dari huruf besar, huruf kecil, dan angka
        $kode_acak = substr(str_shuffle('0123456789'), 0, 4);
        $kode_seksi = $tanggal_tanpa_strip . '.' . $kode_acak;
        $rombel = Rombel::where('id', $request->id_rombel)->first();


        $jadwal = Jadwalmapel::join(
            'pengampus',
            'pengampus.id',
            '=',
            'jadwalmapels.id_pengampu',
        )
            ->join('rombels', 'rombels.id_kelas', '=', 'pengampus.kelas')
            ->where('rombels.id', $rombel->id)
            ->where('id_tahunajar', $rombel->id_tahunjar)
            ->where('status', '2')
            ->select('jadwalmapels.*')
            ->whereNotExists(function ($query) {
                $query
                    ->select(DB::raw(1))
                    ->from('seksis')
                    ->whereRaw('seksis.id_jadwal = jadwalmapels.id');
            })
            ->get();




        foreach ($jadwal as $jadwals) {


            Seksi::insert([
                'semester' => $request->semester,
                'id_rombel' => $request->id_rombel,
                'kode_seksi' => $kode_seksi,
                'id_jadwal' => $jadwals->id,
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),
            ]);
        }



        $notification = array(
            'message' => 'Seksi Inserted SuccessFully',
            'alert-type' => 'success'
        );



        return redirect()->route('seksi.all')->with($notification);
    } // end method


    public function SeksiEdit($id)
    {
        $seksi = Seksi::findOrFail($id);

        $guru = Guru::orderBy('kode_gr', 'asc')->get();
        $kelas = Kelas::orderBy('nama', 'asc')->get();
        $semester = Tahunajar::orderBy('tahun', 'asc')->get();
        $rombel = Rombel::orderBy('id', 'asc')->get();
        $rombel1 = Rombel::orderBy('id', 'asc')->first();
        $pengampus = Pengampu::where('kelas', $rombel1->id_kelas)->first();
        $jadwalmapel = Jadwalmapel::where('id_pengampu', $pengampus->id)->orderBy('id', 'asc')->get();
        return view('backend.data.seksi.seksi_edit', compact('semester', 'rombel', 'jadwalmapel', 'seksi', 'guru', 'kelas'));
    } // end method

    public function SeksiUpdate(Request $request)
    {
        $seksi_id = $request->id;
        Seksi::findOrFail($seksi_id)->update([
            'semester' => $request->semester,
            'id_rombel' => $request->id_rombel,
            'id_jadwal' => $request->id_jadwal,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Seksi Updated SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('seksi.all')->with($notification);
    } // end method


    public function SeksiDelete($id)
    {
        $seksi = Seksi::find($id);

        if (!$seksi) {
            $notification = array(
                'message' => 'Seksi not found',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }



        // Delete related entries
        $seksi->delete();

        $notification = array(
            'message' => 'Seksi Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function SeksiExport(Request $request)
    {
        $tahun =  $request->input('tahun');

        $seksi = Seksi::orderBy('id')
            ->where('semester', $tahun)
            ->get();
        $dataseksi = $seksi->first();
        $tahundata = Tahunajar::where('id', $tahun)->first();

        $fileName = 'Data Seksi' . ' ' . 'Tahun Ajar' . ' ' . $tahundata->tahun . ' Semester ' . $tahundata->semester . '.xlsx';


        return Excel::download(new SeksiExport($seksi, $dataseksi), $fileName);
    }
}
