<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Mapel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MapelController extends Controller
{
    public function MapelAll()
    {

        //$suppliers = Supplier::all();
        $mapel = Mapel::latest()->get();

        return view('backend.data.mapel.mapel_all', compact('mapel'));
    } // end method

    public function MapelAdd()
    {

        return view('backend.data.mapel.mapel_add');
    } // end method
    public function MapelStore(Request $request)
    {

       
        Mapel::insert([
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'jp' => $request->jp,
            'kode_ruangan' => $request->kode_ruangan,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Mapel Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('mapel.all')->with($notification);
    }

    public function MapelEdit($id)
    {
        $mapel = Mapel::findOrFail($id);
        return view('backend.data.mapel.mapel_edit', compact('mapel'));
    }
    public function MapelUpdate(Request $request)
    {

        $mapel_id = $request->id;
        Mapel::findOrFail($mapel_id)->update(['nama' => $request->nama,
            'jenis' => $request->jenis,
            'jp' => $request->jp,
            'kode_ruangan' => $request->kode_ruangan,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Mapel Updated SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('mapel.all')->with($notification);
    }

    public function MapelDelete($id)
    {
        Mapel::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Mapel Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
