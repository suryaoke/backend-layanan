<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Jadwalmapel;
use App\Models\Kd3;
use App\Models\Kd4;
use App\Models\Kelas;
use App\Models\Ki3;
use App\Models\Ki4;
use App\Models\NilaiKd3;
use App\Models\NilaiKd4;
use App\Models\NilaisiswaKd3;
use App\Models\NilaisiswaKd4;
use App\Models\Pengampu;
use App\Models\Rombel;
use App\Models\Seksi;
use App\Models\Tahunajar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Else_;

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
        $jadwalmapel = Jadwalmapel::where('status', '2')->orderBy('id', 'asc')->get();
        return view('backend.data.seksi.seksi_add', compact('jadwalmapel', 'rombel', 'semester', 'guru', 'kelas'));
    } // end method


    public function SeksiStore(Request $request)
    {

        $semester = $request->semester;
        $id_rombel = $request->id_rombel;
        $id_jadwal = $request->id_jadwal;

        // Pastikan tidak ada kombinasi yang sama dari semester, id_rombel, dan id_jadwal
        $existingSeksi = Seksi::where('semester', $semester)
            ->where('id_rombel', $id_rombel)
            ->where('id_jadwal', $id_jadwal)
            ->first();

        if ($existingSeksi) {
            $notification = array(
                'message' => 'Kombinasi data seksi sudah ada..!!',
                'alert-type' => 'warning'
            );
            return redirect()->back()->with($notification);
        }


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

        // Memasukkan data ke model Kd setelah menyimpan data ke model Seksi
        $seksi = Seksi::where('semester', $semester)
            ->where('id_rombel', $id_rombel)
            ->where('id_jadwal', $id_jadwal)
            ->first();

        Ki3::insert([
            'id_seksi' => $seksi->id,
            'tahunajar' => $seksi->semester, // Pastikan $seksi->id sudah didefinisikan dengan benar
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        Ki4::insert([
            'id_seksi' => $seksi->id,
            'tahunajar' => $seksi->semester, // Pastikan $seksi->id sudah didefinisikan dengan benar
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);


        return redirect()->route('seksi.all')->with($notification);
    } // end method


    public function SeksiEdit($id)
    {
        $seksi = Seksi::findOrFail($id);

        $guru = Guru::orderBy('kode_gr', 'asc')->get();
        $kelas = Kelas::orderBy('nama', 'asc')->get();
        $semester = Tahunajar::orderBy('tahun', 'asc')->get();
        $rombel = Rombel::orderBy('id', 'asc')->get();
        $rombel1 = Rombel::orderBy('id', 'asc')->first();
        $pengampus = Pengampu::where('kelas', $rombel1->id_kelas)->first();
        $jadwalmapel = Jadwalmapel::where('id_pengampu', $pengampus->id)->orderBy('id', 'asc')->get();
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
        $seksi = Seksi::find($id);

        if (!$seksi) {
            $notification = array(
                'message' => 'Seksi not found',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        $ki3 = Ki3::where('id_seksi', $id)->first();
        $ki4 = Ki4::where('id_seksi', $id)->first();

        if ($ki3) {
            Kd3::where('id_ki3', $ki3->id)->delete();
        }
        if ($ki4) {
            Kd4::where('id_ki4', $ki4->id)->delete();
        }

        $nilaikd3 = NilaiKd3::where('id_seksi', $id)->get();
        $nilaikd4 = NilaiKd4::where('id_seksi', $id)->get();

        if ($nilaikd3) {
            foreach ($nilaikd3 as $data) {
                NilaisiswaKd3::where('id_nilaikd3', $data->id)->delete();
            }
        }
        if ($nilaikd4) {
            foreach ($nilaikd4 as $data) {
                NilaisiswaKd4::where('id_nilaikd4', $data->id)->delete();
            }
        }


        // Delete related entries
        $seksi->delete();
        Ki3::where('id_seksi', $id)->delete();
        Ki4::where('id_seksi', $id)->delete();
        NilaiKd3::where('id_seksi', $id)->delete();
        NilaiKd4::where('id_seksi', $id)->delete();

        $notification = array(
            'message' => 'Seksi Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
