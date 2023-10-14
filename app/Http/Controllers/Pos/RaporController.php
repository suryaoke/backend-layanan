<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Nilaiprestasi;
use App\Models\Nilaisosial;
use App\Models\Nilaispiritual;
use App\Models\Siswa;
use App\Models\Walas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RaporController extends Controller
{
    public function NilaisosialAll()
    {


        $guruId = Guru::where('id_user', Auth::user()->id)->first();
        $walas = Walas::where('id_guru', $guruId->id)->orderBy('id', 'asc')->first();
        $siswa = null; // inisialisasi variabel $siswa
        if ($walas) {
            $siswa = Siswa::where('kelas', $walas->id_kelas)->orderBy('nama', 'asc')->get();
        }

        $data = [
            'walas' => $walas,
            'siswa' => $siswa,
        ];
        return view('backend.data.rapor.nilaiwalas.nilaisosial_all', compact('walas', 'data', 'siswa'));
    } // end method


    public function NilaisosialStore(Request $request)
    {
        $nilaiArray = array(
            '0' => $request->input('nilai_kejujuran'),
            '1' => $request->input('nilai_kedisiplinan'),
            '2' => $request->input('nilai_tanggungjawab'),
            '3' => $request->input('nilai_toleransi'),
            '4' => $request->input('nilai_gotongroyong'),
            '5' => $request->input('nilai_kesantunan'),
            '6' => $request->input('nilai_percayadiri'),
        );

        Nilaisosial::insert([
            'id_walas' => $request->id_walas,
            'id_siswa' => $request->id_siswa,
            'nilai' => json_encode($nilaiArray), // Simpan sebagai JSON string
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Nilaisosial Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('nilaisosial.all')->with($notification);
    }


    public function NilaisosialUpdate(Request $request)
    {

        $nilaisosial_id = $request->id;
        $nilaiArray = array(
            '0' => $request->input('nilai_kejujuran'),
            '1' => $request->input('nilai_kedisiplinan'),
            '2' => $request->input('nilai_tanggungjawab'),
            '3' => $request->input('nilai_toleransi'),
            '4' => $request->input('nilai_gotongroyong'),
            '5' => $request->input('nilai_kesantunan'),
            '6' => $request->input('nilai_percayadiri'),
        );

        Nilaisosial::findOrFail($nilaisosial_id)->update([
            'id_walas' => $request->id_walas,
            'id_siswa' => $request->id_siswa,
            'nilai' => json_encode($nilaiArray),
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Nilaisosial Updated SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('nilaisosial.all')->with($notification);
    } // end method


    public function NilaispiritualAll()
    {


        $guruId = Guru::where('id_user', Auth::user()->id)->first();
        $walas = Walas::where('id_guru', $guruId->id)->orderBy('id', 'asc')->first();
        $siswa = null; // inisialisasi variabel $siswa
        if ($walas) {
            $siswa = Siswa::where('kelas', $walas->id_kelas)->orderBy('nama', 'asc')->get();
        }

        $data = [
            'walas' => $walas,
            'siswa' => $siswa,
        ];
        return view('backend.data.rapor.nilaiwalas.nilaispiritual_all', compact('walas', 'data', 'siswa'));
    } // end method


    public function NilaispiritualStore(Request $request)
    {
        $nilaiArray = array(
            '0' => $request->input('nilai_berdoa'),
            '1' => $request->input('nilai_memberisalam'),
            '2' => $request->input('nilai_shalatberjamaah'),
            '3' => $request->input('nilai_bersyukur'),

        );

        Nilaispiritual::insert([
            'id_walas' => $request->id_walas,
            'id_siswa' => $request->id_siswa,
            'nilai' => json_encode($nilaiArray), // Simpan sebagai JSON string
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Nilai Spiritual Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('nilaispiritual.all')->with($notification);
    }


    public function NilaispiritualUpdate(Request $request)
    {

        $nilaisosial_id = $request->id;
        $nilaiArray = array(
            '0' => $request->input('nilai_berdoa'),
            '1' => $request->input('nilai_memberisalam'),
            '2' => $request->input('nilai_shalatberjamaah'),
            '3' => $request->input('nilai_bersyukur'),

        );

        Nilaispiritual::findOrFail($nilaisosial_id)->update([
            'id_walas' => $request->id_walas,
            'id_siswa' => $request->id_siswa,
            'nilai' => json_encode($nilaiArray),
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Nilai Spiritual Updated SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('nilaispiritual.all')->with($notification);
    } // end method




    public function NilaiprestasiAll()
    {

        $guruId = Guru::where('id_user', Auth::user()->id)->first();
        $walas = Walas::where('id_guru', $guruId->id)->orderBy('id', 'asc')->first();
        $siswa = null; // inisialisasi variabel $siswa
        if ($walas) {
            $siswa = Siswa::where('kelas', $walas->id_kelas)->orderBy('nama', 'asc')->get();
        }

        $data = [
            'walas' => $walas,
            'siswa' => $siswa,
        ];
        return view('backend.data.rapor.nilaiwalas.nilaiprestasi_all', compact('walas', 'data', 'siswa'));
    } // end method


    public function NilaiprestasiStore(Request $request)
    {

        Nilaiprestasi::insert([
            'id_walas' => $request->id_walas,
            'id_siswa' => $request->id_siswa,
            'nama' => $request->nama,
            'ket' => $request->ket,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Nilai Prestasi Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('nilaiprestasi.all')->with($notification);
    } // end method


    public function NilaiprestasiUpdate(Request $request)
    {

        $nilaiprestasi_id = $request->id;
        Nilaiprestasi::findOrFail($nilaiprestasi_id)->update([
            'id_walas' => $request->id_walas,
            'id_siswa' => $request->id_siswa,
            'nama' => $request->nama,
            'ket' => $request->ket,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Nilai Prestasi Updated SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('nilaiprestasi.all')->with($notification);
    } // end method

}
