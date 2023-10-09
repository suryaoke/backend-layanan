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
        $guru = Guru::OrderBy('kode_gr')->get();

        return view('backend.data.guru.guru_all', compact('guru'));
    } // end method

    public function GuruAdd()
    {

        $guruIds = Guru::pluck('id_user')->toArray();
        $user = User::where('role', '4')
            ->whereNotIn('id', $guruIds)
            ->get();
        return view('backend.data.guru.guru_add', compact('user'));
    } // end method
    public function GuruStore(Request $request)
    {

        $this->validate($request, [
            'kode_gr' => 'required|max:50|unique:gurus,kode_gr',
            'id_user' => 'required|max:50|unique:gurus,id_user',
        ]);

        Guru::insert([
            'kode_gr' => $request->kode_gr,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'id_user' => $request->id_user,
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
        $guruIds = Guru::pluck('id_user')->toArray();
        $user = User::where('role', '4')
        ->whereNotIn('id', $guruIds)
            ->get();
        return view('backend.data.guru.guru_edit', compact('guru','user'));
    }
    public function GuruUpdate(Request $request)
    {


        $guru_id = $request->id;
        Guru::findOrFail($guru_id)->update([
            'kode_gr' => $request->kode_gr,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'id_user' => $request->id_user,
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
