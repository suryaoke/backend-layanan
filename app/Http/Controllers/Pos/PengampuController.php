<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Pengampu;
use App\Models\Siswa;
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
        $kelas = Kelas::orderBy('nama')->get();

        $guru = Guru::whereIn('id_user', function ($query) {
            $query->select('id')
                ->from('users')
                ->where('role', 4);
        })
            ->orWhere('id_user', 0)
            ->orderBy('kode_gr', 'asc')->get();

        $mapel = Mapel::orderBy('kode_mapel', 'asc')->get();
        return view('backend.data.pengampu.pengampu_add', compact('kelas', 'mapel', 'guru'));
    } // end method
    public function PengampuStore(Request $request)
    {
        // Dapatkan kode_gr dari guru yang sesuai dengan id_guru yang diambil dari $request
        $guru = Guru::find($request->id_guru);
        $mapel = Mapel::find($request->id_mapel);
        // Ambil kode_gr dari guru
        $kode_gr = $guru->kode_gr;
        $kode_mapel = $mapel->kode_mapel;

        // Menghasilkan 6 karakter acak yang terdiri dari huruf besar, huruf kecil, dan angka
        $kode_acak = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 3);

        // Gabungkan kode_gr dengan kode_acak untuk mendapatkan kode_pengampu
        $kode_pengampu = $kode_gr . '.' . $kode_mapel . '.' . $kode_acak;

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
            'message' => 'Pengampu Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('pengampu.all')->with($notification);
    }



    public function PengampuEdit($id)
    {
        $kelas = Kelas::orderBy('nama')->get();
        $pengampu = Pengampu::findOrFail($id);
        $guru = Guru::whereIn('id_user', function ($query) {
            $query->select('id')
                ->from('users')
                ->where('role', 4);
        })->orderBy('kode_gr', 'asc')->get();

        $mapel = Mapel::orderBy('kode_mapel', 'asc')->get();
        return view('backend.data.pengampu.pengampu_edit', compact('kelas', 'pengampu', 'mapel', 'guru'));
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
