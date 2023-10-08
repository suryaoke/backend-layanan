<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Mapel;
use App\Models\Pengampu;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengampuController extends Controller
{
    public function PengampuAll()
    {

        //$suppliers = Supplier::all();
        $pengampu = Pengampu::latest()->get();

        return view('backend.data.pengampu.pengampu_all', compact('pengampu'));
    } // end method

    public function PengampuAdd()
    {
        $guru = Guru::whereIn('id_user', function ($query) {
            $query->select('id')
                ->from('users')
                ->where('role', 4);
        })
            ->orWhere('id_user', 0)
            ->orderBy('kode_gr', 'asc')->get();

        $mapel = Mapel::orderBy('kode_mapel', 'asc')->get();
        return view('backend.data.pengampu.pengampu_add', compact('mapel', 'guru'));
    } // end method
    public function PengampuStore(Request $request)
    {

        // Dapatkan kode_gr dari guru yang sesuai dengan id_guru yang diambil dari $request
        $guru = Guru::find($request->id_guru);

        if (!$guru) {
            // Handle kasus jika guru tidak ditemukan
        }

        $kode_gr = $guru->kode_gr;

        // Buat kode_pengampu dengan format "P" + kode_gr + informasi lainnya
        $uniq_id = substr(
            uniqid(),
            0,
            4
        ); // Ambil 4 karakter pertama dari uniqid()
        $kode_pengampu = 'P' . $kode_gr .  '-' . $uniq_id;
        // Kemudian, gunakan kode_pengampu ini saat Anda menyisipkan data ke dalam tabel Pengampu
        Pengampu::insert([
            'kode_pengampu' => $kode_pengampu,
            'id_guru' => $request->id_guru,
            'id_mapel' => $request->id_mapel,
            'kelas' => $request->kelas,
            'kurikulum' => $request->kurikulum,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Pengampu Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('pengampu.all')->with($notification);
    }

    public function PengampuEdit($id)
    {
        $pengampu = Pengampu::findOrFail($id);
        $guru = Guru::whereIn('id_user', function ($query) {
            $query->select('id')
                ->from('users')
                ->where('role', 2);
        })->orderBy('kode_gr', 'asc')->get();

        $mapel = Mapel::orderBy('kode_mapel', 'asc')->get();
        return view('backend.data.pengampu.pengampu_edit', compact('pengampu', 'mapel', 'guru'));
    }
    public function PengampuUpdate(Request $request)
    {

        $pengampu_id = $request->id;
        Pengampu::findOrFail($pengampu_id)->update([
            'id_guru' => $request->id_guru,
            'id_mapel' => $request->id_mapel,
            'kelas' => $request->kelas,
            'kurikulum' => $request->kurikulum,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Pengampu Updated SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('pengampu.all')->with($notification);
    }

    public function PengampuDelete($id)
    {
        Pengampu::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Pengampu Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
