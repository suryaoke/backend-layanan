<?php

namespace App\Http\Controllers\Pos;

use App\Exports\MapelExport;
use App\Http\Controllers\Controller;
use App\Imports\MapelImport;
use App\Models\Jurusan;
use App\Models\Mapel;
use App\Models\Tahunajar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class MapelController extends Controller
{
    public function MapelAll(request $request)
    {

        $searchKode = $request->input('searchkode');
        $searchInduk = $request->input('searchinduk');
        $searchNama = $request->input('searchnama');
        $searchJp = $request->input('searchjp');
        $searchJurusan = $request->input('searchjurusan');
        $searchKelompok = $request->input('searchkelompok');
        $searchType = $request->input('searchtype');

        $query = Mapel::query();

        if (!empty($searchKode)) {
            $query->where('kode_mapel', '=', $searchKode);
        }
        if (!empty($searchInduk)) {
            $query->where('induk', '=', $searchInduk);
        }
        if (!empty($searchNama)) {
            $query->where('nama', '=', $searchNama);
        }
        if (!empty($searchJp)) {
            $query->where('jp', '=', $searchJp);
        }
        if (!empty($searchJurusan)) {
            $query->whereHas('jurusans', function ($lecturerQuery) use ($searchJurusan) {
                $lecturerQuery->where('id', 'LIKE', '%' . $searchJurusan . '%');
            });
        }

        if (!empty($searchKelompok)) {
            $query->where('jenis', '=', $searchKelompok);
        }
        if (!empty($searchType)) {
            $query->where('type', '=', $searchType);
        }

        $mapel = $query->orderByRaw('-induk DESC')->orderBy('kode_mapel', 'asc')->get();
       
        $jurusan = Jurusan::whereIn('id', function ($query) {
            $query->select('id_jurusan')
            ->from('mapels');
        })->orderBy('nama')
            ->get();

        return view('backend.data.mapel.mapel_all', compact('mapel', 'jurusan'));
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

            'type' => $request->type,
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
            'type' => $request->type,
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

    public function mapelImport(Request $request)
    {
        // Pastikan file telah diunggah sebelum melanjutkan
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $namfile = date('YmdHi') . $file->getClientOriginalName();
            $file->move('DataMapel', $namfile);
            Excel::import(new MapelImport, public_path('/DataMapel/' . $namfile));
        } else {
            // File tidak diunggah atau tidak valid
            $notification = [
                'message' => 'Mapel Upload Successfully',
                'alert-type' => 'success'
            ];
        }

        return redirect()->route('mapel.all')->with($notification);
    }

    public function MapelExport(Request $request)
    {


        $mapel = Mapel::orderby('nama')->get();

        return Excel::download(new MapelExport($mapel), 'Data Mapel.xlsx');
    }
}
