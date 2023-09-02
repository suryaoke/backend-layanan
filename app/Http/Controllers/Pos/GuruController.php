<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuruController extends Controller
{
    public function GuruAll()
    {
        $guru = Guru::latest()->get();

        return view('backend.data.guru.guru_all', compact('guru'));
    } // end method

    public function GuruAdd()
    {

        $user = User::latest()->get();
        return view('backend.data.guru.guru_add', compact('user'));
    } // end method
    public function GuruStore(Request $request)
    {

        $this->validate($request, [
            'kode_gr' => 'required|max:50|unique:gurus,kode_gr',
            'nip' => 'required|max:50|unique:gurus,nip',
        ]);

        Guru::insert([
            'kode_gr' => $request->kode_gr,
            'nama' => $request->nama,
            'username' => $request->username,
            'nip' => $request->nip,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Guru Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('guru.all')->with($notification);
    }

    public function GuruEdit($id)
    {
        $guru = Guru::findOrFail($id);
        return view('backend.data.guru.guru_edit', compact('guru'));
    }
    public function GuruUpdate(Request $request)
    {

     
        $guru_id = $request->id;
        Guru::findOrFail($guru_id)->update([
            'kode_gr' => $request->kode_gr,
            'nama' => $request->nama,
            'username' => $request->username,
            'nip' => $request->nip,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Guru Updated SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('guru.all')->with($notification);
    }

    public function GuruDelete($id)
    {
        Guru::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Guru Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
