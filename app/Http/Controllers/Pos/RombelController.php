<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Rombel;
use App\Models\Rombelsiswa;
use App\Models\Siswa;
use App\Models\Walas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RombelController extends Controller
{
    public function RombelAll()
    {


        $rombel = Rombel::orderBy('id', 'asc')->paginate(perPage: 12);
        return view('backend.data.rombel.rombel_all', compact('rombel'));
    } // end method

    public function RombelAdd()
    {

        $guru = Guru::orderBy('kode_gr', 'asc')->get();
        $kelas = Kelas::orderBy('tingkat', 'asc')
            ->whereNotIn('id', function ($query) {
                $query->select('id_kelas')
                    ->from('rombels');
            })
            ->get();


        $walas = Walas::orderBy('id', 'asc')
            ->whereNotIn('id', function ($query) {
                $query->select('id_walas')
                    ->from('rombels');
            })
            ->get();


        $siswa = Siswa::orderBy('id', 'asc')
            ->whereNotIn('id', function ($query) {
                $query->select('id_siswa')
                    ->from('rombelsiswas');
            })
            ->get();

        return view('backend.data.rombel.rombel_add', compact('siswa', 'walas', 'guru', 'kelas'));
    } // end method
    public function RombelStore(Request $request)
    {
        $request->validate([
            'id_kelas' => ['required', 'string', 'max:255', 'unique:' . Rombel::class],
            'id_walas' => ['required', 'string', 'max:255', 'unique:' . Rombel::class],
            'kode_rombel' => ['required', 'string', 'max:255', 'unique:' . Rombel::class],
        ]);

        $rombel = Rombel::create([
            'kode_rombel' => $request->kode_rombel,
            'id_walas' => $request->id_walas,
            'id_kelas' => $request->id_kelas,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        // Mengambil nilai id_siswa dari request yang dikirim
        $selectedSiswa = $request->input('id_siswa');

        // Membuat model Rombelsiswa berdasarkan siswa yang dipilih
        foreach ($selectedSiswa as $siswaId) {
            $rombelsiswa = new RombelSiswa();
            $rombelsiswa->id_rombel = $rombel->id; // ID Rombel yang baru saja disimpan
            $rombelsiswa->id_siswa = $siswaId;
            $rombelsiswa->save();
        }

        $notification = array(
            'message' => 'Rombel Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('rombel.all')->with($notification);
    } // end method
    public function RombelEdit($id)
    {
        $rombel = Rombel::findOrFail($id);
        $guru = Guru::orderBy('kode_gr', 'asc')->get();
        $kelas = Kelas::orderBy('tingkat', 'asc')
            ->whereNotIn('id', function ($query) use ($id) {
                $query->select('id_kelas')
                    ->from('rombels')
                    ->where('id', '!=', $id);
            })
            ->get();

        $walas = Walas::orderBy('id', 'asc')
            ->whereNotIn('id', function ($query) use ($id) {
                $query->select('id_walas')
                    ->from('rombels')
                    ->where('id', '!=', $id);
            })
            ->get();

        $siswa = Siswa::orderBy('id', 'asc')->get();


        $siswatersimpan = Siswa::orderBy('id', 'asc')
            ->whereNotIn('id', function ($query) {
                $query->select('id_siswa')
                    ->from('rombelsiswas');
            })
            ->get();

        $selectedSiswa = RombelSiswa::where('id_rombel', $id)->pluck('id_siswa')->all();

        return view('backend.data.rombel.rombel_edit', compact('siswatersimpan', 'siswa', 'walas', 'guru', 'kelas', 'rombel', 'selectedSiswa'));
    }
    public function RombelUpdate(Request $request, $id)
    {
        $request->validate([
            'id_kelas' => ['required', 'string', 'max:255'],
            'id_walas' => ['required', 'string', 'max:255'],
            'kode_rombel' => ['required', 'string', 'max:255'],
        ]);

        $rombel = Rombel::findOrFail($id);

        $rombel->kode_rombel = $request->kode_rombel;
        $rombel->id_walas = $request->id_walas;
        $rombel->id_kelas = $request->id_kelas;
        $rombel->updated_by = Auth::user()->id; // Atur pengguna yang melakukan pembaruan
        $rombel->updated_at = Carbon::now(); // Atur waktu pembaruan

        $rombel->save();

        // Menghapus semua RombelSiswa sebelumnya
        RombelSiswa::where('id_rombel', $id)->delete();

        // Memperbarui RombelSiswa
        $selectedSiswa = $request->input('id_siswa');
        if (!is_null($selectedSiswa)) {
            foreach ($selectedSiswa as $siswaId) {
                $rombelsiswa = new RombelSiswa();
                $rombelsiswa->id_rombel = $rombel->id; // ID Rombel yang baru saja diperbarui
                $rombelsiswa->id_siswa = $siswaId;
                $rombelsiswa->save();
            }
        }

        $notification = array(
            'message' => 'Rombel Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('rombel.all')->with($notification);
    }



    public function RombelDelete($id)
    {
        $rombel = Rombel::findOrFail($id);
        if ($rombel) {
            $rombel->delete();
            RombelSiswa::where('id_rombel', $id)->delete();
            $notification = array(
                'message' => 'Rombel Deleted Successfully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'Rombel not found',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    }
}
