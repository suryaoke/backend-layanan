<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Tahunajar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TahunajarController extends Controller
{
    public function TahunajarAll()
    {

        $tahunajar = Tahunajar::orderBy('tahun', 'asc')->get();

        return view('backend.data.tahunajar.tahunajar_all', compact('tahunajar'));
    } // end method

    public function TahunajarAdd()
    {

        return view('backend.data.tahunajar.tahunajar_add');
    } // end method
    public function TahunajarStore(Request $request)
    {
        // $request->validate([
        //     'tahun' => ['required', 'string', 'max:255', 'unique:' . Tahunajar::class],
        // ]);
        Tahunajar::insert([
            'tahun' => $request->tahun,
            'semester' => $request->semester,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Tahunajar Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('tahunajar.all')->with($notification);
    } // end method

    public function TahunajarEdit($id)
    {
        $tahunajar = Tahunajar::findOrFail($id);
        return view('backend.data.tahunajar.tahunajar_edit', compact('tahunajar'));
    } // end method

    public function TahunajarUpdate(Request $request)
    {

        $tahunajar_id = $request->id;
        Tahunajar::findOrFail($tahunajar_id)->update([
            'tahun' => $request->tahun,
            'semester' => $request->semester,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Tahunajar Updated SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('tahunajar.all')->with($notification);
    } // end method


    public function TahunajarDelete($id)
    {
        Tahunajar::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Tahunajar Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
