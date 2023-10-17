<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Seksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeksiController extends Controller
{
    public function SeksiAll()
    {

        $seksi = Seksi::orderBy('id', 'asc')->get();

  


        return view('backend.data.seksi.seksi_all', compact('seksi'));
    } // end method

    public function SeksiAdd()
    {

        $guru = Guru::orderBy('kode_gr', 'asc')->get();
        $kelas = Kelas::orderBy('nama', 'asc')->get();

        return view('backend.data.seksi.seksi_add', compact('guru', 'kelas'));
    } // end method
    public function SeksiStore(Request $request)
    {
        $request->validate([
            'id_guru' => ['required', 'string', 'max:255', 'unique:' . Seksi::class],
            'id_kelas' => ['required', 'string', 'max:255', 'unique:' . Seksi::class],
        ]);
        Seksi::insert([
            'id_guru' => $request->id_guru,
            'id_kelas' => $request->id_kelas,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

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
        return view('backend.data.seksi.seksi_edit', compact('seksi', 'guru', 'kelas'));
    } // end method

    public function SeksiUpdate(Request $request)
    {

        $seksi_id = $request->id;
        Seksi::findOrFail($seksi_id)->update([
            'id_guru' => $request->id_guru,
            'id_kelas' => $request->id_kelas,
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
        Seksi::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Seksi Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
