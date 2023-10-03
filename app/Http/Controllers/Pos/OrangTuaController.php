<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\OrangTua;
use App\Models\Siswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrangTuaController extends Controller
{
    public function OrtuAll()
    {
        $ortu = OrangTua::latest()->get();

        return view('backend.data.orangtua.orangtua_all', compact('ortu'));
    } // end method

    public function OrtuAdd()
    {

        $siswa = Siswa::latest()->get();
        $orangtuaIds = OrangTua::pluck('id_user')->toArray();
        $user = User::where('role', '5')
            ->whereNotIn('id', $orangtuaIds)
            ->get();

        return view('backend.data.orangtua.orangtua_add', compact('user', 'siswa'));
    } // end method
    public function OrtuStore(Request $request)
    {

        // $this->validate($request, [
        //     'kode_gr' => 'required|max:50|unique:gurus,kode_gr',
        // ]);

        OrangTua::insert([
            'kode_ortu' => $request->kode_ortu,
            'nama' => $request->nama,
            'id_user' => $request->id_user,
            'id_siswa' => $request->id_siswa,
            'no_hp' => $request->no_hp,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Orang Tua Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('orangtua.all')->with($notification);
    }

    public function OrtuEdit($id)
    {
        $siswa = Siswa::latest()->get();
        $ortu  = OrangTua::findOrFail($id);
        $orangtuaIds = OrangTua::pluck('id_user')->toArray();
        $user = User::where('role', '5')
            ->whereNotIn('id',$orangtuaIds)
            ->get();
        return view('backend.data.orangtua.orangtua_edit', compact('ortu', 'user', 'siswa'));
    }
    public function OrtuUpdate(Request $request)
    {

        // $this->validate($request, [
        //     'kode_gr' => 'required|max:50|unique:gurus,kode_gr',
        // ]);


        $ortu_id = $request->id;
        OrangTua::findOrFail($ortu_id)->update([
            'kode_ortu' => $request->kode_ortu,
            'nama' => $request->nama,
            'id_user' => $request->id_user,
            'id_siswa' => $request->id_siswa,
            'no_hp' => $request->no_hp,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Orang Tua Updated SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('orangtua.all')->with($notification);
    }

    public function OrtuDelete($id)
    {
        OrangTua::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Orang Tua Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
