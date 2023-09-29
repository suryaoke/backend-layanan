<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Waktu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class WaktuController extends Controller
{
    public function WaktuAll()
    {

        $waktu = Waktu::orderBy('kode_waktu', 'asc')->get();

        return view('backend.data.waktu.waktu_all', compact('waktu'));
    } // end method

    public function WaktuAdd()
    {

        return view('backend.data.waktu.waktu_add');
    } // end method
    public function WaktuStore(Request $request)
    {
        $request->validate([
            'kode_waktu' => ['required', 'string', 'max:255', 'unique:' . Waktu::class],
        ]);
        Waktu::insert([
            'kode_waktu' => $request->kode_waktu,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_akhir' => $request->waktu_akhir,
            'range'  =>  $request->waktu_mulai . " - " . $request->waktu_akhir,
            'jp' => $request->jp,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Waktu Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('waktu.all')->with($notification);
    } // end method

    public function WaktuEdit($id)
    {
        $waktu = Waktu::findOrFail($id);
        return view('backend.data.waktu.waktu_edit', compact('waktu'));
    } // end method

    public function WaktuUpdate(Request $request)
    {

        $waktu_id = $request->id;
        Waktu::findOrFail($waktu_id)->update([
            'kode_waktu' => $request->kode_waktu,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_akhir' => $request->waktu_akhir,
            'range'  =>  $request->waktu_mulai . " - " . $request->waktu_akhir,
            'jp' => $request->jp,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Waktu Updated SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('waktu.all')->with($notification);
    } // end method


    public function WaktuDelete($id)
    {
        Waktu::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Waktu Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
