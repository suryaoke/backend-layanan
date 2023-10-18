<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Jadwalmapel;
use App\Models\Kelas;
use App\Models\Pengampu;
use App\Models\Rombel;
use App\Models\Seksi;
use App\Models\Tahunajar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SeksiController extends Controller
{
    public function SeksiAll()
    {

        $seksi = Seksi::orderBy('id', 'asc')->get();


        return view('backend.data.seksi.seksi_all', compact('seksi'));
    } // end method

    public function SeksiAdd()
    {

        $guru = Guru::orderBy('kode_gr', 'asc')->get();
        $kelas = Kelas::orderBy('nama', 'asc')->get();
        $semester = Tahunajar::orderBy('tahun', 'asc')->get();
        $rombel = Rombel::orderBy('id', 'asc')->get();
        $jadwalmapel = Jadwalmapel::orderBy('id', 'asc')->get();
        return view('backend.data.seksi.seksi_add', compact('jadwalmapel', 'rombel', 'semester', 'guru', 'kelas'));
    } // end method
    public function SeksiStore(Request $request)
    {

        $tanggal = Carbon::now()->toDateString(); // '2023-10-17'

        $tanggal_tanpa_strip = str_replace("-", "", $tanggal); // '20231017'

        // Menghasilkan 6 karakter acak yang terdiri dari huruf besar, huruf kecil, dan angka
        $kode_acak = substr(str_shuffle('0123456789'), 0, 4);

        $kode_seksi = $tanggal_tanpa_strip . '.' . $kode_acak;


        Seksi::insert([
            'semester' => $request->semester,
            'id_rombel' => $request->id_rombel,
            'kode_seksi' => $kode_seksi,
            'id_jadwal' => $request->id_jadwal,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Seksi Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('seksi.all')->with($notification);
    } // end method

    public function SeksiEdit($id)
    {
        $seksi = Seksi::findOrFail($id);

        $guru = Guru::orderBy('kode_gr', 'asc')->get();
        $kelas = Kelas::orderBy('nama', 'asc')->get();
        $semester = Tahunajar::orderBy('tahun', 'asc')->get();
        $rombel = Rombel::orderBy('id', 'asc')->get();
        $jadwalmapel = Jadwalmapel::orderBy('id', 'asc')->get();
        return view('backend.data.seksi.seksi_edit', compact('semester', 'rombel', 'jadwalmapel', 'seksi', 'guru', 'kelas'));
    } // end method

    public function SeksiUpdate(Request $request)
    {
        $seksi_id = $request->id;
        Seksi::findOrFail($seksi_id)->update([
            'semester' => $request->semester,
            'id_rombel' => $request->id_rombel,
            'id_jadwal' => $request->id_jadwal,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Seksi Updated SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('seksi.all')->with($notification);
    } // end method


    public function SeksiDelete($id)
    {
        Seksi::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Seksi Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
