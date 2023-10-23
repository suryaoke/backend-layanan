<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Cttnwalas;
use App\Models\Guru;
use App\Models\Rombel;
use App\Models\Rombelsiswa;
use App\Models\Siswa;
use App\Models\Tahunajar;
use App\Models\Walas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CttnwalasController extends Controller
{

    public function CttnwalasAll()
    {
        $user_id = Auth::user()->id;
        $guru = Guru::where('id_user', $user_id)->first();
        $tahunajar = Tahunajar::all();

        $walas1 = Walas::where('id_guru', $guru->id)->orderBy('id', 'asc')->first();
        $siswa = null;
        $walas = null;
        if ($guru) {
            $walas = Walas::where('id_guru', $guru->id)->orderBy('id', 'asc')->first();
            if ($walas) {
                $rombel = Rombel::where('id_walas', $walas->id)->first();
                if ($rombel) {
                    $rombelSiswa = Rombelsiswa::where('id_rombel', $rombel->id)->get();
                    if ($rombelSiswa->isNotEmpty()) {
                        $siswaIds = $rombelSiswa->pluck('id_siswa')->unique()->toArray();
                        $siswa = Siswa::whereIn('id', $siswaIds)->get();
                    }
                }
            }
        }

        $data = [
            'walas' => $walas,
            'siswa' => $siswa,
        ];

        return view('backend.data.cttnwalas.cttnwalas_all', compact('tahunajar', 'data', 'walas1', 'walas', 'siswa'));
    }


    public function CttnwalasStore(Request $request)
    {

        Cttnwalas::insert([
            'id_walas' => $request->id_walas,
            'ket' => $request->ket,
            'id_rombelsiswa' => $request->id_rombelsiswa,
            'tahunajar' => $request->tahunajar,
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
            'id_walas' => $request->id_walas ,
            'id_rombelsiswa' => $request->id_rombelsiswa,
            'ket' => $request->ket,
            'tahunajar' => $request->tahunajar,
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
