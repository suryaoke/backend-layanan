<?php

namespace App\Http\Controllers\Pos;

use App\Exports\OrangtuaExport;
use App\Http\Controllers\Controller;
use App\Imports\OrangTuaImport;
use App\Models\OrangTua;
use App\Models\Siswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class OrangTuaController extends Controller
{
    public function OrtuAll(request $request)
    {
        $searchKode = $request->input('searchkode');
        $searchNama = $request->input('searchnama');
        $searchNohp = $request->input('searchnohp');
        $searchUsername = $request->input('searchusername');
        $searchSiswa = $request->input('searchsiswa');


        $query = OrangTua::query();
        if (!empty($searchKode)) {
            $query->where('kode_ortu', '=', $searchKode);
        }
        if (!empty($searchNama)) {
            $query->where('nama', '=', $searchNama);
        }
        if (!empty($searchNohp)) {
            $query->where('no_hp', '=', $searchNohp);
        }
        if (!empty($searchUsername)) {
            $query->whereHas('users', function ($lecturerQuery) use ($searchUsername) {
                $lecturerQuery->where('username', 'LIKE', '%' . $searchUsername . '%');
            });
        }

        if (!empty($searchSiswa)) {
            $query->whereHas('siswas', function ($lecturerQuery) use ($searchSiswa) {
                $lecturerQuery->where('nama', 'LIKE', '%' . $searchSiswa . '%');
            });
        }

        $ortu = $query->orderby('nama')->get();

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


        $orangtua = [
            'kode_ortu' => $request->kode_ortu,
            'nama' => $request->nama,
            'id_siswa' => $request->id_siswa,
            'no_hp' => $request->no_hp,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ];

        $user = null;

        if ($request->has('username') && $request->username !== null) {
            // Membuat email unik dengan menggunakan waktu saat ini
            $email =  time() . '@example.com';

            $user = User::create([
                'name' => $request->nama,
                'username' => $request->username,
                'email' => $email,
                'profile_image' => '',
                'role' => 5,
                'status' => 1,
                'password' => Hash::make($request->password),
            ]);
            $orangtua['id_user'] = $user->id;
        }
        $orangtuaData = OrangTua::create($orangtua);

        $notification = array(
            'message' => 'Orang Tua Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('orangtua.all')->with($notification);
    }

    public function OrtuEdit($id)
    {

        $ortu  = OrangTua::findOrFail($id);
        $orangtuaIds = OrangTua::pluck('id_user')->toArray();

        $user = User::where('role', '5')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('orang_tuas')
                    ->whereRaw('orang_tuas.id_user = users.id');
            })
            ->get();



        $siswa = Siswa::whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('orang_tuas')
                ->whereRaw('orang_tuas.id_siswa = siswas.id');
        })
            ->get();

        return view('backend.data.orangtua.orangtua_edit', compact('ortu', 'user', 'siswa'));
    }
    public function OrtuUpdate(Request $request)
    {

        $orangtua = OrangTua::findOrFail($request->id);
        $orangtua->update([
            'kode_ortu' => $request->kode_ortu,
            'nama' => $request->nama,
            'id_siswa' => $request->id_siswa,
            'id_user' => $request->id_user,
            'no_hp' => $request->no_hp,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);
        if ($request->has('username')) {
            User::where('id', $orangtua->id_user)->update([
                'username' => $request->username,
                'name'  => $orangtua->nama,
            ]);
        }
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

    public function orangTuaImport(Request $request)
    {
        // Pastikan file telah diunggah sebelum melanjutkan
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $namfile = date('YmdHi') . $file->getClientOriginalName();
            $file->move('DataOrangtua', $namfile);
            Excel::import(new OrangTuaImport, public_path('/DataOrangtua/' . $namfile));
        } else {
            // File tidak diunggah atau tidak valid
            $notification = [
                'message' => 'Orang Tua Upload Successfully',
                'alert-type' => 'success'
            ];
        }

        return redirect()->route('orangtua.all')->with($notification);
    }

    public function OrangtuaExport(Request $request)
    {


        $orangtua = OrangTua::get();

        return Excel::download(new OrangtuaExport($orangtua), 'Data Orangtua.xlsx');
    }
}
