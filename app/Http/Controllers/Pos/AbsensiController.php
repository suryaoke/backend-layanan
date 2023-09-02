<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Kelas;
use App\Models\Siswa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AbsensiController extends Controller
{
    public function AbsensiAll(Request $request)
    {
        // $absensi = Absensi::latest()->get();
        $todayDate = Carbon::now()->format('d/m/Y');
        $kelas = Kelas::first();
        $absensi =
            Absensi::when(
                $request->tanggal != null,
                function ($q) use ($request) {
                    return $q->where('tanggal', $request->tanggal);
                },
                function ($q) use ($todayDate) {
                    return $q->where('tanggal', $todayDate);
                }
            )
            ->when($request->mapel != null, function ($q) use ($request) {
                return $q->where('mata_pelajaran', $request->mapel);
            })
            ->when($request->kelas != null, function ($q) use ($request) {
                return $q->whereHas('siswa1', function ($subQ) use ($request) {
                    $subQ->where('kelas', $request->kelas);
                });
            })->paginate(perPage: 50);


        // $absensi =Absensi::where('')->paginate(perPage: 50);

        $siswa1 = Siswa::latest()->get();
        $kelas = Kelas::orderBy('nama', 'asc')->get();
        return view('backend.data.absensi.absensi_all', compact('absensi', 'siswa1', 'kelas'));
    }

    public function AbsensiAdd()
    {
        $siswa = Siswa::latest()->get();
        $kelas = Kelas::orderBy('nama', 'asc')->get();


        return view('backend.data.absensi.absensi_add', compact('siswa', 'kelas'));
    }


    public function AbsensiStore(Request $request)
    {

        // $request->validate([
        //     'tanggal' => 'required|min:3|max:255|unique:absensis,tanggal,NULL,id,mata_pelajaran,' . $request->input('mata_pelajaran'),

        // ]);
        $search = $request->search;
        $siswa = Siswa::where('kelas', $search)->get();
        $absensi = Absensi::first();

        foreach ($siswa as $row) {

            $existingAbsensi = Absensi::where([
                'tanggal' => $request->input('tanggal'),
                'mata_pelajaran' => $request->input('mata_pelajaran'),
                'siswa' => $row->id
            ])->first();
            if (!$existingAbsensi) {
                $absensi = new Absensi();
                $absensi->siswa = $row->id;
                $absensi->tanggal = $request->tanggal;
                $absensi->status = $request->status;
                $absensi->ket = $request->ket;
                $absensi->mata_pelajaran = $request->mata_pelajaran;
                $absensi->created_by = Auth::user()->id;
                $absensi->created_at = Carbon::now();
                $absensi->save();
            } else {
                $notification = array(
                    'message' => ' Data kombinasi Absensi Tersebut Sudah Ada',
                    'alert-type' => 'warning'
                );
                return redirect()->back()->with($notification);
            }
        }

        $notification = array(
            'message' => ' Data Absensi SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('absensi.all')->with($notification);
    }

    public function searchAbsensi(Request $request)
    {
        $search = $request->search;

        $absensi = Absensi::where(function ($query) use ($search) {
            $query->where('tanggal', 'like', "%$search");

            $query->where('siswa', 'like', "%$search");
        })->orderBy('nama', 'asc')->paginate(perPage: 50);


        $kelas = Kelas::orderBy('nama')->get();



        return view('backend.data.siswa.siswa_all', compact('siswa', 'search', 'kelas'));
    }

    public function AbsensiSiswa(Request $request)
    {
        // $absensi = Absensi::latest()->get();
        $todayDate = Carbon::now()->format('d/m/Y');
        $kelas = Kelas::first();
        $absensi =
            Absensi::when(
                $request->tanggal != null,
                function ($q) use ($request) {
                    return $q->where('tanggal', $request->tanggal);
                },
                function ($q) use ($todayDate) {
                    return $q->where('tanggal', $todayDate);
                }
            )
            ->when($request->mapel != null, function ($q) use ($request) {
                return $q->where('mata_pelajaran', $request->mapel);
            })
            ->when($request->kelas != null, function ($q) use ($request) {
                return $q->whereHas('siswa1', function ($subQ) use ($request) {
                    $subQ->where('kelas', $request->kelas);
                });
            })->paginate(perPage: 50);


        // $absensi =Absensi::where('')->paginate(perPage: 50);

        $siswa1 = Siswa::latest()->get();
        $kelas = Kelas::orderBy('nama', 'asc')->get();
        return view('backend.data.absensi.absensi_siswa', compact('absensi', 'siswa1', 'kelas'));
    } //end method

    public function AbsensiSiswaStore(Request $request)
    {

        $ketData = $request->input('ket');
        $statusData = $request->input('status');

        foreach ($ketData as $absensiId => $keterangan) {
            $absensi = Absensi::find($absensiId);

            if ($absensi) {
                $absensi->update([
                    'ket' => $keterangan,
                    'status' => $statusData[$absensiId],
                ]);
            }
        }

        $notification = array(
            'message' => 'Absensi Siswa SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } //end method


    public function AbsensiDelete($id)
    {
        Absensi::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Absensi Siswa Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
