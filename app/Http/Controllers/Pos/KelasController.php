<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{
    public function KelasAll()
    {

        $kelas = Kelas::orderBy('tingkat', 'asc')->get();

        return view('backend.data.kelas.kelas_all', compact('kelas'));
    } // end method

    public function KelasAdd()
    {
        $jurusan = Jurusan::orderBy('kode_jurusan', 'asc')->get();
        return view('backend.data.kelas.kelas_add', compact('jurusan'));
    } // end method
    public function KelasStore(Request $request)
    {
        // $request->validate([
        //     'nama' => ['required', 'string', 'max:255', 'unique:' . Kelas::class],

        // ]);
        Kelas::insert([
            'nama' => $request->nama,
            'id_jurusan' => $request->id_jurusan,
            'tingkat' => $request->tingkat,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Kelas Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('kelas.all')->with($notification);
    }

    public function KelasEdit($id)
    {
        $kelas = Kelas::findOrFail($id);
        $jurusan = Jurusan::orderBy('kode_jurusan', 'asc')->get();
        return view('backend.data.kelas.kelas_edit', compact('kelas', 'jurusan'));
    }
    public function KelasUpdate(Request $request)
    {

        $kelas_id = $request->id;
        Kelas::findOrFail($kelas_id)->update([
            'nama' => $request->nama,
            'id_jurusan' => $request->id_jurusan,
            'tingkat' => $request->tingkat,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Kelas Updated SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('kelas.all')->with($notification);
    }

    public function KelasDelete($id)
    {
        Kelas::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Kelas Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
