<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Jabatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatan = Jabatan::all();
        return response()->json(['message' => 'success', 'data' => $jabatan]);
    }
    public function JabatanAll()
    {

        //$suppliers = Supplier::all();
        $jabatan = Jabatan::latest()->get();

        return view('backend.master.jabatan.jabatan_all', compact('jabatan'));
    } // end method

    public function JabatanAdd()
    {

        return view('backend.master.jabatan.jabatan_add');
    } // end method
    public function JabatanStore(Request $request)
    {

        Jabatan::insert([
            'name' => $request->name,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Jabatan Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('jabatan.all')->with($notification);
    }

    public function JabatanEdit($id)
    {
        $jabatan = Jabatan::findOrFail($id);
        return view('backend.master.jabatan.jabatan_edit', compact('jabatan'));
    }
    public function JabatanUpdate(Request $request)
    {

        $jabatan_id = $request->id;
        Jabatan::findOrFail($jabatan_id)->update([
            'name' => $request->name,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Jabatan Updated SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('jabatan.all')->with($notification);
    }

    public function JabatanDelete($id)
    {
        Jabatan::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Jabatan Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
