<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Naskah;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NaskahController extends Controller
{
    public function NaskahAll()
    {

        //$suppliers = Supplier::all();
        $naskah = Naskah::latest()->get();

        return view('backend.data.naskah.naskah_all', compact('naskah'));
    } // end method

    public function NaskahAdd()
    {

        return view('backend.data.naskah.naskah_add');
    } // end method
    public function NaskahStore(Request $request)
    {

        Naskah::insert([
            'nama' => $request->nama,
            'isi' => $request->isi,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Naskah Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('naskah.all')->with($notification);
    }

    public function NaskahEdit($id)
    {
        $naskah = Naskah::findOrFail($id);
        return view('backend.data.naskah.naskah_edit', compact('naskah'));
    }
    public function NaskahUpdate(Request $request)
    {

        $naskah_id = $request->id;
        Naskah::findOrFail($naskah_id)->update([
            'nama' => $request->nama,
            'isi' => $request->isi,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Naskah Updated SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('naskah.all')->with($notification);
    }

    public function NaskahDelete($id)
    {
        Naskah::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Naskah Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // end method

}
