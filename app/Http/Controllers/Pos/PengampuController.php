<?php

namespace App\Http\Controllers\Pos;

use App\Exports\PengampuExport;
use App\Exports\PengampuUploadExport;
use App\Http\Controllers\Controller;
use App\Imports\PengampuImport;
use App\Models\Guru;
use App\Models\Jadwalmapel;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Pengampu;
use App\Models\Siswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PengampuController extends Controller
{
    public function PengampuAll(Request $request)
    {

        $searchGuru = $request->input('searchguru');
        $searchMapel = $request->input('searchmapel');
        $searchKelas = $request->input('searchkelas');
        $searchKode = $request->input('searchkode');

        $query = Pengampu::query();

        if (!empty($searchGuru)) {
            $query->whereHas('gurus', function ($lecturerQuery) use ($searchGuru) {
                $lecturerQuery->where('nama', 'LIKE', '%' . $searchGuru . '%');
            });
        }

        if (!empty($searchMapel)) {
            $query->whereHas('mapels', function ($lecturerQuery) use ($searchMapel) {
                $lecturerQuery->where('nama', 'LIKE', '%' . $searchMapel . '%');
            });
        }

        if (!empty($searchKelas)) {
            $query->whereHas('kelass', function ($lecturerQuery) use ($searchKelas) {
                $lecturerQuery->where('id', 'LIKE', '%' . $searchKelas . '%');
            });
        }
        if (!empty($searchKode)) {
            $query->where('kode_pengampu', '=', $searchKode);
        }

        //$suppliers = Supplier::all();
        $pengampu = $query->latest()->get();



        $kelas = Kelas::whereIn('id', function ($query) {
            $query->select('kelas')
                ->from('pengampus');
        })->orderBy('tingkat')
            ->get();

        return view('backend.data.pengampu.pengampu_all', compact('pengampu', 'kelas'));
    } // end method

    public function PengampuAdd()
    {
        $kelas = Kelas::orderBy('tingkat')->get();

        $guru = Guru::whereIn('id_user', function ($query) {
            $query->select('id')
                ->from('users')
                ->where('role', 4);
        })
            ->orWhere('id_user', 0)
            ->orderBy('kode_gr', 'asc')->get();

        $mapel = Mapel::orderBy('kode_mapel', 'asc')->get();
        return view('backend.data.pengampu.pengampu_add', compact('kelas', 'mapel', 'guru'));
    } // end method
    public function PengampuStore(Request $request)
    {

        $existingData = Pengampu::where('id_guru', $request->id_guru)
            ->where('id_mapel', $request->id_mapel)
            ->where('kelas', $request->kelas)
            ->count();

        if ($existingData > 0) {
            $notification = array(
                'message' => 'Data combination Pengampu Sudah Ada!',
                'alert-type' => 'warning'
            );
            return redirect()->back()->with($notification);
        }


        $mapel = Mapel::find($request->id_mapel);
        $guru = Guru::find($request->id_guru);

        $kode_mapel = $mapel->kode_mapel;
        $kode_guru = substr($guru->kode_gr, 0, 3);


        do {
            $kode_acak = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'), 0, 4);
            $kode_pengampu =  $kode_mapel . '.' . $kode_guru . '.' . $kode_acak;
            $existingPengampu = Pengampu::where('kode_pengampu', $kode_pengampu)->first();
        } while (!empty($existingPengampu));

        Pengampu::insert([
            'kode_pengampu' => $kode_pengampu,
            'id_guru' => $request->id_guru,
            'id_mapel' => $request->id_mapel,
            'kelas' => $request->kelas,

            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Pengampu Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('pengampu.all')->with($notification);
    }



    public function PengampuEdit($id)
    {
        $kelas = Kelas::orderBy('tingkat')->get();
        $pengampu = Pengampu::findOrFail($id);
        $guru = Guru::whereIn('id_user', function ($query) {
            $query->select('id')
                ->from('users')
                ->where('role', 4);
        })->orderBy('kode_gr', 'asc')->get();

        $mapel = Mapel::orderBy('kode_mapel', 'asc')->get();
        return view('backend.data.pengampu.pengampu_edit', compact('kelas', 'pengampu', 'mapel', 'guru'));
    }
    public function PengampuUpdate(Request $request)
    {

        $pengampu_id = $request->id;
        Pengampu::findOrFail($pengampu_id)->update([
            'id_guru' => $request->id_guru,
            'id_mapel' => $request->id_mapel,
            'kelas' => $request->kelas,

            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Pengampu Updated SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('pengampu.all')->with($notification);
    }

    public function PengampuDelete($id)
    {
        $pengampu = Pengampu::findOrFail($id);
        if ($pengampu) {
            $pengampu->delete();
            Jadwalmapel::where('id_pengampu', $id)->delete();
            $notification = array(
                'message' => 'Pengampu Deleted SuccessFully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'Jadwal not found',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }

    public function PengampuExport(Request $request)
    {
        return Excel::download(new PengampuUploadExport, 'Template Pengampu.xlsx');
    }

    public function pengampuImport(Request $request)
    {
        // Pastikan file telah diunggah sebelum melanjutkan
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $namfile = date('YmdHi') . $file->getClientOriginalName();
            $file->move('DataPengampu', $namfile);
            Excel::import(new PengampuImport, public_path('/DataPengampu/' . $namfile));
        } else {
            // File tidak diunggah atau tidak valid
            $notification = [
                'message' => 'Pengampu Upload Successfully',
                'alert-type' => 'success'
            ];
        }

        return redirect()->route('pengampu.all')->with($notification);
    }

    public function PengampuExportt(Request $request)
    {


        $pengampu = Pengampu::orderby('id')->get();

        return Excel::download(new PengampuExport($pengampu), 'Data Pengampu Mata Pelajaran.xlsx');
    }
}
