<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Cttnwalas;
use App\Models\Guru;
use App\Models\Jadwalmapel;
use App\Models\Kd3;
use App\Models\Kelas;
use App\Models\Ki3;
use App\Models\Ki4;
use App\Models\Mapel;
use App\Models\Pengampu;
use App\Models\Rombel;
use App\Models\Rombelsiswa;
use App\Models\Seksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StandarkompetensiController extends Controller
{
    public function SkAll($id)
    {
        // $userId = Auth::user()->id;
        // $guru = Guru::where('id_user', $userId)->first();

        // $pengampu = Pengampu::where('id_guru', $guru->id)->get();
        // $pengampuIds = $pengampu->pluck('id')->toArray();
        // $jadwalguru = Jadwalmapel::whereIn('id_pengampu', $pengampuIds)->get();
        // $jadwalguruIds = $jadwalguru->pluck('id')->toArray();
        // $seksi = Seksi::whereIn('id_jadwal', $jadwalguruIds)->get();
        // $jadwalguru2 = Jadwalmapel::whereIn('id', $seksi->pluck('id_jadwal')->toArray())->get();
        // $pengampu2 = Pengampu::whereIn('id', $jadwalguru2->pluck('id_pengampu')->toArray())->get();

        // $uniqueRecords = [];
        // $filteredPengampu2 = collect();
        // foreach ($pengampu2 as $item) {
        //     $kelas = Kelas::find($item->kelas); // Ubah kueri untuk mendapatkan kelas berdasarkan id_kelas
        //     $key = $item->id_mapel . '-' . $kelas->tingkat; // Menggunakan ID Mapel dan Tingkat sebagai kunci

        //     if (!in_array($key, $uniqueRecords)) {
        //         $filteredPengampu2->push($item);
        //         $uniqueRecords[] = $key;
        //     }
        // }



        $ki3 = Ki3::where('id_seksi', $id)->get();
        $ki4 = Ki4::where('id_seksi', $id)->get();
        $ki3data = Ki3::where('id_seksi', $id)->first();
        $kd3 = Kd3::where('id_ki3', $ki3data->id)->get();

        //$ki4 = Ki4::where('id_seksi', $id)->get();


        return view('backend.data.standar_kompetensi.sk_all',  compact('ki3data', 'kd3', 'ki3', 'ki4'));
    }


    public function ki3Update(Request $request)
    {

        $ki3_id = $request->id;
        Ki3::findOrFail($ki3_id)->update([
            'ket' => $request->ket,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);



        $notification = array(
            'message' => 'Ki3 Updated SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // end method

    public function ki4Update(Request $request)
    {

        $ki4_id = $request->id;
        Ki4::findOrFail($ki4_id)->update([
            'ket' => $request->ket,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Ki4 Updated SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // end method



    public function Kd3Store(Request $request)
    {

        Kd3::insert([
            'id_ki3' => $request->id_ki3,
            'urutan' => $request->urutan,
            'ket' => $request->ket,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Kd3 Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // end method



}
