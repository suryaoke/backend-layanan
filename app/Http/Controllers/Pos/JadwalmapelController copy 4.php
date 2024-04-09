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
        $ptk = Pengampu::whereNotIn('id_mapel', function ($query) {
            $query->select('id_mapel')
                ->from('jadwalmapels')
                ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id');
        })

            ->inRandomOrder()
            ->get();

        return view('backend.data.jadwalmapel.jadwalmapel_all', compact('ptk', 'datatahunpengampu', 'datatahun', 'jadwal', 'tahunajar', 'kelas', 'pengampu', 'ruangan', 'mapel',  'hari', 'waktu',  'jadwalmapel'));
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

        // Jadwalmapel::where('id_tahunajar', $tahun)->delete();

        // Ambil semua pengajaran dari tabel Teach yang sesuai dengan semester dan tahun tertentu


        $pengampu = Pengampu::where('id_tahunajar', $tahun)
            ->where('kelas', 29)
            ->whereNotIn(
                'id',
                function ($query) {
                    $query->select('id_pengampu')
                        ->from('jadwalmapels');
                }
            )
            ->inRandomOrder()
            ->get();

        // $pengampu2 = Pengampu::where('id_tahunajar', $tahun)
        //     ->whereNotIn('id', function ($query) {
        //         $query->select('id_pengampu')
        //             ->from('jadwalmapels');
        //     })->inRandomOrder()->get(); // Menggunakan pluck untuk mengambil hanya kolom id

        // $pengampu = Pengampu::whereNotIn('id_mapel', function ($query) {
        //     $query->select('id_mapel')
        //         ->from('jadwalmapels')
        //         ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id');
        // })
        //     ->where('kelas', 29)
        //     ->inRandomOrder()
        //     ->get();
        $pengampu_count = count($pengampu);
        $found_combination = false;

        // Iterasi melalui setiap kombinasi pengampu
        for ($i = 0; $i < $pengampu_count; $i++) {
            $total_jp = 0;
            $selected_pengampus = [];

            // Mengambil satu pengampu
            $current_pengampu = $pengampu[$i];

            // Menambahkan jp dari pengampu saat ini ke total_jp
            $jp = $current_pengampu->mapels->jp;
            $total_jp += $jp;
            $selected_pengampus[] = $current_pengampu;

            // Jika total jp sudah tepat 11, keluar dari loop
            if ($total_jp == 10) {
                $found_combination = true;
                break;
            }

            // Iterasi melalui pengampu lainnya untuk mencari kombinasi yang tepat
            for ($j = $i + 1; $j < $pengampu_count; $j++) {
                $next_pengampu = $pengampu[$j];
                $jp = $next_pengampu->mapels->jp;

                // Jika total jp bersama dengan pengampu saat ini sudah tepat 11, keluar dari loop
                if ($total_jp + $jp == 10) {
                    $total_jp += $jp;
                    $selected_pengampus[] = $next_pengampu;
                    $found_combination = true;
                    break 2; // Keluar dari loop luar
                } elseif ($total_jp + $jp < 10) {
                    // Jika total jp masih kurang dari 11, tambahkan ke total_jp dan lanjutkan pencarian
                    $total_jp += $jp;
                    $selected_pengampus[] = $next_pengampu;
                }
            }
        }

        // Jika ditemukan kombinasi yang total JP-nya tepat 11, buat entri jadwalmapel
        if ($found_combination) {
            $hari = '1'; // Misalnya, hari diatur ke '1'
            foreach ($selected_pengampus as $pengampus) {
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
                    'id_hari'   => $hari,
                    'id_waktu'  => $waktu->id,
                    'id_ruangan'  => $ruangan->id,
                    'status' => '0',
                    'id_tahunajar' => $pengampus->id_tahunajar,
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now(),

                ];
                Jadwalmapel::create($params);
            }
        } else {
            echo "Tidak ditemukan kombinasi pengampu yang total JP-nya tepat 11.";
        }




        return redirect()->back();
    } // end method
}
