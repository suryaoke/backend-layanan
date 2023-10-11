<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Walas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalasController extends Controller
{
    public function WalasAll()
    {

        $walas = Walas::orderBy('id_kelas', 'asc')->get();

        return view('backend.data.walas.walas_all', compact('walas'));
    } // end method

    public function WalasAdd()
    {

        $guru = Guru::orderBy('kode_gr', 'asc')->get();
        $kelas = Kelas::orderBy('nama', 'asc')->get();

        return view('backend.data.walas.walas_add', compact('guru', 'kelas'));
    } // end method
    public function WalasStore(Request $request)
    {
        $request->validate([
            'id_guru' => ['required', 'string', 'max:255', 'unique:' . Walas::class],
        ]);
        Walas::insert([
            'id_guru' => $request->id_guru,
            'id_kelas' => $request->id_kelas,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Walas Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('walas.all')->with($notification);
    } // end method

    public function WalasEdit($id)
    {
        $walas = Walas::findOrFail($id);

        $guru = Guru::orderBy('kode_gr', 'asc')->get();
        $kelas = Kelas::orderBy('nama', 'asc')->get();
        return view('backend.data.walas.walas_edit', compact('walas', 'guru', 'kelas'));
    } // end method

    public function WalasUpdate(Request $request)
    {

        $walas_id = $request->id;
        Walas::findOrFail($walas_id)->update([
            'id_guru' => $request->id_guru,
            'id_kelas' => $request->id_kelas,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Walas Updated SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('walas.all')->with($notification);
    } // end method


    public function WalasDelete($id)
    {
        Walas::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Walas Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
