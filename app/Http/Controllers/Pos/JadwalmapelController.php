<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Hari;
use App\Models\Jadwalmapel;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Pengampu;
use App\Models\Ruangan;
use App\Models\Waktu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class JadwalmapelController extends Controller
{
    public function JadwalmapelAll(Request $request)
    {

        // Bagian search Data //
        $searchHari = $request->input('searchhari');
        $searchGuru = $request->input('searchguru');
        $searchMapel = $request->input('searchmapel');
        $searchKelas = $request->input('searchkelas');

        $query = Jadwalmapel::query();

        // Filter berdasarkan nama hari 
        if (!empty($searchHari)) {
            $query->whereHas('haris', function ($lecturerQuery) use ($searchHari) {
                $lecturerQuery->where('nama', 'LIKE', '%' . $searchHari . '%');
            });
        }

        // Filter berdasarkan nama guru 
        if (!empty($searchGuru)) {
            $query->whereHas('pengampus', function ($teachQuery) use ($searchGuru) {
                $teachQuery->whereHas('gurus', function ($courseQuery) use ($searchGuru) {
                    $courseQuery->where('nama', 'LIKE', '%' .   $searchGuru . '%');
                });
            });
        }

        // Filter berdasarkan nama mata Pelajaran jika searchcourse tidak kosong
        if (!empty($searchMapel)) {
            $query->whereHas('pengampus', function ($teachQuery) use ($searchMapel) {
                $teachQuery->whereHas('mapels', function ($courseQuery) use ($searchMapel) {
                    $courseQuery->where('nama', 'LIKE', '%' .   $searchMapel . '%');
                });
            });
        }

        // Filter berdasarkan nama kelas jika searchclass tidak kosong
        if (!empty($searchKelas)) {
            $query->whereHas('pengampus', function ($lecturerQuery) use ($searchKelas) {
                $lecturerQuery->whereHas('kelass', function ($courseQuery) use ($searchKelas) {
                    $courseQuery->where('id', 'LIKE', '%' .  $searchKelas . '%');
                });
            });
        }
        // End Bagian search Data //



        $jadwalmapel = $query->join('haris', 'jadwalmapels.id_hari', '=', 'haris.id')
            ->join('waktus', 'jadwalmapels.id_waktu', '=', 'waktus.id')
            ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
            ->join('kelas', 'pengampus.kelas',    '=',    'kelas.id')
            ->orderBy('kelas.tingkat', 'asc')
            ->orderBy('kelas.nama', 'asc')
            ->orderBy('haris.kode_hari', 'asc')
            ->orderBy('waktus.range', 'asc')
            ->get();

        $hari = Hari::orderby('kode_hari', 'asc')->get();

        $waktu = Waktu::all();
        $ruangan = Ruangan::all();

        $mapel = Mapel::all();

        $pengampu = Pengampu::orderby('id', 'asc')
            ->whereNotIn('id', function ($query) {
                $query->select('id_pengampu')
                    ->from('jadwalmapels');
            })
            ->get();



        $kelas = Kelas::orderBy('tingkat')->get();
        return view('backend.data.jadwalmapel.jadwalmapel_all', compact('kelas', 'pengampu', 'ruangan', 'mapel',  'hari', 'waktu',  'jadwalmapel'));
    } // end method


    public function jadwalMapelStore(Request $request)
    {
        $guruInput = Pengampu::where('id', $request->id_pengampu)->first();

        $guru = DB::table('jadwalmapels')
            ->join('pengampus', 'pengampus.id', '=', 'jadwalmapels.id_pengampu')
            ->select('pengampus.kelas', 'pengampus.id_guru')
            ->first();
        $tanggal = Carbon::now()->toDateString(); // '2023-10-17'
        $tanggal_tanpa_strip = str_replace("-", "", $tanggal); // '20231017'

        // Generate 4 random digits
        $kode_acak = mt_rand(1000, 9999);
        do {
            $kode_jadwalmapel = $tanggal_tanpa_strip . '.' . $kode_acak;
            $existingPengampu = Jadwalmapel::where('kode_jadwalmapel', $kode_jadwalmapel)->first();
        } while (!empty($existingPengampu));

        if (!$guru) {
            Jadwalmapel::insert([
                'kode_jadwalmapel' => $kode_jadwalmapel,
                'id_pengampu' => $request->id_pengampu,
                'id_hari' => $request->id_hari,
                'id_waktu' => $request->id_waktu,
                'id_ruangan' => $request->id_ruangan,
                'status' => '0',
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Jadwal Inserted Successfully kode ',
                'alert-type' => 'success'
            );
            return redirect()->route('jadwalmapel.all')->with($notification);
        }



        if ($guruInput->id_guru == $guru->id_guru || $guruInput->kelas == $guru->kelas) {
            $existingData = Jadwalmapel::where('id_hari', $request->id_hari)
                ->where('id_waktu', $request->id_waktu)
                ->count();

            if ($existingData > 0) {
                $notification = array(
                    'message' => 'Data Jadwal Mapel Bentrok..!!',
                    'alert-type' => 'warning'
                );
                return redirect()->back()->with($notification);
            } else {
                Jadwalmapel::insert([
                    'kode_jadwalmapel' => $kode_jadwalmapel,
                    'id_pengampu' => $request->id_pengampu,
                    'id_hari' => $request->id_hari,
                    'id_waktu' => $request->id_waktu,
                    'id_ruangan' => $request->id_ruangan,
                    'status' => '0',
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                ]);

                $notification = array(
                    'message' => 'Jadwal Inserted Successfully',
                    'alert-type' => 'success'
                );
                return redirect()->route('jadwalmapel.all')->with($notification);
            }
        } else {
            Jadwalmapel::insert([
                'kode_jadwalmapel' => $kode_jadwalmapel,
                'id_pengampu' => $request->id_pengampu,
                'id_hari' => $request->id_hari,
                'id_waktu' => $request->id_waktu,
                'id_ruangan' => $request->id_ruangan,
                'status' => '0',
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Jadwal Inserted Successfully kode ',
                'alert-type' => 'success'
            );
            return redirect()->route('jadwalmapel.all')->with($notification);
        }
    } // end method



    public function JadwalmapelUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'id_hari' => 'required',
            'id_waktu' => 'required',
            'id_ruangan' => 'required',
        ]);

        // Mengambil data jadwal berdasarkan $id
        $jadwalmapel = Jadwalmapel::find($id);

        // Cek untuk memastikan tidak ada bentrok jadwal saat memperbarui
        $existingData = Jadwalmapel::where('id_hari', $request->id_hari)
            ->where('id_waktu', $request->id_waktu)
            ->where('id', '!=', $id) // untuk menghindari membandingkan dengan dirinya sendiri
            ->count();

        // Jika ada bentrok, kirim notifikasi
        if ($existingData > 0) {
            $notification = array(
                'message' => 'Data Jadwal Mapel Bentrok saat Update..!!',
                'alert-type' => 'warning'
            );
            return redirect()->back()->with($notification);
        }

        // Lakukan pembaruan pada nilai kolom-kolom jadwal berdasarkan data yang diterima dari formulir
        $jadwalmapel->id_hari = $request->input('id_hari');
        $jadwalmapel->id_waktu = $request->input('id_waktu');
        $jadwalmapel->id_ruangan = $request->input('id_ruangan');
        // Tambahkan pembaruan lain sesuai kebutuhan Anda

        // Menyimpan perubahan ke dalam database
        $jadwalmapel->save();

        $notification = array(
            'message' => 'Jadwal Sementara Update SuccessFully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // end method



    public function JadwalmapelDelete($id)
    {
        Jadwalmapel::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Jadwal Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // end method

    public function JadwalmapelstatusOne($id)
    {
        $jadwalmapel = Jadwalmapel::find($id);
        $jadwalmapel->status = '1';
        $jadwalmapel->save();
        $notification = array(
            'message' => 'Jadwal Berhasil Di Kirim SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // end method



    public function JadwalmapelstatusAll()
    {

        Jadwalmapel::where('status', '=', 0)
            ->orWhere('status', '=', 3)
            ->update(['status' => 1]);


        $notification = array(
            'message' => 'Jadwal Berhasil Di Kirim SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // end method


    public function JadwalmapelKepsek(Request $request)
    {

        // Bagian search Data //
        $searchHari = $request->input('searchhari');
        $searchGuru = $request->input('searchguru');
        $searchMapel = $request->input('searchmapel');
        $searchKelas = $request->input('searchkelas');

        $query = Jadwalmapel::query();

        // Filter berdasarkan nama hari 
        if (!empty($searchHari)) {
            $query->whereHas('haris', function ($lecturerQuery) use ($searchHari) {
                $lecturerQuery->where('nama', 'LIKE', '%' . $searchHari . '%');
            });
        }

        // Filter berdasarkan nama guru 
        if (!empty($searchGuru)) {
            $query->whereHas('pengampus', function ($teachQuery) use ($searchGuru) {
                $teachQuery->whereHas('gurus', function ($courseQuery) use ($searchGuru) {
                    $courseQuery->where('nama', 'LIKE', '%' .   $searchGuru . '%');
                });
            });
        }

        // Filter berdasarkan nama mata Pelajaran jika searchcourse tidak kosong
        if (!empty($searchMapel)) {
            $query->whereHas('pengampus', function ($teachQuery) use ($searchMapel) {
                $teachQuery->whereHas('mapels', function ($courseQuery) use ($searchMapel) {
                    $courseQuery->where('nama', 'LIKE', '%' .   $searchMapel . '%');
                });
            });
        }

        // Filter berdasarkan nama kelas jika searchclass tidak kosong
        if (!empty($searchKelas)) {
            $query->whereHas('pengampus', function ($lecturerQuery) use ($searchKelas) {
                $lecturerQuery->whereHas('kelass', function ($courseQuery) use ($searchKelas) {
                    $courseQuery->where('id', 'LIKE', '%' .  $searchKelas . '%');
                });
            });
        }
        // End Bagian search Data //

        $jadwalmapel = $query->join('haris', 'jadwalmapels.id_hari', '=', 'haris.id')
            ->join('waktus', 'jadwalmapels.id_waktu', '=', 'waktus.id')
            ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
            ->join('kelas', 'pengampus.kelas', '=', 'kelas.id')
            ->where('status', '>=', 1)
            ->where('status', '<=', 3)
            ->orderBy('kelas.tingkat', 'asc')
            ->orderBy('kelas.nama', 'asc')
            ->orderBy('haris.kode_hari', 'asc')
            ->orderBy('waktus.range', 'asc')
            ->get();


        $hari = Hari::all();

        $waktu = Waktu::all();
        $ruangan = Ruangan::all();

        $mapel = Mapel::all();

        $pengampu = Pengampu::all();
        $kelas = Kelas::orderBy('tingkat')->get();
        return view('backend.data.jadwalmapel.jadwalmapel_kepsek', compact('kelas', 'pengampu', 'ruangan', 'mapel',  'hari', 'waktu',  'jadwalmapel'));
    } // end method



    public function JadwalmapelverifikasiOne($id)
    {
        $jadwalmapel = Jadwalmapel::find($id);
        $jadwalmapel->status = '2';
        $jadwalmapel->save();
        $notification = array(
            'message' => 'Jadwal Berhasil Di Verifikasi SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // end method



    public function JadwalmapelverifikasiAll()
    {

        Jadwalmapel::where('status', '=', 1)
            ->update(['status' => 2]);

        $notification = array(
            'message' => 'Jadwal Berhasil Di Verifikasi SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // end method


    public function JadwalmapeltolakOne($id)
    {
        $jadwalmapel = Jadwalmapel::find($id);
        $jadwalmapel->status = '3';
        $jadwalmapel->save();
        $notification = array(
            'message' => 'Jadwal Berhasil Di Verifikasi SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // end method


    public function JadwalmapelGuru(Request $request)
    {

        // Bagian search Data //
        $searchHari = $request->input('searchhari');
        $searchGuru = $request->input('searchguru');
        $searchMapel = $request->input('searchmapel');
        $searchKelas = $request->input('searchkelas');

        $query = Jadwalmapel::query();

        // Filter berdasarkan nama hari 
        if (!empty($searchHari)) {
            $query->whereHas('haris', function ($lecturerQuery) use ($searchHari) {
                $lecturerQuery->where('nama', 'LIKE', '%' . $searchHari . '%');
            });
        }

        // Filter berdasarkan nama guru 
        if (!empty($searchGuru)) {
            $query->whereHas('pengampus', function ($teachQuery) use ($searchGuru) {
                $teachQuery->whereHas('gurus', function ($courseQuery) use ($searchGuru) {
                    $courseQuery->where('nama', 'LIKE', '%' .   $searchGuru . '%');
                });
            });
        }

        // Filter berdasarkan nama mata Pelajaran jika searchcourse tidak kosong
        if (!empty($searchMapel)) {
            $query->whereHas('pengampus', function ($teachQuery) use ($searchMapel) {
                $teachQuery->whereHas('mapels', function ($courseQuery) use ($searchMapel) {
                    $courseQuery->where('nama', 'LIKE', '%' .   $searchMapel . '%');
                });
            });
        }

        // Filter berdasarkan nama kelas jika searchclass tidak kosong
        if (!empty($searchKelas)) {
            $query->whereHas('pengampus', function ($lecturerQuery) use ($searchKelas) {
                $lecturerQuery->whereHas('kelass', function ($courseQuery) use ($searchKelas) {
                    $courseQuery->where('id', 'LIKE', '%' .  $searchKelas . '%');
                });
            });
        }
        // End Bagian search Data //

        $userId = Auth::user()->id;

        $jadwalmapel = $query
            ->join('haris', 'jadwalmapels.id_hari', '=', 'haris.id')
            ->join('waktus', 'jadwalmapels.id_waktu', '=', 'waktus.id')
            ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
            ->join('kelas', 'pengampus.kelas', '=', 'kelas.id')
            ->join('gurus', 'pengampus.id_guru', '=', 'gurus.id')
            ->where('status', '=', '2')
            ->where('gurus.id_user', '=', $userId)
            ->orderBy('kelas.tingkat', 'asc')
            ->orderBy('kelas.nama', 'asc')
            ->orderBy('haris.kode_hari', 'asc')
            ->orderBy('waktus.range', 'asc')
            ->get();



        $kelas = Kelas::orderBy('tingkat')->get();
        return view('backend.data.jadwalmapel.jadwalmapel_guru', compact('kelas', 'jadwalmapel'));
    } // end method


    public function JadwalmapelSiswa(Request $request)
    {

        // Bagian search Data //
        $searchHari = $request->input('searchhari');
        $searchGuru = $request->input('searchguru');
        $searchMapel = $request->input('searchmapel');


        $query = Jadwalmapel::query();

        // Filter berdasarkan nama hari 
        if (!empty($searchHari)) {
            $query->whereHas('haris', function ($lecturerQuery) use ($searchHari) {
                $lecturerQuery->where('nama', 'LIKE', '%' . $searchHari . '%');
            });
        }

        // Filter berdasarkan nama guru 
        if (!empty($searchGuru)) {
            $query->whereHas('pengampus', function ($teachQuery) use ($searchGuru) {
                $teachQuery->whereHas('gurus', function ($courseQuery) use ($searchGuru) {
                    $courseQuery->where('nama', 'LIKE', '%' .   $searchGuru . '%');
                });
            });
        }

        // Filter berdasarkan nama mata Pelajaran jika searchcourse tidak kosong
        if (!empty($searchMapel)) {
            $query->whereHas('pengampus', function ($teachQuery) use ($searchMapel) {
                $teachQuery->whereHas('mapels', function ($courseQuery) use ($searchMapel) {
                    $courseQuery->where('nama', 'LIKE', '%' .   $searchMapel . '%');
                });
            });
        }


        // End Bagian search Data //

        $userId = Auth::user()->id;

        $jadwalmapel = $query
            ->join('waktus', 'jadwalmapels.id_waktu', '=', 'waktus.id')
            ->join('haris', 'jadwalmapels.id_hari', '=', 'haris.id')
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
            ->orderBy('waktus.range', 'asc')
            ->get();



        $kelas = Kelas::orderBy('tingkat')->get();
        return view('backend.data.jadwalmapel.jadwalmapel_siswa', compact('kelas', 'jadwalmapel'));
    } // end method

}
