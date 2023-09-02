<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KelasController extends Controller
{
    public function KelasAll()
    {

        $kelas = Kelas::orderBy('nama', 'asc')->get();

        return view('backend.data.kelas.kelas_all', compact('kelas'));
    } // end method

    public function KelasAdd()
    {

        return view('backend.data.kelas.kelas_add');
    } // end method
    public function KelasStore(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:' . Kelas::class],

        ]);
        Kelas::insert([
            'nama' => $request->nama,
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
        return view('backend.data.kelas.kelas_edit', compact('kelas'));
    }
    public function KelasUpdate(Request $request)
    {

        $kelas_id = $request->id;
        Kelas::findOrFail($kelas_id)->update([
            'nama' => $request->nama,
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
