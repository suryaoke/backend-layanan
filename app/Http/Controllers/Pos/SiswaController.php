<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function Pest\Laravel\get;

class SiswaController extends Controller
{
    public function SiswaAll()
    {
        $siswa = Siswa::orderBy('kelas', 'desc')
            ->orderBy('nama', 'asc')
            ->paginate(perPage: 50);
        $kelas = Kelas::orderBy('nama')->get();
        return view('backend.data.siswa.siswa_all', compact('siswa', 'kelas'));
    } // end method

    public function SiswaAdd()
    {

        $kelas = Kelas::orderBy('nama')->get();
        $orangtuaIds = Siswa::pluck('id_user')->toArray();
        $user = User::where('role', '6')
            ->whereNotIn('id', $orangtuaIds)
            ->get();
        return view('backend.data.siswa.siswa_add', compact('kelas', 'user'));
    } // end method
    public function SiswaStore(Request $request)
    {
        $request->validate([
            'nisn' => ['required', 'string', 'max:255', 'unique:' . Siswa::class],

        ]);

        Siswa::insert([
            'nama' => $request->nama,
            'nisn' => $request->nisn,
            'kelas' => $request->kelas,
            'jk' => $request->jk,
            'id_user' => $request->id_user,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Siswa Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('siswa.all')->with($notification);
    }

    public function SiswaEdit($id)
    {
        $siswa = Siswa::findOrFail($id);
        $kelas = Kelas::all();
        $orangtuaIds = Siswa::pluck('id_user')->toArray();
        $user = User::where('role', '6')
            ->whereNotIn('id', $orangtuaIds)
            ->get();
        return view('backend.data.siswa.siswa_edit', compact('siswa', 'kelas', 'user'));
    }
    public function SiswaUpdate(Request $request)
    {


        $siswa_id = $request->id;
        Siswa::findOrFail($siswa_id)->update([
            'nama' => $request->nama,
            'nisn' => $request->nisn,
            'kelas' => $request->kelas,
            'jk' => $request->jk,
            'id_user' => $request->id_user,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Siswa Updated SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('siswa.all')->with($notification);
    }

    public function SiswaDelete($id)
    {
        Siswa::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Siswa Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $siswa = Siswa::where(function ($query) use ($search) {
            $query->where('kelas', 'like', "%$search");
        })->orderBy('nama', 'asc')->paginate(perPage: 50);
        $kelas = Kelas::orderBy('nama')->get();

        return view('backend.data.siswa.siswa_all', compact('siswa', 'search', 'kelas'));
    }

    public function SiswaProfile()
    {

        return view('backend.data.siswa.siswa_profile');
    } // end method
}
