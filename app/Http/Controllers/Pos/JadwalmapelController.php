<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Hari;
use App\Models\Jadwalmapel;
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
                    $courseQuery->where('nama', 'LIKE', '%' .  $searchKelas . '%');
                });
            });
        }
        // End Bagian search Data //


        $jadwalmapel = $query->orderBy('id_hari', 'asc')
            ->orderBy('id_waktu', 'asc')
            ->get();
        $hari = Hari::all();

        $waktu = Waktu::all();
        $ruangan = Ruangan::all();

        $mapel = Mapel::all();

        $pengampu = Pengampu::all();
        return view('backend.data.jadwalmapel.jadwalmapel_all', compact('pengampu', 'ruangan', 'mapel',  'hari', 'waktu',  'jadwalmapel'));
    } // end method


    public function JadwalmapelStore(Request $request)
    {
        // Membuat validasi
        $validator = Validator::make($request->all(), [
            'id_pengampu' => 'required',

        ], ['id_pengampu.required' => 'Jadwal Gagal Dibuat Kode Pengampu Kosong.',]);

        // Jika validasi gagal, kembali ke halaman sebelumnya 
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        // Dapatkan kode_gr dari guru yang sesuai dengan id_guru yang diambil dari $request
        $pengampu = Pengampu::find($request->id_pengampu);

        // Ambil kode_gr dari guru
        $kode_jadwal = $pengampu->kode_pengampu;

        // Menghasilkan 6 karakter acak yang terdiri dari huruf besar, huruf kecil, dan angka
        $kode_acak = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 3);

        // Gabungkan kode_gr dengan kode_acak untuk mendapatkan kode_pengampu
        $kode_jadwalmapel = $kode_jadwal . '.' . $kode_acak;


        // Jika validasi berhasil, simpan data ke dalam database
        Jadwalmapel::insert([
            'kode_jadwalmapel' =>  $kode_jadwalmapel,
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



    public function JadwalmapelUpdate(Request $request, $id)
    {

        $this->validate($request, [
            'id_hari' => 'required',
            'id_waktu' => 'required',
            'id_ruangan' => 'required',

        ]);

        // Mengambil data jadwal berdasarkan $id
        $jadwalmapel = Jadwalmapel::find($id);

        // Mengupdate nilai kolom-kolom jadwal berdasarkan data yang diterima dari formulir
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
                    $courseQuery->where('nama', 'LIKE', '%' .  $searchKelas . '%');
                });
            });
        }
        // End Bagian search Data //


        $jadwalmapel = $query->orderBy('id_hari', 'asc')
            ->orderBy('id_waktu', 'asc')
            ->whereIn('status', [1, 2, 3])
            ->get();
        $hari = Hari::all();

        $waktu = Waktu::all();
        $ruangan = Ruangan::all();

        $mapel = Mapel::all();

        $pengampu = Pengampu::all();
        return view('backend.data.jadwalmapel.jadwalmapel_kepsek', compact('pengampu', 'ruangan', 'mapel',  'hari', 'waktu',  'jadwalmapel'));
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
                    $courseQuery->where('nama', 'LIKE', '%' .  $searchKelas . '%');
                });
            });
        }
        // End Bagian search Data //

        $userId = Auth::user()->id;

        $jadwalmapel = $query
            ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
            ->join('gurus', 'pengampus.id_guru', '=', 'gurus.id')
            ->where('status', '=', '2')
            ->where('gurus.id_user', '=', $userId)
            ->orderBy('id_hari', 'asc')
            ->orderBy('id_waktu', 'asc')
            ->get();
        return view('backend.data.jadwalmapel.jadwalmapel_guru', compact('jadwalmapel'));
    } // end method


}
