<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Guru;
use App\Models\Jadwalmapel;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Pengampu;
use App\Models\Rombel;
use App\Models\Rombelsiswa;
use App\Models\Seksi;
use App\Models\Siswa;
use App\Models\Walas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AbsensiController extends Controller
{
    public function AbsensiAll(Request $request)
    {

        // Bagian search Data //
        $searchHari = $request->input('searchhari');
        $searchMapel = $request->input('searchmapel');
        $searchKelas = $request->input('searchkelas');


        $query = Absensi::query();

        // Filter berdasarkan nama hari
        if (!empty($searchHari)) {
            $query->where('tanggal', '=', $searchHari);
        }

        // Filter berdasarkan nama mata Pelajaran jika searchcourse tidak kosong
        if (!empty($searchMapel)) {
            $query->whereHas('jadwalss', function ($lecturerQuery) use ($searchMapel) {
                $lecturerQuery->whereHas('pengampus', function ($lecturerQuery1) use ($searchMapel) {
                    $lecturerQuery1->whereHas('mapels', function ($courseQuery) use ($searchMapel) {
                        $courseQuery->where('nama', 'LIKE', '%' . $searchMapel . '%');
                    });
                });
            });
        }

        // Filter berdasarkan nama kelas jika searchclass tidak kosong
        if (!empty($searchKelas)) {
            $query->whereHas('jadwalss', function ($lecturerQuery) use ($searchKelas) {
                $lecturerQuery->whereHas('pengampus', function ($lecturerQuery1) use ($searchKelas) {
                    $lecturerQuery1->whereHas('kelass', function ($courseQuery) use ($searchKelas) {
                        $courseQuery->where('id', 'LIKE', '%' . $searchKelas . '%');
                    });
                });
            });
        }
        // End Bagian search Data //


        $userId = Auth::user()->id;
        $absensi = $query->join('jadwalmapels', 'absensis.id_jadwal', '=', 'jadwalmapels.id')
            ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
            ->join('gurus', 'pengampus.id_guru', '=', 'gurus.id')
            ->join('users', 'gurus.id_user', '=', 'users.id')
            ->where('users.id', $userId)
            ->select('absensis.*')
            ->orderby('id','desc')
            ->orderByRaw("STR_TO_DATE(tanggal, '%d/%m/%Y') DESC")
            ->get();


        $siswa1 = Siswa::latest()->get();
        $kelas = Kelas::orderBy('tingkat')->get();

        return view('backend.data.absensi.absensi_all', compact('kelas', 'absensi', 'siswa1',));
    } // end method

    public function AbsensiAdd()
    {

        $kelas = Kelas::orderBy('nama', 'asc')->get();
        // Mendapatkan ID pengguna yang saat ini aktif
        $userId = Auth::user()->id;


        $seksi = Seksi::join('jadwalmapels', 'seksis.id_jadwal', '=', 'jadwalmapels.id')
            ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
            ->join('gurus', 'pengampus.id_guru', '=', 'gurus.id')
            ->join('users', 'gurus.id_user', '=', 'users.id')
            ->where('users.id', $userId)
            ->where('jadwalmapels.status', 2)
            ->select('seksis.*')
            ->get();


        return view('backend.data.absensi.absensi_add', compact('seksi',  'kelas'));
    } // end method


    public function AbsensiStore(Request $request)
    {


        $search = $request->search;
        $rombelsiswa = Rombelsiswa::where('id_rombel', $search)->get();
  
        $absensi = Absensi::first();

        foreach ($rombelsiswa as $row) {

            $existingAbsensi = Absensi::where([
                'tanggal' => $request->input('tanggal'),
                'id_jadwal' => $request->input('id_jadwal'),
                'id_siswa' => $row->id_siswa
            ])->first();
            if (!$existingAbsensi) {
                $absensi = new Absensi();
                $absensi->id_siswa = $row->id_siswa;
                $absensi->tanggal = $request->tanggal;
                $absensi->status = $request->status;
                $absensi->ket = $request->ket;
                $absensi->id_jadwal = $request->id_jadwal;
                $absensi->created_by = Auth::user()->id;
                $absensi->created_at = Carbon::now();
                $absensi->save();
            } else {
                $notification = array(
                    'message' => ' Data kombinasi Absensi Tersebut Sudah Ada',
                    'alert-type' => 'warning'
                );
                return redirect()->back()->with($notification);
            }
        }

        $notification = array(
            'message' => ' Data Absensi SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('absensi.siswa', [
            'tanggal' => $request->tanggal,
            'kelas' => Rombel::find($request->search)->kelass->id,
            'mapel' => Jadwalmapel::find($request->id_jadwal)->pengampus->mapels->nama,


        ])->with($notification);
    }

    public function searchAbsensi(Request $request)
    {
        $search = $request->search;

        $absensi = Absensi::where(function ($query) use ($search) {
            $query->where('tanggal', 'like', "%$search");

            $query->where('siswa', 'like', "%$search");
        })->orderBy('nama', 'asc')->paginate(perPage: 50);


        $kelas = Kelas::orderBy('nama')->get();



        return view('backend.data.siswa.siswa_all', compact('siswa', 'search', 'kelas'));
    }

    public function AbsensiSiswa(Request $request)
    {
        // $absensi = Absensi::latest()->get();
        $todayDate = Carbon::now()->format('d/m/Y');
        $kelas = Kelas::first();

        $query =
            Absensi::when(
                $request->tanggal != null,
                function ($q) use ($request) {
                    return $q->where('tanggal', $request->tanggal);
                },
                function ($q) use ($todayDate) {
                    return $q->where('tanggal', $todayDate);
                }
            )
            ->when($request->mapel != null, function ($q) use ($request) {

                return $q->whereHas('jadwalss', function ($subQ) use ($request) {
                    return $subQ->whereHas('pengampus', function ($subQ1) use ($request) {
                        return $subQ1->whereHas('mapels', function ($subQ2) use ($request) {
                            $subQ2->where('nama', $request->mapel);
                        });
                    });
                });
            })

            ->when($request->kelas != null, function ($q) use ($request) {
                return $q->whereHas('jadwalss', function ($subQ) use ($request) {
                    return $subQ->whereHas('pengampus', function ($subQ1) use ($request) {
                        return $subQ1->whereHas('kelass', function ($subQ2) use ($request) {
                            $subQ2->where('id', $request->kelas);
                        });
                    });
                });
            });



        $userId = Auth::user()->id;
        $absensi = $query->join('jadwalmapels', 'absensis.id_jadwal', '=', 'jadwalmapels.id')
            ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
            ->join('gurus', 'pengampus.id_guru', '=', 'gurus.id')
            ->join('users', 'gurus.id_user', '=', 'users.id')
            ->where('users.id', $userId)
            ->select('absensis.*')
            ->orderByRaw("STR_TO_DATE(tanggal, '%d/%m/%Y') DESC")
            ->paginate(perPage: 50);


        $siswa1 = Siswa::latest()->get();
        $kelas = Kelas::orderBy('nama', 'asc')->get();
        return view('backend.data.absensi.absensi_siswa', compact('absensi', 'siswa1', 'kelas'));
    } //end method

    public function AbsensiSiswaStore(Request $request)
    {

        $ketData = $request->input('ket');
        $statusData = $request->input('status');

        foreach ($ketData as $absensiId => $keterangan) {
            $absensi = Absensi::find($absensiId);

            if ($absensi) {
                $absensi->update([
                    'ket' => $keterangan,
                    'status' => $statusData[$absensiId],
                ]);
            }
        }

        $notification = array(
            'message' => 'Absensi Siswa SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } //end method


    public function AbsensiDelete($id)
    {
        Absensi::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Absensi Siswa Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function AbsensiSiswaGuruWalas()
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

                        // $absensi = Absensi::join('siswas', 'absensis.id_siswa', '=', 'siswas.id')
                        // ->whereIn('absensis.id_siswa', $siswaIds)
                        // ->orderBy('absensis.id', 'desc')
                        // ->orderBy('siswas.nama', 'asc')
                        // ->get();
                    }
                }
            }
        }

        $data = [
            'walas' => $walas,
            'siswa' => $siswa,
        ];

        return view('backend.data.absensi.absensi_guruwalas', compact('rombel','absensi', 'data', 'walas', 'siswa'));
    }

}
