<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Hari;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HariController extends Controller
{
    public function HariAll()
    {

        $hari = Hari::orderBy('kode_hari', 'asc')->get();

        return view('backend.data.hari.hari_all', compact('hari'));
    } // end method

    public function HariAdd()
    {

        return view('backend.data.hari.hari_add');
    } // end method
    public function HariStore(Request $request)
    {
        $request->validate([
            'kode_hari' => ['required', 'string', 'max:255', 'unique:' . Hari::class],
        ]);
        Hari::insert([
            'kode_hari' => $request->kode_hari,
            'nama' => $request->nama,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Hari Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('hari.all')->with($notification);
    } // end method

    public function HariEdit($id)
    {
        $hari = Hari::findOrFail($id);
        return view('backend.data.hari.hari_edit', compact('hari'));
    } // end method

    public function HariUpdate(Request $request)
    {

        $hari_id = $request->id;
        Hari::findOrFail($hari_id)->update([
            'kode_hari' => $request->kode_hari,
            'nama' => $request->nama,

            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Hari Updated SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('hari.all')->with($notification);
    } // end method


    public function HariDelete($id)
    {
        Hari::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Hari Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
