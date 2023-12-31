<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Jadwalmapel;
use App\Models\Kelas;
use App\Models\Pengampu;
use App\Models\Rombel;
use App\Models\Rombelsiswa;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Walas;
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
        $siswa = Siswa::orderBy('nisn', 'desc')
            ->orderBy('nama', 'asc')
            ->paginate(perPage: 50);

        return view('backend.data.siswa.siswa_all', compact('siswa'));
    } // end method

    public function SiswaAdd()
    {


        $orangtuaIds = Siswa::pluck('id_user')->toArray();
        $user = User::where('role', '6')
            ->whereNotIn('id', $orangtuaIds)
            ->get();
        return view('backend.data.siswa.siswa_add', compact('user'));
    } // end method
    public function SiswaStore(Request $request)
    {
        $request->validate([
            'nisn' => ['required', 'string', 'max:255', 'unique:' . Siswa::class],

        ]);

        Siswa::insert([
            'nama' => $request->nama,
            'nisn' => $request->nisn,
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

        $orangtuaIds = Siswa::pluck('id_user')->toArray();
        $user = User::where('role', '6')
            ->whereNotIn('id', $orangtuaIds)
            ->get();
        return view('backend.data.siswa.siswa_edit', compact('siswa', 'user'));
    }
    public function SiswaUpdate(Request $request)
    {


        $siswa_id = $request->id;
        Siswa::findOrFail($siswa_id)->update([
            'nama' => $request->nama,
            'nisn' => $request->nisn,

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

    public function SiswaGuru()
    {
        $userId = Auth::user()->id;

        // Ambil ID guru berdasarkan ID user yang aktif
        $guruId = Guru::where('id_user', $userId)->value('id');

        // Ambil ID pengampu yang berelasi dengan guru melalui jadwalmapels
        $pengampuIds = Jadwalmapel::whereHas('pengampus', function ($query) use ($guruId) {
            $query->where('id_guru', $guruId);
        })->pluck('id_pengampu')->unique();

        // Ambil data siswa dengan kelas yang sama dengan pengampu yang diambil dari jadwalmapels
        $siswa = Siswa::whereIn('kelas', function ($query) use ($pengampuIds) {
            $query->select('kelas')
                ->from('pengampus')
                ->whereIn('id', $pengampuIds);
        })
            ->orderBy('kelas', 'desc')
            ->orderBy('nama', 'asc')
            ->paginate(50);

        // Sekarang $siswa akan berisi data siswa yang terkait dengan guru yang aktif melalui jadwalmapels


        // Sekarang $siswa akan berisi data siswa dengan kelas yang diajar oleh guru yang aktif

        return view('backend.data.siswa.siswa_guru', compact('siswa'));
    } // end method

    public function SiswaGuruwalas()
    {
        $userId = Auth::user()->id;

        // Ambil ID guru berdasarkan ID user yang aktif
        $guruId = Guru::where('id_user', $userId)->value('id');

        $walas = Walas::where('id_guru', $guruId)->first();
        $siswa = null; // inisialisasi variabel $siswa

        if ($walas) {
            $rombe = Rombel::where('id_walas', $walas->id)->first();
            if ($rombe) {
                $rombelsiswa = Rombelsiswa::where('id_rombel', $rombe->id)->get();
                if ($rombelsiswa) {
                    $siswaIds = $rombelsiswa->pluck('id_siswa')->toArray();
                    $siswa = Siswa::whereIn('id', $siswaIds)->get();
                }
            }
        }

        // Mengonstruksi array untuk dikirim ke view
        $data = [
            'walas' => $walas,
            'siswa' => $siswa,
        ];

        return view('backend.data.siswa.siswa_guruwalas', compact('data', 'walas', 'siswa'));
    }
}
