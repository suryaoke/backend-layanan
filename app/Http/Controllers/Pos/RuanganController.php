<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Ruangan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RuanganController extends Controller
{
    public function RuanganAll()
    {

        $ruangan = Ruangan::orderBy('kode_ruangan', 'asc')->get();

        return view('backend.data.ruangan.ruangan_all', compact('ruangan'));
    } // end method

    public function RuanganAdd()
    {
        $jurusan = Jurusan::orderBy('kode_jurusan', 'asc')->get();

        return view('backend.data.ruangan.ruangan_add', compact('jurusan'));
    } // end method
    public function RuanganStore(Request $request)
    {
        $request->validate([
            'kode_ruangan' => ['required', 'string', 'max:255', 'unique:' . Ruangan::class],
        ]);
        Ruangan::insert([
            'kode_ruangan' => $request->kode_ruangan,
            'nama' => $request->nama,
            'kapasitas' => $request->kapasitas,
            'id_jurusan'  =>  $request->id_jurusan,
            'type' => $request->type,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Ruangan Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('ruangan.all')->with($notification);
    } // end method

    public function RuanganEdit($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $jurusan = Jurusan::orderBy('kode_jurusan', 'asc')->get();
        return view('backend.data.ruangan.ruangan_edit', compact('ruangan','jurusan'));
    } // end method

    public function RuanganUpdate(Request $request)
    {

        $ruangan_id = $request->id;
        Ruangan::findOrFail($ruangan_id)->update([
            'kode_ruangan' => $request->kode_ruangan,
            'nama' => $request->nama,
            'kapasitas' => $request->kapasitas,
            'id_jurusan'  =>  $request->id_jurusan,
            'type' => $request->type,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Ruangan Updated SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('ruangan.all')->with($notification);
    } // end method


    public function RuanganDelete($id)
    {
        Ruangan::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Ruangan Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
