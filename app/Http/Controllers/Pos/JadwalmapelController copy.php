<?php

namespace App\Http\Controllers\Pos;

use App\Exports\JadwalmapelguruExport;
use App\Exports\JadwalmapelsExport;
use App\Exports\JadwalmapelskepsekExport;
use App\Http\Controllers\Controller;
use App\Models\Hari;
use App\Models\Jadwalmapel;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\OrangTua;
use App\Models\Pengampu;
use App\Models\Rombel;
use App\Models\Rombelsiswa;
use App\Models\Ruangan;
use App\Models\Seksi;
use App\Models\Siswa;
use App\Models\Tahunajar;
use App\Models\Waktu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class JadwalmapelController extends Controller
{
    public function JadwalmapelAll(Request $request)
    {

        // Bagian search Data //
        $searchHari = $request->input('searchhari');
        $searchGuru = $request->input('searchguru');
        $searchMapel = $request->input('searchmapel');
        $searchKelas = $request->input('searchkelas');
        $searchTahun = $request->input('searchtahun');

        $query = Jadwalmapel::query();

        // Filter berdasarkan nama hari 
        if (!empty($searchHari)) {
            $query->whereHas('haris', function ($lecturerQuery) use ($searchHari) {
                $lecturerQuery->where('nama', 'LIKE', '%' . $searchHari . '%');
            });
        }

        // Filter berdasarkan nama guru 
        if (!empty($searchGuru)) {
            $query->whereHas('pengampus', function ($teachQuery) use ($searchGuru) {
                $teachQuery->whereHas('gurus', function ($courseQuery) use ($searchGuru) {
                    $courseQuery->where('nama', 'LIKE', '%' .   $searchGuru . '%');
                });
            });
        }

        // Filter berdasarkan nama mata Pelajaran jika searchcourse tidak kosong
        if (!empty($searchMapel)) {
            $query->whereHas('pengampus', function ($teachQuery) use ($searchMapel) {
                $teachQuery->whereHas('mapels', function ($courseQuery) use ($searchMapel) {
                    $courseQuery->where('nama', 'LIKE', '%' .   $searchMapel . '%');
                });
            });
        }

        // Filter berdasarkan nama kelas jika searchclass tidak kosong
        if (!empty($searchKelas)) {
            $query->whereHas('pengampus', function ($lecturerQuery) use ($searchKelas) {
                $lecturerQuery->whereHas('kelass', function ($courseQuery) use ($searchKelas) {
                    $courseQuery->where('id', 'LIKE', '%' .  $searchKelas . '%');
                });
            });
        }

        if (!empty($searchTahun)) {
            $query->whereHas('tahun', function ($lecturerQuery) use ($searchTahun) {
                $lecturerQuery->where('id', 'LIKE', '%' . $searchTahun . '%');
            });
        }
        // End Bagian search Data //

        $tanggalSaatIni = Carbon::now();

        // Mendapatkan semester saat ini berdasarkan bulan
        $semesterSaatIni = ($tanggalSaatIni->month >= 1 && $tanggalSaatIni->month <= 6) ? 'Genap' : 'Ganjil';

        // Mendapatkan tahun saat ini
        $tahunSaatIni = $tanggalSaatIni->format('Y');

        // Mendapatkan data tahun ajar yang sesuai dengan tahun dan semester saat ini
        $tahunAjarSaatIni = Tahunajar::where('tahun', 'like', '%' . $tahunSaatIni . '%')
            ->where('semester', $semesterSaatIni)
            ->first();
        $tahunAjartidakSaatIni = Tahunajar::whereNotIn('tahun', [$tahunSaatIni])
            ->where('semester', $semesterSaatIni)
            ->first();


        if (
            $searchTahun ==  $tahunAjartidakSaatIni->id
        ) {

            $jadwalmapel = $query
                ->orderBy('id_hari')
                ->orderBy('id_Waktu', 'asc')
                ->get();

            $jadwal = $jadwalmapel->first();
        } elseif ($searchTahun) {

            $jadwalmapel = $query
                ->orderBy('id_hari')
                ->orderBy('id_Waktu', 'asc')
                ->get();
            $jadwal = $jadwalmapel->first();
        } else {

            $jadwalmapel = $query

                ->orderBy('id_hari')
                ->orderBy('id_Waktu', 'asc')
                ->where('id_tahunajar', $tahunAjarSaatIni->id)
                ->get();
            $jadwal = $jadwalmapel->first();
        }

        $hari = Hari::orderby('kode_hari', 'asc')->get();

        $waktu = Waktu::all();
        $ruangan = Ruangan::all();

        $mapel = Mapel::all();
        $tahunajar = Tahunajar::all();

        $pengampu = Pengampu::orderby('id', 'asc')
            // ->whereNotIn('id', function ($query) {
            //     $query->select('id_pengampu')
            //         ->from('jadwalmapels');
            // })
            ->get();


        $datatahun = Tahunajar::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('jadwalmapels')
                ->whereRaw('jadwalmapels.id_tahunajar = tahunajars.id');
        })->orderby('id', 'desc')
            ->get();



        $kelas = Kelas::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('pengampus')
                ->join('jadwalmapels', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
                ->whereRaw('pengampus.kelas = kelas.id');
        })->orderBy('id', 'desc')
            ->get();

        $tahun = Tahunajar::whereIn('id', function ($query) {
            $query->select('id_tahunajar')
                ->from('pengampus');
        })->orderBy('id')
            ->get();
        $datatahunpengampu = Tahunajar::whereIn('id', function ($query) {
            $query->select('id_tahunajar')
                ->from('pengampus');
        })->orderBy('id')
            ->get();
        return view('backend.data.jadwalmapel.jadwalmapel_all', compact('datatahunpengampu', 'datatahun', 'jadwal', 'tahunajar', 'kelas', 'pengampu', 'ruangan', 'mapel',  'hari', 'waktu',  'jadwalmapel'));
    } // end method


    public function jadwalMapelStore(Request $request)
    {
        $guruInput = Pengampu::where('id', $request->id_pengampu)->first();

        $guru = DB::table('jadwalmapels')
            ->join('pengampus', 'pengampus.id', '=', 'jadwalmapels.id_pengampu')
            ->select('pengampus.kelas', 'pengampus.id_guru')
            ->first();
        $tanggal = Carbon::now()->toDateString(); // '2023-10-17'
        $tanggal_tanpa_strip = str_replace("-", "", $tanggal); // '20231017'

        // Generate 4 random digits
        $kode_acak = mt_rand(1000, 9999);
        do {
            $kode_jadwalmapel = $tanggal_tanpa_strip . '.' . $kode_acak;
            $existingPengampu = Jadwalmapel::where('kode_jadwalmapel', $kode_jadwalmapel)->first();
        } while (!empty($existingPengampu));

        if (!$guru) {
            Jadwalmapel::insert([
                'kode_jadwalmapel' => $kode_jadwalmapel,
                'id_pengampu' => $request->id_pengampu,
                'id_hari' => $request->id_hari,
                'id_waktu' => $request->id_waktu,
                'id_ruangan' => $request->id_ruangan,
                'id_tahunajar' => $request->id_tahunajar,
                'status' => '0',
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Jadwal Inserted Successfully kode ',
                'alert-type' => 'success'
            );
            return redirect()->route('jadwalmapel.all')->with($notification);
        }



        if ($guruInput->id_guru == $guru->id_guru || $guruInput->kelas == $guru->kelas) {
            $existingData = Jadwalmapel::where('id_hari', $request->id_hari)
                ->where('id_waktu', $request->id_waktu)
                ->count();

            if ($existingData > 0) {
                $notification = array(
                    'message' => 'Data Jadwal Mapel Bentrok..!!',
                    'alert-type' => 'warning'
                );
                return redirect()->back()->with($notification);
            } else {
                Jadwalmapel::insert([
                    'kode_jadwalmapel' => $kode_jadwalmapel,
                    'id_pengampu' => $request->id_pengampu,
                    'id_hari' => $request->id_hari,
                    'id_waktu' => $request->id_waktu,
                    'id_tahunajar' => $request->id_tahunajar,
                    'id_ruangan' => $request->id_ruangan,
                    'status' => '0',
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                ]);

                $notification = array(
                    'message' => 'Jadwal Inserted Successfully',
                    'alert-type' => 'success'
                );
                return redirect()->route('jadwalmapel.all')->with($notification);
            }
        } else {
            Jadwalmapel::insert([
                'kode_jadwalmapel' => $kode_jadwalmapel,
                'id_pengampu' => $request->id_pengampu,
                'id_hari' => $request->id_hari,
                'id_waktu' => $request->id_waktu,
                'id_ruangan' => $request->id_ruangan,
                'id_tahunajar' => $request->id_tahunajar,
                'status' => '0',
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Jadwal Inserted Successfully kode ',
                'alert-type' => 'success'
            );
            return redirect()->route('jadwalmapel.all')->with($notification);
        }
    } // end method



    public function JadwalmapelUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'id_hari' => 'required',
            'id_waktu' => 'required',
            'id_ruangan' => 'required',
        ]);

        // Mengambil data jadwal berdasarkan $id
        $jadwalmapel = Jadwalmapel::find($id);

        // Cek untuk memastikan tidak ada bentrok jadwal saat memperbarui
        $existingData = Jadwalmapel::where('id_hari', $request->id_hari)
            ->where('id_waktu', $request->id_waktu)
            ->where('id', '!=', $id) // untuk menghindari membandingkan dengan dirinya sendiri
            ->count();

        // Jika ada bentrok, kirim notifikasi
        if ($existingData > 0) {
            $notification = array(
                'message' => 'Data Jadwal Mapel Bentrok saat Update..!!',
                'alert-type' => 'warning'
            );
            return redirect()->back()->with($notification);
        }

        // Lakukan pembaruan pada nilai kolom-kolom jadwal berdasarkan data yang diterima dari formulir
        $jadwalmapel->id_hari = $request->input('id_hari');
        $jadwalmapel->id_waktu = $request->input('id_waktu');
        $jadwalmapel->id_ruangan = $request->input('id_ruangan');
        $jadwalmapel->id_tahunajar = $request->input('id_tahunajar');

        // Tambahkan pembaruan lain sesuai kebutuhan Anda

        // Menyimpan perubahan ke dalam database
        $jadwalmapel->save();

        $notification = array(
            'message' => 'Jadwal Sementara Update SuccessFully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // end method



    public function JadwalmapelDelete($id)
    {
        // Hapus Jadwalmapel berdasarkan ID
        $jadwalmapel = Jadwalmapel::findOrFail($id);
        $jadwalmapel->delete();

        // Hapus Seksi berdasarkan id_jadwal
        $seksi = Seksi::where('id_jadwal', $id)->delete();

        // Hapus Nilai berdasarkan id_seksi
        // Perlu mengecek apakah $seksi ditemukan sebelum mengakses properti id-nya
        if ($seksi) {
            Nilai::where('id_seksi', $seksi->id)->delete();
        }

        $notification = array(
            'message' => 'Jadwal Deleted Successfully',
            'alert-type' => 'success'
        );

        // Kembalikan ke halaman sebelumnya dengan notifikasi
        return redirect()->back()->with($notification);
    } // end method
    // end method

    public function JadwalmapelstatusOne($id)
    {
        $jadwalmapel = Jadwalmapel::find($id);
        $jadwalmapel->status = '1';
        $jadwalmapel->save();
        $notification = array(
            'message' => 'Jadwal Berhasil Di Kirim SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // end method



    public function JadwalmapelstatusAll()
    {

        Jadwalmapel::where('status', '=', 0)
            ->orWhere('status', '=', 3)
            ->update(['status' => 1]);


        $notification = array(
            'message' => 'Jadwal Berhasil Di Kirim SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // end method


    public function JadwalmapelKepsek(Request $request)
    {

        // Bagian search Data //
        $searchHari = $request->input('searchhari');
        $searchGuru = $request->input('searchguru');
        $searchMapel = $request->input('searchmapel');
        $searchKelas = $request->input('searchkelas');
        $searchTahun = $request->input('searchtahun');

        $query = Jadwalmapel::query();

        // Filter berdasarkan nama hari 
        if (!empty($searchHari)) {
            $query->whereHas('haris', function ($lecturerQuery) use ($searchHari) {
                $lecturerQuery->where('nama', 'LIKE', '%' . $searchHari . '%');
            });
        }

        // Filter berdasarkan nama guru 
        if (!empty($searchGuru)) {
            $query->whereHas('pengampus', function ($teachQuery) use ($searchGuru) {
                $teachQuery->whereHas('gurus', function ($courseQuery) use ($searchGuru) {
                    $courseQuery->where('nama', 'LIKE', '%' .   $searchGuru . '%');
                });
            });
        }

        // Filter berdasarkan nama mata Pelajaran jika searchcourse tidak kosong
        if (!empty($searchMapel)) {
            $query->whereHas('pengampus', function ($teachQuery) use ($searchMapel) {
                $teachQuery->whereHas('mapels', function ($courseQuery) use ($searchMapel) {
                    $courseQuery->where('nama', 'LIKE', '%' .   $searchMapel . '%');
                });
            });
        }

        // Filter berdasarkan nama kelas jika searchclass tidak kosong
        if (!empty($searchKelas)) {
            $query->whereHas('pengampus', function ($lecturerQuery) use ($searchKelas) {
                $lecturerQuery->whereHas('kelass', function ($courseQuery) use ($searchKelas) {
                    $courseQuery->where('id', 'LIKE', '%' .  $searchKelas . '%');
                });
            });
        }

        if (!empty($searchTahun)) {
            $query->whereHas('tahun', function ($lecturerQuery) use ($searchTahun) {
                $lecturerQuery->where('id', 'LIKE', '%' . $searchTahun . '%');
            });
        }
        // End Bagian search Data //

        $tanggalSaatIni = Carbon::now();

        // Mendapatkan semester saat ini berdasarkan bulan
        $semesterSaatIni = ($tanggalSaatIni->month >= 1 && $tanggalSaatIni->month <= 6) ? 'Genap' : 'Ganjil';

        // Mendapatkan tahun saat ini
        $tahunSaatIni = $tanggalSaatIni->format('Y');

        // Mendapatkan data tahun ajar yang sesuai dengan tahun dan semester saat ini
        $tahunAjarSaatIni = Tahunajar::where('tahun', 'like', '%' . $tahunSaatIni . '%')
            ->where('semester', $semesterSaatIni)
            ->first();
        $tahunAjartidakSaatIni = Tahunajar::whereNotIn('tahun', [$tahunSaatIni])
            ->where('semester', $semesterSaatIni)
            ->first();


        if (
            $searchTahun ==  $tahunAjartidakSaatIni->id
        ) {

            $jadwalmapel = $query
                ->where('status', '>=', 1)
                ->where('status', '<=', 3)
                ->orderBy('id_hari')
                ->orderBy('id_Waktu', 'desc')
                ->get();
            $jadwal = $jadwalmapel->first();
        } elseif ($searchTahun) {

            $jadwalmapel = $query
                ->where('status', '>=', 1)
                ->where('status', '<=', 3)
                ->orderBy('id_hari')
                ->orderBy('id_Waktu', 'desc')
                ->get();
            $jadwal = $jadwalmapel->first();
        } else {


            $jadwalmapel = $query
                ->where('status', '>=', 1)
                ->where('status', '<=', 3)
                ->orderBy('id_hari')
                ->orderBy('id_Waktu', 'desc')
                ->where('id_tahunajar', $tahunAjarSaatIni->id)
                ->get();
            $jadwal = $jadwalmapel->first();
        }


        $datatahun = Tahunajar::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('jadwalmapels')
                ->whereRaw('jadwalmapels.id_tahunajar = tahunajars.id');
        })->orderby('id', 'desc')
            ->get();

        $hari = Hari::all();

        $waktu = Waktu::all();
        $ruangan = Ruangan::all();

        $mapel = Mapel::all();

        $pengampu = Pengampu::all();
        $kelas = Kelas::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('pengampus')
                ->join('jadwalmapels', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
                ->whereRaw('pengampus.kelas = kelas.id');
        })->orderBy('id', 'desc')
            ->get();
        return view('backend.data.jadwalmapel.jadwalmapel_kepsek', compact('datatahun', 'jadwal', 'kelas', 'pengampu', 'ruangan', 'mapel',  'hari', 'waktu',  'jadwalmapel'));
    } // end method



    public function JadwalmapelverifikasiOne($id)
    {
        $jadwalmapel = Jadwalmapel::find($id);
        $jadwalmapel->status = '2';
        $jadwalmapel->save();
        $notification = array(
            'message' => 'Jadwal Berhasil Di Verifikasi SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // end method



    public function JadwalmapelverifikasiAll()
    {

        Jadwalmapel::where('status', '=', 1)
            ->update(['status' => 2]);

        $notification = array(
            'message' => 'Jadwal Berhasil Di Verifikasi SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // end method


    public function JadwalmapeltolakOne($id)
    {
        $jadwalmapel = Jadwalmapel::find($id);
        $jadwalmapel->status = '3';
        $jadwalmapel->save();
        $notification = array(
            'message' => 'Jadwal Berhasil Di Verifikasi SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // end method


    public function JadwalmapelGuru(Request $request)
    {

        // Bagian search Data //
        $searchHari = $request->input('searchhari');
        $searchGuru = $request->input('searchguru');
        $searchMapel = $request->input('searchmapel');
        $searchKelas = $request->input('searchkelas');
        $searchTahun = $request->input('searchtahun');

        $query = Jadwalmapel::query();

        // Filter berdasarkan nama hari 
        if (!empty($searchHari)) {
            $query->whereHas('haris', function ($lecturerQuery) use ($searchHari) {
                $lecturerQuery->where('nama', 'LIKE', '%' . $searchHari . '%');
            });
        }

        // Filter berdasarkan nama guru 
        if (!empty($searchGuru)) {
            $query->whereHas('pengampus', function ($teachQuery) use ($searchGuru) {
                $teachQuery->whereHas('gurus', function ($courseQuery) use ($searchGuru) {
                    $courseQuery->where('nama', 'LIKE', '%' .   $searchGuru . '%');
                });
            });
        }

        // Filter berdasarkan nama mata Pelajaran jika searchcourse tidak kosong
        if (!empty($searchMapel)) {
            $query->whereHas('pengampus', function ($teachQuery) use ($searchMapel) {
                $teachQuery->whereHas('mapels', function ($courseQuery) use ($searchMapel) {
                    $courseQuery->where('nama', 'LIKE', '%' .   $searchMapel . '%');
                });
            });
        }

        // Filter berdasarkan nama kelas jika searchclass tidak kosong
        if (!empty($searchKelas)) {
            $query->whereHas('pengampus', function ($lecturerQuery) use ($searchKelas) {
                $lecturerQuery->whereHas('kelass', function ($courseQuery) use ($searchKelas) {
                    $courseQuery->where('id', 'LIKE', '%' .  $searchKelas . '%');
                });
            });
        }
        // End Bagian search Data //
        if (!empty($searchTahun)) {
            $query->whereHas('tahun', function ($lecturerQuery) use ($searchTahun) {
                $lecturerQuery->where('id', 'LIKE', '%' . $searchTahun . '%');
            });
        }
        $tanggalSaatIni = Carbon::now();

        // Mendapatkan semester saat ini berdasarkan bulan
        $semesterSaatIni = ($tanggalSaatIni->month >= 1 && $tanggalSaatIni->month <= 6) ? 'Genap' : 'Ganjil';

        // Mendapatkan tahun saat ini
        $tahunSaatIni = $tanggalSaatIni->format('Y');

        // Mendapatkan data tahun ajar yang sesuai dengan tahun dan semester saat ini
        $tahunAjarSaatIni = Tahunajar::where('tahun', 'like', '%' . $tahunSaatIni . '%')
            ->where('semester', $semesterSaatIni)
            ->first();
        $tahunAjartidakSaatIni = Tahunajar::whereNotIn('tahun', [$tahunSaatIni])
            ->where('semester', $semesterSaatIni)
            ->first();

        if (
            $searchTahun ==  $tahunAjartidakSaatIni->id
        ) {

            $userId = Auth::user()->id;

            $jadwalmapel = $query
                ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
                ->join('gurus', 'pengampus.id_guru', '=', 'gurus.id')
                ->where('status', '=', '2')
                ->where('gurus.id_user', '=', $userId)
                ->orderBy('id_hari')
                ->orderBy('id_Waktu', 'desc')
                ->get();
            $jadwal = $jadwalmapel->first();
        } elseif ($searchTahun) {


            $userId = Auth::user()->id;

            $jadwalmapel = $query
                ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
                ->join('gurus', 'pengampus.id_guru', '=', 'gurus.id')
                ->where('status', '=', '2')
                ->where('gurus.id_user', '=', $userId)
                ->orderBy('id_hari')
                ->orderBy('id_Waktu', 'desc')
                ->get();
            $jadwal = $jadwalmapel->first();
        } else {

            $userId = Auth::user()->id;

            $jadwalmapel = $query
                ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
                ->join('gurus', 'pengampus.id_guru', '=', 'gurus.id')
                ->where('status', '=', '2')
                ->where('gurus.id_user', '=', $userId)
                ->orderBy('id_hari')
                ->orderBy('id_Waktu', 'desc')
                ->where('id_tahunajar', $tahunAjarSaatIni->id)
                ->get();
            $jadwal = $jadwalmapel->first();
        }


        $datatahun = Tahunajar::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('jadwalmapels')
                ->whereRaw('jadwalmapels.id_tahunajar = tahunajars.id');
        })->orderby('id', 'desc')
            ->get();
        $userId = Auth::user()->id;

        $kelas = Kelas::whereExists(function ($query) use ($userId) {
            $query->select(DB::raw(1))
                ->from('pengampus')
                ->join('jadwalmapels', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
                ->join('gurus', 'pengampus.id_guru', '=', 'gurus.id')
                ->where('gurus.id_user', '=', $userId)
                ->whereRaw('pengampus.kelas = kelas.id');
        })->orderBy('id', 'desc')
            ->get();
        return view('backend.data.jadwalmapel.jadwalmapel_guru', compact('jadwal', 'datatahun', 'kelas', 'jadwalmapel'));
    } // end method


    public function JadwalmapelSiswa(Request $request)
    {

        // Bagian search Data //
        $searchHari = $request->input('searchhari');
        $searchGuru = $request->input('searchguru');
        $searchMapel = $request->input('searchmapel');
        $searchTahun = $request->input('searchtahun');

        $query = Jadwalmapel::query();

        // Filter berdasarkan nama hari 
        if (!empty($searchHari)) {
            $query->whereHas('haris', function ($lecturerQuery) use ($searchHari) {
                $lecturerQuery->where('nama', 'LIKE', '%' . $searchHari . '%');
            });
        }

        // Filter berdasarkan nama guru 
        if (!empty($searchGuru)) {
            $query->whereHas('pengampus', function ($teachQuery) use ($searchGuru) {
                $teachQuery->whereHas('gurus', function ($courseQuery) use ($searchGuru) {
                    $courseQuery->where('nama', 'LIKE', '%' .   $searchGuru . '%');
                });
            });
        }

        // Filter berdasarkan nama mata Pelajaran jika searchcourse tidak kosong
        if (!empty($searchMapel)) {
            $query->whereHas('pengampus', function ($teachQuery) use ($searchMapel) {
                $teachQuery->whereHas('mapels', function ($courseQuery) use ($searchMapel) {
                    $courseQuery->where('nama', 'LIKE', '%' .   $searchMapel . '%');
                });
            });
        }

        if (!empty($searchTahun)) {
            $query->whereHas('tahun', function ($lecturerQuery) use ($searchTahun) {
                $lecturerQuery->where('id', 'LIKE', '%' . $searchTahun . '%');
            });
        }

        // End Bagian search Data //

        $tanggalSaatIni = Carbon::now();

        // Mendapatkan semester saat ini berdasarkan bulan
        $semesterSaatIni = ($tanggalSaatIni->month >= 1 && $tanggalSaatIni->month <= 6) ? 'Genap' : 'Ganjil';

        // Mendapatkan tahun saat ini
        $tahunSaatIni = $tanggalSaatIni->format('Y');

        // Mendapatkan data tahun ajar yang sesuai dengan tahun dan semester saat ini
        $tahunAjarSaatIni = Tahunajar::where('tahun', 'like', '%' . $tahunSaatIni . '%')
            ->where('semester', $semesterSaatIni)
            ->first();
        $tahunAjartidakSaatIni = Tahunajar::whereNotIn('tahun', [$tahunSaatIni])
            ->where('semester', $semesterSaatIni)
            ->first();

        if (
            $searchTahun ==  $tahunAjartidakSaatIni->id
        ) {

            $userId = Auth::user()->id;

            $jadwalmapel = $query

                ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')

                ->join('rombels', 'pengampus.kelas', '=', 'rombels.id_kelas')
                ->join('rombelsiswas', 'rombels.id', '=', 'rombelsiswas.id_rombel')
                ->join('siswas', 'rombelsiswas.id_siswa', '=', 'siswas.id')
                ->where('status', '=', '2')
                ->where('siswas.id_user', '=', $userId)
                ->orderBy('id_hari')
                ->orderBy('id_Waktu', 'desc')
                ->get();
            $jadwal = $jadwalmapel->first();
        } elseif ($searchTahun) {


            $userId = Auth::user()->id;

            $jadwalmapel = $query

                ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')

                ->join('rombels', 'pengampus.kelas', '=', 'rombels.id_kelas')
                ->join('rombelsiswas', 'rombels.id', '=', 'rombelsiswas.id_rombel')
                ->join('siswas', 'rombelsiswas.id_siswa', '=', 'siswas.id')
                ->where('status', '=', '2')
                ->where('siswas.id_user', '=', $userId)
                ->orderBy('id_hari')
                ->orderBy('id_Waktu', 'desc')

                ->get();
            $jadwal = $jadwalmapel->first();
        } else {

            $userId = Auth::user()->id;

            $jadwalmapel = $query

                ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')

                ->join('rombels', 'pengampus.kelas', '=', 'rombels.id_kelas')
                ->join('rombelsiswas', 'rombels.id', '=', 'rombelsiswas.id_rombel')
                ->join('siswas', 'rombelsiswas.id_siswa', '=', 'siswas.id')
                ->where('status', '=', '2')
                ->where('siswas.id_user', '=', $userId)
                ->orderBy('id_hari')
                ->orderBy('id_Waktu', 'desc')
                ->where('id_tahunajar', $tahunAjarSaatIni->id)
                ->get();
            $jadwal = $jadwalmapel->first();
        }


        $datatahun = Tahunajar::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('jadwalmapels')
                ->whereRaw('jadwalmapels.id_tahunajar = tahunajars.id');
        })->orderby('id', 'desc')
            ->get();


        $kelas = Kelas::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('pengampus')
                ->join('jadwalmapels', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
                ->whereRaw('pengampus.kelas = kelas.id');
        })->orderBy('id', 'desc')
            ->get();
        return view('backend.data.jadwalmapel.jadwalmapel_siswa', compact('jadwal', 'datatahun', 'kelas', 'jadwalmapel'));
    } // end method


    public function JadwalmapelOrtu(Request $request)
    {

        // Bagian search Data //
        $searchHari = $request->input('searchhari');
        $searchGuru = $request->input('searchguru');
        $searchMapel = $request->input('searchmapel');
        $searchTahun = $request->input('searchtahun');

        $query = Jadwalmapel::query();

        // Filter berdasarkan nama hari 
        if (!empty($searchHari)) {
            $query->whereHas('haris', function ($lecturerQuery) use ($searchHari) {
                $lecturerQuery->where('nama', 'LIKE', '%' . $searchHari . '%');
            });
        }

        // Filter berdasarkan nama guru 
        if (!empty($searchGuru)) {
            $query->whereHas('pengampus', function ($teachQuery) use ($searchGuru) {
                $teachQuery->whereHas('gurus', function ($courseQuery) use ($searchGuru) {
                    $courseQuery->where('nama', 'LIKE', '%' .   $searchGuru . '%');
                });
            });
        }

        // Filter berdasarkan nama mata Pelajaran jika searchcourse tidak kosong
        if (!empty($searchMapel)) {
            $query->whereHas('pengampus', function ($teachQuery) use ($searchMapel) {
                $teachQuery->whereHas('mapels', function ($courseQuery) use ($searchMapel) {
                    $courseQuery->where('nama', 'LIKE', '%' .   $searchMapel . '%');
                });
            });
        }

        if (!empty($searchTahun)) {
            $query->whereHas('tahun', function ($lecturerQuery) use ($searchTahun) {
                $lecturerQuery->where('id', 'LIKE', '%' . $searchTahun . '%');
            });
        }
        // End Bagian search Data //

        $tanggalSaatIni = Carbon::now();

        // Mendapatkan semester saat ini berdasarkan bulan
        $semesterSaatIni = ($tanggalSaatIni->month >= 1 && $tanggalSaatIni->month <= 6) ? 'Genap' : 'Ganjil';

        // Mendapatkan tahun saat ini
        $tahunSaatIni = $tanggalSaatIni->format('Y');

        // Mendapatkan data tahun ajar yang sesuai dengan tahun dan semester saat ini
        $tahunAjarSaatIni = Tahunajar::where('tahun', 'like', '%' . $tahunSaatIni . '%')
            ->where('semester', $semesterSaatIni)
            ->first();
        $tahunAjartidakSaatIni = Tahunajar::whereNotIn('tahun', [$tahunSaatIni])
            ->where('semester', $semesterSaatIni)
            ->first();
        if (
            $searchTahun ==  $tahunAjartidakSaatIni->id
        ) {

            $userId = Auth::user()->id;

            $ortu = OrangTua::where('id_user', $userId)->first();
            $siswa = Siswa::where('id', $ortu->id_siswa)->first();
            $rombelsiswa = Rombelsiswa::where('id_siswa', $siswa->id)->first();
            $rombel = Rombel::where('id', $rombelsiswa->id_rombel)->first();
            $pengampu = Pengampu::where('kelas', $rombel->id_kelas)->get();

            $pengampuId =   $pengampu->pluck('id')->toArray();


            $jadwalmapel = $query
                ->whereIn('id_pengampu', $pengampuId)
                ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
                ->where('status', '=', '2')
                ->orderBy('id_hari')
                ->orderBy('id_Waktu', 'desc')
                ->get();
            $jadwal = $jadwalmapel->first();
        } elseif ($searchTahun) {


            $userId = Auth::user()->id;

            $ortu = OrangTua::where('id_user', $userId)->first();
            $siswa = Siswa::where('id', $ortu->id_siswa)->first();
            $rombelsiswa = Rombelsiswa::where('id_siswa', $siswa->id)->first();
            $rombel = Rombel::where('id', $rombelsiswa->id_rombel)->first();
            $pengampu = Pengampu::where('kelas', $rombel->id_kelas)->get();

            $pengampuId =   $pengampu->pluck('id')->toArray();


            $jadwalmapel = $query
                ->whereIn('id_pengampu', $pengampuId)
                ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
                ->where('status', '=', '2')
                ->orderBy('id_hari')
                ->orderBy('id_Waktu', 'desc')
                ->get();
            $jadwal = $jadwalmapel->first();
        } else {

            $userId = Auth::user()->id;

            $ortu = OrangTua::where('id_user', $userId)->first();
            $siswa = Siswa::where('id', $ortu->id_siswa)->first();
            $rombelsiswa = Rombelsiswa::where('id_siswa', $siswa->id)->first();
            $rombel = Rombel::where('id', $rombelsiswa->id_rombel)->first();
            $pengampu = Pengampu::where('kelas', $rombel->id_kelas)->get();

            $pengampuId =   $pengampu->pluck('id')->toArray();


            $jadwalmapel = $query
                ->whereIn('id_pengampu', $pengampuId)
                ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
                ->where('status', '=', '2')
                ->orderBy('id_hari')
                ->orderBy('id_Waktu', 'desc')
                ->where('id_tahunajar', $tahunAjarSaatIni->id)
                ->get();
            $jadwal = $jadwalmapel->first();
        }


        $datatahun = Tahunajar::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('jadwalmapels')
                ->whereRaw('jadwalmapels.id_tahunajar = tahunajars.id');
        })->orderby('id', 'desc')
            ->get();

        $kelas = Kelas::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('pengampus')
                ->join('jadwalmapels', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
                ->whereRaw('pengampus.kelas = kelas.id');
        })->orderBy('id', 'desc')
            ->get();
        return view('backend.data.jadwalmapel.jadwalmapel_ortu', compact('jadwal', 'datatahun', 'kelas', 'jadwalmapel'));
    } // end method



    public function JadwalmapelsExport(Request $request)
    {
        $tahunId =  $request->input('tahun');

        $jadwalmapel = Jadwalmapel::orderBy('id_hari')
            ->orderBy('id_Waktu', 'desc')
            ->where('id_tahunajar', $tahunId)
            ->get();
        $jadwal = $jadwalmapel->first();
        $tahun = Tahunajar::where('id', $tahunId)->first();

        $fileName = 'Jadwal Mata Pelajaran MAN 1 Kota Padang Tahun Ajar ' . $tahun->tahun . ' Semester ' . $tahun->semester . '.xlsx';
        return Excel::download(new JadwalmapelsExport($jadwalmapel, $jadwal), $fileName);
    }

    public function JadwalmapelguruExport(Request $request)
    {
        $tahunId =  $request->input('tahun');
        $userId = Auth::user()->id;
        $jadwalmapel = Jadwalmapel::join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
            ->join('gurus', 'pengampus.id_guru', '=', 'gurus.id')
            ->where('status', '=', '2')
            ->where('gurus.id_user', '=', $userId)
            ->orderBy('id_hari')
            ->orderBy('id_Waktu', 'desc')
            ->where('id_tahunajar', $tahunId)
            ->get();

        $jadwal = $jadwalmapel->first();
        $tahun = Tahunajar::where('id', $tahunId)->first();

        $fileName = 'Jadwal Mata Pelajaran MAN 1 Kota Padang Tahun Ajar ' . $tahun->tahun . ' Semester ' . $tahun->semester . '.xlsx';


        return Excel::download(new JadwalmapelguruExport($jadwalmapel, $jadwal), $fileName);
    }




    public function JadwalmapelskepsekExport(Request $request)
    {
        $tahunId = $request->input('tahun');

        $jadwalmapel = Jadwalmapel::orderBy('id_hari')
            ->orderBy('id_waktu', 'desc')
            ->where('status', '>=', 1)
            ->where('status', '<=', 3)
            ->where('id_tahunajar', $tahunId)
            ->get();
        $jadwal = $jadwalmapel->first();
        $tahun = Tahunajar::where('id', $tahunId)->first();

        $fileName = 'Jadwal Mata Pelajaran MAN 1 Kota Padang Tahun Ajar ' . $tahun->tahun . ' Semester ' . $tahun->semester . '.xlsx';

        return Excel::download(new JadwalmapelskepsekExport($jadwalmapel, $jadwal), $fileName);
    }

    public function JadwalmapelsGenerate(Request $request)
    {

        $tahun = $request->input('id_tahunajar');

        Jadwalmapel::truncate();

        // Ambil semua pengajaran dari tabel Teach yang sesuai dengan semester dan tahun tertentu

        $pengampu = Pengampu::where('id_tahunajar', $tahun)

            ->inRandomOrder()
            ->get();

        // hari senin //
        $totalJpForDayOne = [];

        foreach ($pengampu as $pengampus) {

            if (!isset($totalJpForDayOne[$pengampus->kelas])) {
                $totalJpForDayOne[$pengampus->kelas] = 0;
            }

            if ($totalJpForDayOne[$pengampus->kelas] < 10 && $pengampus->mapels->jp <= 10 - $totalJpForDayOne[$pengampus->kelas]) {
                // Jika total jp belum mencapai 10 dan jp dari teach tidak melebihi sisa yang diperlukan untuk mencapai 10

                // Cek apakah mapel yang diajarkan sudah diajarkan di kelas lain
                $mapelAlreadyTaught = false;
                foreach ($totalJpForDayOne as $kelas => $totalJp) {
                    if ($kelas != $pengampus->kelas) {
                        $pengampuLain = Pengampu::where('kelas', $kelas)->first();
                        if ($pengampuLain && $pengampuLain->mapels->id == $pengampus->mapels->id) {
                            $mapelAlreadyTaught = true;
                            break;
                        }
                    }
                }

                if (!$mapelAlreadyTaught) {
                    // Jika mapel yang diajarkan belum diajarkan di kelas lain, maka pengampu bisa diajarkan di kelas tersebut
                    $hari = Hari::where('kode_hari', "H01")->first(); // Mengambil hari dengan id 1
                    $totalJpForDayOne[$pengampus->kelas] += $pengampus->mapels->jp; // Menambahkan jp teach ke total jp berdasarkan class_room
                } else {
                    // Jika mapel sudah diajarkan di kelas lain, pilih hari secara acak
                    $hari = Hari::wherenot('kode_hari', "H01")->inRandomOrder()->first();
                }
            } else {
                // Jika total jp sudah mencapai 10 atau jp dari teach melebihi sisa yang diperlukan untuk mencapai 10
                // Pilih hari secara acak
                $hari = Hari::wherenot('kode_hari', "H01")->inRandomOrder()->first();
            }



            $tanggal = Carbon::now()->toDateString(); // '2023-10-17'
            $tanggal_tanpa_strip = str_replace("-", "", $tanggal); // '20231017'

            // Generate 4 random digits
            $kode_acak = mt_rand(1000, 9999);
            do {
                $kode_jadwalmapel = $tanggal_tanpa_strip . '.' . $kode_acak;
                $existingPengampu = Jadwalmapel::where('kode_jadwalmapel', $kode_jadwalmapel)->first();
            } while (!empty($existingPengampu));

            // $hari   = Hari::inRandomOrder()->first();
            $ruangan = Ruangan::where('id_jurusan', $pengampus->mapels->id_jurusan)
                ->where('type', $pengampus->mapels->type)
                ->inRandomOrder()
                ->first();
            $waktu = Waktu::where('jp', $pengampus->mapels->jp)->inRandomOrder()->first();

            $params = [
                'kode_jadwalmapel' => $kode_jadwalmapel,
                'id_pengampu' => $pengampus->id,
                'id_hari'   => $hari->id,
                'id_waktu'  => $waktu->id,
                'id_ruangan'  => $ruangan->id,
                'status' => '0',
                'id_tahunajar' => $pengampus->id_tahunajar,
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),

            ];
            Jadwalmapel::create($params);
        }

        $deletejadwalh03 = Jadwalmapel::wherenot('id_hari', 1)->delete();


        // // hari rabu //

        // $pengampu2 = Pengampu::where('id_tahunajar', $tahun)
        //     ->whereNotIn('id', function ($query) {
        //         $query->select('id_pengampu')
        //             ->from('jadwalmapels');
        //     })->inRandomOrder()->get(); // Menggunakan pluck untuk mengambil hanya kolom id



        // $totalJpForDayOne2 = [];
        // foreach ($pengampu2 as $pengampus2) {

        //     if (!isset($totalJpForDayOne2[$pengampus2->kelas])) {
        //         $totalJpForDayOne2[$pengampus2->kelas] = 0;
        //     }

        //     if ($totalJpForDayOne2[$pengampus2->kelas] < 10 && $pengampus2->mapels->jp <= 10 - $totalJpForDayOne2[$pengampus2->kelas]) {
        //         // Jika total jp belum mencapai 10 dan jp dari teach tidak melebihi sisa yang diperlukan untuk mencapai 10

        //         // Cek apakah mapel yang diajarkan sudah diajarkan di kelas lain
        //         $mapelAlreadyTaught2 = false;
        //         foreach ($totalJpForDayOne2 as $kelas2 => $totalJp2) {
        //             if ($kelas2 != $pengampus2->kelas) {
        //                 $pengampuLain2 = Pengampu::where('kelas', $kelas2)->first();
        //                 if ($pengampuLain2 && $pengampuLain2->mapels->id == $pengampus2->mapels->id) {
        //                     $mapelAlreadyTaught2 = true;
        //                     break;
        //                 }
        //             }
        //         }

        //         if (!$mapelAlreadyTaught2) {
        //             // Jika mapel yang diajarkan belum diajarkan di kelas lain, maka pengampu bisa diajarkan di kelas tersebut
        //             $hari2 = Hari::where('kode_hari', "H03")->first(); // Mengambil hari dengan id 1
        //             $totalJpForDayOne2[$pengampus2->kelas] += $pengampus2->mapels->jp; // Menambahkan jp teach ke total jp berdasarkan class_room
        //         } else {
        //             // Jika mapel sudah diajarkan di kelas lain, pilih hari secara acak
        //             $hari2 = Hari::where('kode_hari', "H04")->first();
        //         }
        //     } else {
        //         // Jika total jp sudah mencapai 10 atau jp dari teach melebihi sisa yang diperlukan untuk mencapai 10
        //         // Pilih hari secara acak
        //         $hari2 = Hari::where('kode_hari', "H04")->first();
        //     }



        //     $tanggal2 = Carbon::now()->toDateString(); // '2023-10-17'
        //     $tanggal_tanpa_strip2 = str_replace("-", "", $tanggal2); // '20231017'

        //     // Generate 4 random digits
        //     $kode_acak2 = mt_rand(1000, 9999);
        //     do {
        //         $kode_jadwalmapel2 = $tanggal_tanpa_strip2 . '.' . $kode_acak2;
        //         $existingPengampu2 = Jadwalmapel::where('kode_jadwalmapel', $kode_jadwalmapel2)->first();
        //     } while (!empty($existingPengampu2));

        //     // $hari   = Hari::inRandomOrder()->first();
        //     $ruangan2 = Ruangan::where('id_jurusan', $pengampus2->mapels->id_jurusan)
        //         ->where('type', $pengampus2->mapels->type)
        //         ->inRandomOrder()
        //         ->first();
        //     $waktu2 = Waktu::where('jp', $pengampus2->mapels->jp)->inRandomOrder()->first();


        //     $params = [
        //         'kode_jadwalmapel' => 1,
        //         'id_pengampu' => $pengampus2->id,
        //         'id_hari'   => $hari2->id,
        //         'id_waktu'  => $waktu2->id,
        //         'id_ruangan'  => $ruangan2->id,
        //         'status' => '0',
        //         'id_tahunajar' => $pengampus2->id_tahunajar,
        //         'created_by' => Auth::user()->id,
        //         'created_at' => Carbon::now(),

        //     ];
        //     Jadwalmapel::create($params);
        // }

        // $deletejadwalh03 = Jadwalmapel::where('id_hari', 4)->delete();


        // // // hari kamis //

        // $pengampu3 = Pengampu::where('id_tahunajar', $tahun)
        //     ->whereNotIn('id', function ($query) {
        //         $query->select('id_pengampu')
        //             ->from('jadwalmapels');
        //     })->inRandomOrder()->get(); // Menggunakan pluck untuk mengambil hanya kolom id



        // $totalJpForDayOne3 = [];
        // foreach ($pengampu3 as $pengampus3) {

        //     if (!isset($totalJpForDayOne3[$pengampus3->kelas])) {
        //         $totalJpForDayOne3[$pengampus3->kelas] = 0;
        //     }

        //     if ($totalJpForDayOne3[$pengampus3->kelas] < 10 && $pengampus3->mapels->jp <= 10 - $totalJpForDayOne3[$pengampus3->kelas]) {
        //         // Jika total jp belum mencapai 10 dan jp dari teach tidak melebihi sisa yang diperlukan untuk mencapai 10

        //         // Cek apakah mapel yang diajarkan sudah diajarkan di kelas lain
        //         $mapelAlreadyTaught3 = false;
        //         foreach ($totalJpForDayOne3 as $kelas3 => $totalJp3) {
        //             if ($kelas3 != $pengampus3->kelas) {
        //                 $pengampuLain3 = Pengampu::where('kelas', $kelas3)->first();
        //                 if ($pengampuLain3 && $pengampuLain3->mapels->id == $pengampus3->mapels->id) {
        //                     $mapelAlreadyTaught3 = true;
        //                     break;
        //                 }
        //             }
        //         }

        //         if (!$mapelAlreadyTaught3) {
        //             // Jika mapel yang diajarkan belum diajarkan di kelas lain, maka pengampu bisa diajarkan di kelas tersebut
        //             $hari3 = Hari::where('kode_hari', "H04")->first(); // Mengambil hari dengan id 1
        //             $totalJpForDayOne3[$pengampus3->kelas] += $pengampus3->mapels->jp; // Menambahkan jp teach ke total jp berdasarkan class_room
        //         } else {
        //             // Jika mapel sudah diajarkan di kelas lain, pilih hari secara acak
        //             $hari3 = Hari::where('kode_hari', "H05")->first();
        //         }
        //     } else {
        //         // Jika total jp sudah mencapai 10 atau jp dari teach melebihi sisa yang diperlukan untuk mencapai 10
        //         // Pilih hari secara acak
        //         $hari3 = Hari::where('kode_hari', "H05")->first();
        //     }



        //     $tanggal3 = Carbon::now()->toDateString(); // '3033-10-17'
        //     $tanggal_tanpa_strip3 = str_replace("-", "", $tanggal3); // '30331017'

        //     // Generate 4 random digits
        //     $kode_acak3 = mt_rand(1000, 9999);
        //     do {
        //         $kode_jadwalmapel3 = $tanggal_tanpa_strip3 . '.' . $kode_acak3;
        //         $existingPengampu3 = Jadwalmapel::where('kode_jadwalmapel', $kode_jadwalmapel3)->first();
        //     } while (!empty($existingPengampu3));

        //     // $hari   = Hari::inRandomOrder()->first();
        //     $ruangan3 = Ruangan::where('id_jurusan', $pengampus3->mapels->id_jurusan)
        //         ->where('type', $pengampus3->mapels->type)
        //         ->inRandomOrder()
        //         ->first();
        //     $waktu3 = Waktu::where('jp', $pengampus3->mapels->jp)->inRandomOrder()->first();


        //     $params = [
        //         'kode_jadwalmapel' => 1,
        //         'id_pengampu' => $pengampus3->id,
        //         'id_hari'   => $hari3->id,
        //         'id_waktu'  => $waktu3->id,
        //         'id_ruangan'  => $ruangan3->id,
        //         'status' => '0',
        //         'id_tahunajar' => $pengampus3->id_tahunajar,
        //         'created_by' => Auth::user()->id,
        //         'created_at' => Carbon::now(),

        //     ];
        //     Jadwalmapel::create($params);
        // }
        // $deletejadwalh04 = Jadwalmapel::where('id_hari', 5)->delete();


        // //    hari jumat //
        // $pengampu4 = Pengampu::where('id_tahunajar', $tahun)
        //     ->whereNotIn('id', function ($query) {
        //         $query->select('id_pengampu')
        //             ->from('jadwalmapels');
        //     })->inRandomOrder()->get(); // Menggunakan pluck untuk mengambil hanya kolom id



        // $totalJpForDayOne4 = [];
        // foreach ($pengampu4 as $pengampus4) {

        //     if (!isset($totalJpForDayOne4[$pengampus4->kelas])) {
        //         $totalJpForDayOne4[$pengampus4->kelas] = 0;
        //     }

        //     if ($totalJpForDayOne4[$pengampus4->kelas] < 9 && $pengampus4->mapels->jp <= 9 - $totalJpForDayOne4[$pengampus4->kelas]) {
        //         // Jika total jp belum mencapai 10 dan jp dari teach tidak melebihi sisa yang diperlukan untuk mencapai 10

        //         // Cek apakah mapel yang diajarkan sudah diajarkan di kelas lain
        //         $mapelAlreadyTaught4 = false;
        //         foreach ($totalJpForDayOne4 as $kelas4 => $totalJp4) {
        //             if ($kelas4 != $pengampus4->kelas) {
        //                 $pengampuLain4 = Pengampu::where('kelas', $kelas4)->first();
        //                 if ($pengampuLain4 && $pengampuLain4->mapels->id == $pengampus4->mapels->id) {
        //                     $mapelAlreadyTaught4 = true;
        //                     break;
        //                 }
        //             }
        //         }

        //         if (!$mapelAlreadyTaught4) {
        //             // Jika mapel yang diajarkan belum diajarkan di kelas lain, maka pengampu bisa diajarkan di kelas tersebut
        //             $hari4 = Hari::where('kode_hari', "H05")->first(); // Mengambil hari dengan id 1
        //             $totalJpForDayOne4[$pengampus4->kelas] += $pengampus4->mapels->jp; // Menambahkan jp teach ke total jp berdasarkan class_room
        //         } else {
        //             // Jika mapel sudah diajarkan di kelas lain, pilih hari secara acak
        //             $hari4 = Hari::where('kode_hari', "H02")->first();
        //         }
        //     } else {
        //         // Jika total jp sudah mencapai 10 atau jp dari teach melebihi sisa yang diperlukan untuk mencapai 10
        //         // Pilih hari secara acak
        //         $hari4 = Hari::where('kode_hari', "H02")->first();
        //     }



        //     $tanggal4 = Carbon::now()->toDateString(); // '4044-10-17'
        //     $tanggal_tanpa_strip4 = str_replace("-", "", $tanggal4); // '40441017'

        //     // Generate 4 random digits
        //     $kode_acak4 = mt_rand(1000, 9999);
        //     do {
        //         $kode_jadwalmapel4 = $tanggal_tanpa_strip4 . '.' . $kode_acak4;
        //         $existingPengampu4 = Jadwalmapel::where('kode_jadwalmapel', $kode_jadwalmapel4)->first();
        //     } while (!empty($existingPengampu4));

        //     // $hari   = Hari::inRandomOrder()->first();
        //     $ruangan4 = Ruangan::where('id_jurusan', $pengampus4->mapels->id_jurusan)
        //         ->where('type', $pengampus4->mapels->type)
        //         ->inRandomOrder()
        //         ->first();
        //     $waktu4 = Waktu::where('jp', $pengampus4->mapels->jp)->inRandomOrder()->first();


        //     $params = [
        //         'kode_jadwalmapel' => 1,
        //         'id_pengampu' => $pengampus4->id,
        //         'id_hari'   => $hari4->id,
        //         'id_waktu'  => $waktu4->id,
        //         'id_ruangan'  => $ruangan4->id,
        //         'status' => '0',
        //         'id_tahunajar' => $pengampus4->id_tahunajar,
        //         'created_by' => Auth::user()->id,
        //         'created_at' => Carbon::now(),

        //     ];
        //     Jadwalmapel::create($params);
        // }

        // $deletejadwalh05 = Jadwalmapel::where('id_hari', 2)->delete();

        // //hari selasa //
        // $pengampu5 = Pengampu::where('id_tahunajar', $tahun)
        //     ->whereNotIn('id', function ($query) {
        //         $query->select('id_pengampu')
        //             ->from('jadwalmapels');
        //     })->inRandomOrder()->get();

        // $totalJpForDayOne5 = [];
        // foreach ($pengampu5 as $pengampus5) {

        //     if (!isset($totalJpForDayOne5[$pengampus5->kelas])) {
        //         $totalJpForDayOne5[$pengampus5->kelas] = 0;
        //     }

        //     if ($totalJpForDayOne5[$pengampus5->kelas] < 11 && $pengampus5->mapels->jp <= 11 - $totalJpForDayOne5[$pengampus5->kelas]) {
        //         // Jika total jp belum mencapai 10 dan jp dari teach tidak melebihi sisa yang diperlukan untuk mencapai 10

        //         // Cek apakah mapel yang diajarkan sudah diajarkan di kelas lain
        //         $mapelAlreadyTaught5 = false;
        //         foreach ($totalJpForDayOne5 as $kelas5 => $totalJp5) {
        //             if ($kelas5 != $pengampus5->kelas) {
        //                 $pengampuLain5 = Pengampu::where('kelas', $kelas5)->first();
        //                 if ($pengampuLain5 && $pengampuLain5->mapels->id == $pengampus5->mapels->id) {
        //                     $mapelAlreadyTaught5 = true;
        //                     break;
        //                 }
        //             }
        //         }

        //         if (!$mapelAlreadyTaught5) {
        //             // Jika mapel yang diajarkan belum diajarkan di kelas lain, maka pengampu bisa diajarkan di kelas tersebut
        //             $hari5 = Hari::where('kode_hari', "H02")->first(); // Mengambil hari dengan id 1
        //             $totalJpForDayOne5[$pengampus5->kelas] += $pengampus5->mapels->jp; // Menambahkan jp teach ke total jp berdasarkan class_room
        //         } else {
        //             // Jika mapel sudah diajarkan di kelas lain, pilih hari secara acak

        //             $hari5 = Hari::where('kode_hari', '<>', "H02")->inRandomOrder()->first();
        //         }
        //     } else {
        //         // Jika total jp sudah mencapai 10 atau jp dari teach melebihi sisa yang diperlukan untuk mencapai 10
        //         // Pilih hari secara acak
        //         $hari5 = Hari::where('kode_hari', '<>', "H02")->inRandomOrder()->first();
        //     }



        //     $tanggal5 = Carbon::now()->toDateString(); // '5055-10-17'
        //     $tanggal_tanpa_strip5 = str_replace("-", "", $tanggal5); // '50551017'

        //     // Generate 5 random digits
        //     $kode_acak5 = mt_rand(1000, 9999);
        //     do {
        //         $kode_jadwalmapel5 = $tanggal_tanpa_strip5 . '.' . $kode_acak5;
        //         $existingPengampu5 = Jadwalmapel::where('kode_jadwalmapel', $kode_jadwalmapel5)->first();
        //     } while (!empty($existingPengampu5));

        //     // $hari   = Hari::inRandomOrder()->first();
        //     $ruangan5 = Ruangan::where('id_jurusan', $pengampus5->mapels->id_jurusan)
        //         ->where('type', $pengampus5->mapels->type)
        //         ->inRandomOrder()
        //         ->first();
        //     $waktu5 = Waktu::where('jp', $pengampus5->mapels->jp)->inRandomOrder()->first();


        //     $params = [
        //         'kode_jadwalmapel' => 1,
        //         'id_pengampu' => $pengampus5->id,
        //         'id_hari'   => $hari5->id,
        //         'id_waktu'  => $waktu5->id,
        //         'id_ruangan'  => $ruangan5->id,
        //         'status' => '0',
        //         'id_tahunajar' => $pengampus5->id_tahunajar,
        //         'created_by' => Auth::user()->id,
        //         'created_at' => Carbon::now(),

        //     ];
        //     Jadwalmapel::create($params);
        // }
        return redirect()->back();
    } // end method
}
