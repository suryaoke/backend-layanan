<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Cttnwalas;
use App\Models\Guru;
use App\Models\Siswa;
use App\Models\Walas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CttnwalasController extends Controller
{
    public function CttnwalasAll()
    {

        $cttnwalas = Cttnwalas::orderBy('id', 'asc')->get();
        $guruId = Guru::where('id_user', Auth::user()->id)->first();
        $walas = Walas::where('id_guru', $guruId->id)->orderBy('id', 'asc')->first();
        $siswa = null; // inisialisasi variabel $siswa
        if ($walas) {
            $siswa = Siswa::where('kelas', $walas->id_kelas)->orderBy('id', 'asc')->get();
        }

        $data = [
            'walas' => $walas,
            'siswa' => $siswa,
        ];
        return view('backend.data.cttnwalas.cttnwalas_all', compact('walas', 'data', 'cttnwalas', 'siswa'));
    } // end method


    public function CttnwalasStore(Request $request)
    {

        Cttnwalas::insert([
            'id_walas' => $request->id_walas,
            'id_siswa' => $request->id_siswa,
            'ket' => $request->ket,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Cttnwalas Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('cttnwalas.all')->with($notification);
    } // end method


    public function CttnwalasUpdate(Request $request)
    {

        $cttnwalas_id = $request->id;
        Cttnwalas::findOrFail($cttnwalas_id)->update([
            'id_walas' => $request->id_walas,
            'id_siswa' => $request->id_siswa,
            'ket' => $request->ket,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Cttnwalas Updated SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('cttnwalas.all')->with($notification);
    } // end method

}
