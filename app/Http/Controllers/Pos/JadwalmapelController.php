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
                $lecturerQuery->where('kelas', 'LIKE', '%' .  $searchKelas . '%');
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

        // Jika validasi berhasil, simpan data ke dalam database
        Jadwalmapel::insert([
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

        Jadwalmapel::query()->update(['status' => 1]);

        $notification = array(
            'message' => 'Jadwal Berhasil Di Kirim SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // end method
}
