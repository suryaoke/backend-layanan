<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Ekstra;
use App\Models\Ekstranilai;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Rombelsiswa;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;

class EkstraController extends Controller
{
    public function EkstraAll()
    {

        $ekstra = Ekstra::orderBy('nama', 'asc')->paginate(perPage: 12);

        return view('backend.data.ekstra.ekstra_all', compact('ekstra'));
    } // end method

    public function EkstraAdd()
    {

        $guru = Guru::orderBy('kode_gr', 'asc')->get();
        $kelas = Kelas::orderBy('nama', 'asc')->get();

        return view('backend.data.ekstra.ekstra_add', compact('guru', 'kelas'));
    } // end method
    public function EkstraStore(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255', 'unique:' . Ekstra::class],

        ]);


        if ($request->file('image')) {

            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension(); // 343434.png
            Image::make($image)->resize(200, 200)->save('uploads/admin_images/' . $name_gen);
            $save_url = '' . $name_gen;



            Ekstra::insert([
                'id_guru' => $request->id_guru,
                'nama' => $request->nama,
                'image' => $save_url,
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Ekstra Inserted SuccessFully',
                'alert-type' => 'success'
            );
            return redirect()->route('ekstra.all')->with($notification);
        } else {

            Ekstra::insert([
                'id_guru' => $request->id_guru,
                'nama' => $request->nama,
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Ekstra Inserted SuccessFully',
                'alert-type' => 'success'
            );
            return redirect()->route('ekstra.all')->with($notification);
        }
    } // end method

    public function EkstraEdit($id)
    {
        $ekstra = Ekstra::findOrFail($id);

        $guru = Guru::orderBy('kode_gr', 'asc')->get();
        $kelas = Kelas::orderBy('nama', 'asc')->get();
        return view('backend.data.ekstra.ekstra_edit', compact('ekstra', 'guru', 'kelas'));
    } // end method

    public function EkstraUpdate(Request $request)
    {

        $ekstra_id = $request->id;
        if ($request->file('image')) {

            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension(); // 343434.png
            Image::make($image)->resize(200, 200)->save('uploads/admin_images/' . $name_gen);
            $save_url = '' . $name_gen;

            Ekstra::findOrFail($ekstra_id)->update([
                'id_guru' => $request->id_guru,
                'nama' => $request->nama,
                'image' => $save_url,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),

            ]);

            $notification = array(
                'message' => 'Ekstra Updated SuccessFully',
                'alert-type' => 'success'
            );
            return redirect()->route('ekstra.all')->with($notification);
        } else {

            Ekstra::findOrFail($ekstra_id)->update([
                'id_guru' => $request->id_guru,
                'nama' => $request->nama,

                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),

            ]);

            $notification = array(
                'message' => 'Ekstra Updated SuccessFully',
                'alert-type' => 'success'
            );
            return redirect()->route('ekstra.all')->with($notification);
        }
    } // end method


    public function EkstraDelete($id)
    {
        Ekstra::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Ekstra Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }


    public function EkstranilaiAll()
    {
        $guru = Guru::where('id_user', Auth::user()->id)->first();
        $ekstra = Ekstra::where('id_guru', $guru->id)->first();
        $ekstranilai = Ekstranilai::where('id_ekstra', $ekstra->id)->orderBy('id_ekstra', 'asc')->get();

        return view('backend.data.ekstra.ekstranilai_all', compact('ekstranilai'));
    } // end method

    public function EkstranilaiAdd()
    {

        $rombelsiswa = Rombelsiswa::orderBy('id', 'asc')->get();
        $kelas = Kelas::orderBy('nama', 'asc')->get();
        $guru = Guru::where('id_user', Auth::user()->id)->first();
        $ekstra = Ekstra::where('id_guru', $guru->id)->get();

        return view('backend.data.ekstra.ekstranilai_add', compact('ekstra', 'rombelsiswa', 'kelas'));
    } // end method
    public function EkstranilaiStore(Request $request)
    {

        Ekstranilai::insert([
            'id_ekstra' => $request->id_ekstra,
            'id_rombelsiswa' => $request->id_rombelsiswa,
            'nilai' => $request->nilai,
            'ket' => $request->ket,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Ekstra Nilai Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('ekstranilai.all')->with($notification);
    } // end method


    public function EkstranilaiEdit($id)
    {
        $ekstranilai = Ekstranilai::findOrFail($id);

        $guru = Guru::orderBy('kode_gr', 'asc')->get();
        $siswa = Siswa::orderBy('id', 'asc')->get();
        $rombelsiswa = Rombelsiswa::orderBy('id', 'asc')->get();
        $guru1 = Guru::where('id_user', Auth::user()->id)->first();
        $ekstra = Ekstra::where('id_guru', $guru1->id)->get();
        return view('backend.data.ekstra.ekstranilai_edit', compact('rombelsiswa', 'ekstra', 'ekstranilai', 'guru', 'siswa'));
    } // end method

    public function EkstranilaiUpdate(Request $request)
    {

        $ekstra_id = $request->id;
        Ekstranilai::findOrFail($ekstra_id)->update([
            'id_ekstra' => $request->id_ekstra,
            'id_rombelsiswa' => $request->id_rombelsiswa,
            'nilai' => $request->nilai,
            'ket' => $request->ket,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Ekstra Nilai Updated SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('ekstranilai.all')->with($notification);
    } // end method


    public function EkstranilaiDelete($id)
    {
        Ekstranilai::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Ekstra Nilai Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }


    public function EkstranilaiView($id)
    {
        $ekstranilai = Ekstranilai::where('id_ekstra', $id)->orderBy('id', 'asc')->get();


        return view('backend.data.ekstra.ekstranilai_view', compact('ekstranilai'));
    } // end method

}
