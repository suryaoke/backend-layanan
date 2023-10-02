<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JurusanController extends Controller
{
    public function JurusanAll()
    {

        $jurusan = Jurusan::orderBy('kode_jurusan', 'asc')->get();

        return view('backend.data.jurusan.jurusan_all', compact('jurusan'));
    } // end method

    public function JurusanAdd()
    {

        return view('backend.data.jurusan.jurusan_add');
    } // end method
    public function JurusanStore(Request $request)
    {
        $request->validate([
            'kode_jurusan' => ['required', 'string', 'max:255', 'unique:' . Jurusan::class],
        ]);
        Jurusan::insert([
            'kode_jurusan' => $request->kode_jurusan,
            'nama' => $request->nama,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Jurusan Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('jurusan.all')->with($notification);
    } // end method

    public function JurusanEdit($id)
    {
        $jurusan = Jurusan::findOrFail($id);
        return view('backend.data.jurusan.jurusan_edit', compact('jurusan'));
    } // end method

    public function JurusanUpdate(Request $request)
    {

        $jurusan_id = $request->id;
        Jurusan::findOrFail($jurusan_id)->update([
            'kode_jurusan' => $request->kode_jurusan,
            'nama' => $request->nama,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Jurusan Updated SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('jurusan.all')->with($notification);
    } // end method


    public function JurusanDelete($id)
    {
        Jurusan::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Jurusan Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
