<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Mapel;
use App\Models\Tahunajar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MapelController extends Controller
{
    public function MapelAll()
    {

        //$suppliers = Supplier::all();
        $mapel = Mapel::orderByRaw('-induk DESC')->orderBy('kode_mapel', 'asc')->get();


        return view('backend.data.mapel.mapel_all', compact('mapel'));
    } // end method

    public function MapelAdd()
    {
        $jurusan = Jurusan::orderBy('kode_jurusan', 'asc')->get();
        $tahunajar = Tahunajar::orderBy('tahun', 'asc')->get();
        return view('backend.data.mapel.mapel_add', compact('jurusan', 'tahunajar'));
    } // end method
    public function MapelStore(Request $request)
    {
        $this->validate($request, [
            'kode_mapel' => 'required|max:50|unique:mapels,kode_mapel',

        ]);
        Mapel::insert([
            'kode_mapel' => $request->kode_mapel,
            'induk' => $request->induk,
            'nama' => $request->nama,
            'id_jurusan' => $request->id_jurusan,
            'jenis' => $request->jenis,
            'jp' => $request->jp,
            'semester' => $request->semester,
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
        $jurusan = Jurusan::orderBy('kode_jurusan', 'asc')->get();
        $tahunajar = Tahunajar::orderBy('tahun', 'asc')->get();
        return view('backend.data.mapel.mapel_edit', compact('mapel', 'tahunajar', 'jurusan'));
    }
    public function MapelUpdate(Request $request)
    {

        $mapel_id = $request->id;
        Mapel::findOrFail($mapel_id)->update([
            'nama' => $request->nama,
            'kode_mapel' => $request->kode_mapel,
            'induk' => $request->induk,
            'nama' => $request->nama,
            'id_jurusan' => $request->id_jurusan,
            'jenis' => $request->jenis,
            'jp' => $request->jp,
            'semester' => $request->semester,
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
