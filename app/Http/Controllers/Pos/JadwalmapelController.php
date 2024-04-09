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
            ->whereNotIn('id', function ($query) {
                $query->select('id_pengampu')
                    ->from('jadwalmapels');
            })
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


        $datakelas = Kelas::whereIn(
            'id',
            function ($query) {
                $query->select('kelas')
                    ->from('pengampus');
            }
        )

            ->get();

        return view('backend.data.jadwalmapel.jadwalmapel_all', compact('datakelas', 'datatahunpengampu', 'datatahun', 'jadwal', 'tahunajar', 'kelas', 'pengampu', 'ruangan', 'mapel',  'hari', 'waktu',  'jadwalmapel'));
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
                'id_tahunajar' => $guruInput->id_tahunajar,
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
                    'id_tahunajar' => $guruInput->id_tahunajar,
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


        // Tambahkan pembaruan lain sesuai kebutuhan Anda

        // Menyimpan perubahan ke dalam database
        $jadwalmapel->save();

        $notification = array(
            'message' => 'Jadwal Sementara Update SuccessFully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // end method

    public function JadwalmapelTukar(Request $request, $id)
    {
        $id2 = $request->input('id2');

        // Mengambil data jadwal berdasarkan $id
        $jadwalmapel1 = Jadwalmapel::find($id);
        $jadwalmapel2 = Jadwalmapel::find($id2);

        // Memeriksa apakah data jadwal ditemukan
        if (!$jadwalmapel1 || !$jadwalmapel2) {
            // Jika salah satu jadwal tidak ditemukan, redirect dengan pesan error
            $notification = array(
                'message' => 'Jadwal not found',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        // Lanjutkan jika keduanya ditemukan

        $tempIdWaktu = $jadwalmapel1->id_waktu;
        $tempIdHari = $jadwalmapel1->id_hari;

        $jadwalmapel1->id_waktu = $jadwalmapel2->id_waktu;
        $jadwalmapel2->id_waktu = $tempIdWaktu;

        $jadwalmapel1->id_hari = $jadwalmapel2->id_hari;
        $jadwalmapel2->id_hari = $tempIdHari;

        // Menyimpan perubahan ke dalam database
        $jadwalmapel1->save();
        $jadwalmapel2->save();

        $notification = array(
            'message' => 'Jadwal Sementara Update SuccessFully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }



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
                ->where('jadwalmapels.id_tahunajar', $tahunAjarSaatIni->id)

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

        $hari = Hari::whereExists(function ($query) use ($userId) {
            $query->select(DB::raw(1))
                ->from('pengampus')
                ->join('jadwalmapels', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
                ->join('gurus', 'pengampus.id_guru', '=', 'gurus.id')
                ->where('gurus.id_user', '=', $userId)
                ->whereRaw('jadwalmapels.id_hari = haris.id');
        })->orderBy('id', 'desc')
            ->get();
        //  $hari = Hari::orderby('kode_hari', 'asc')->get();
        return view('backend.data.jadwalmapel.jadwalmapel_guru', compact('hari', 'jadwal', 'datatahun', 'kelas', 'jadwalmapel'));
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
                ->where('jadwalmapels.id_tahunajar', $tahunAjarSaatIni->id)

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
        $hari = Hari::orderby('kode_hari', 'asc')->get();
        return view('backend.data.jadwalmapel.jadwalmapel_siswa', compact('hari', 'jadwal', 'datatahun', 'kelas', 'jadwalmapel'));
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
                ->where('jadwalmapels.id_tahunajar', $tahunAjarSaatIni->id)
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
        $hari = Hari::orderby('kode_hari', 'asc')->get();
        return view('backend.data.jadwalmapel.jadwalmapel_ortu', compact('hari', 'jadwal', 'datatahun', 'kelas', 'jadwalmapel'));
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
        $hari = Hari::all();

        $fileName = 'Jadwal Mata Pelajaran MAN 1 Kota Padang Tahun Ajar ' . $tahun->tahun . ' Semester ' . $tahun->semester . '.xlsx';
        return Excel::download(new JadwalmapelsExport($jadwalmapel, $jadwal, $hari), $fileName);
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
            ->where('jadwalmapels.id_tahunajar', $tahunId)
            ->get();

        $jadwal = $jadwalmapel->first();
        $tahun = Tahunajar::where('id', $tahunId)->first();
        $hari = Hari::all();

        $fileName = 'Jadwal Mata Pelajaran MAN 1 Kota Padang Tahun Ajar ' . $tahun->tahun . ' Semester ' . $tahun->semester . '.xlsx';


        return Excel::download(new JadwalmapelguruExport($jadwalmapel, $jadwal, $hari), $fileName);
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

        $hari = hari::all();
        $fileName = 'Jadwal Mata Pelajaran MAN 1 Kota Padang Tahun Ajar ' . $tahun->tahun . ' Semester ' . $tahun->semester . '.xlsx';

        return Excel::download(new JadwalmapelskepsekExport($jadwalmapel, $jadwal, $hari), $fileName);
    }

    public function JadwalmapelsGenerate(Request $request)
    {

        $tahun = $request->input('id_tahunajar');
        $kelas =  $request->input('id_kelas');

        Jadwalmapel::join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
            ->where('pengampus.kelas', $kelas)
            ->where('jadwalmapels.id_tahunajar', $tahun)
            ->delete();



        // selasa//

        $pengampu = Pengampu::where('id_tahunajar', $tahun)

            ->whereNotIn(
                'id',
                function ($query) {
                    $query->select('id_pengampu')
                        ->from('jadwalmapels');
                }
            )
            ->where('kelas', $kelas)
            ->inRandomOrder()
            ->get();
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
            if ($total_jp == 11) {
                $found_combination = true;
                break;
            }

            // Iterasi melalui pengampu lainnya untuk mencari kombinasi yang tepat
            for ($j = $i + 1; $j < $pengampu_count; $j++) {
                $next_pengampu = $pengampu[$j];
                $jp = $next_pengampu->mapels->jp;

                // Jika total jp bersama dengan pengampu saat ini sudah tepat 11, keluar dari loop
                if ($total_jp + $jp == 11) {
                    $total_jp += $jp;
                    $selected_pengampus[] = $next_pengampu;
                    $found_combination = true;
                    break 2; // Keluar dari loop luar
                } elseif ($total_jp + $jp < 11) {
                    // Jika total jp masih kurang dari 11, tambahkan ke total_jp dan lanjutkan pencarian
                    $total_jp += $jp;
                    $selected_pengampus[] = $next_pengampu;
                }
            }
        }

        // Jika ditemukan kombinasi yang total JP-nya tepat 11, buat entri jadwalmapel
        if ($found_combination) {
            $hari = '2'; // Misalnya, hari diatur ke '1'
            $jamMulai = 7; // Jam mulai pertama
            $menitMulai = 0; // Menit mulai pertama
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

                $jp = $pengampus->mapels->jp;
                $totalMenit = $jp * 40;

                $jamSelesai = $jamMulai + intdiv($totalMenit, 60); // Hitung jam selesai
                $menitSelesai = $menitMulai + ($totalMenit % 60); // Hitung menit selesai
                if ($menitSelesai >= 60) {
                    $jamSelesai += intdiv($menitSelesai, 60); // Tambahkan jam jika menit melebihi 59
                    $menitSelesai %= 60; // Sisa dari pembagian adalah menit baru
                }
                $bersinggungan_istirahat_pagi = ($jamMulai < 10 && $jamSelesai >= 10) || ($jamMulai <= 10 && $jamSelesai >= 10 && $menitSelesai >= 20 && $menitMulai < 20);
                $bersinggungan_istirahat_siang = ($jamMulai < 12 && $jamSelesai >= 12) || ($jamMulai <= 12 && $jamSelesai >= 12 && $menitSelesai >= 20 && $menitMulai < 20);

                if ($bersinggungan_istirahat_pagi) {
                    $menitSelesai += 20; // Tambahkan 20 menit
                }
                if ($bersinggungan_istirahat_siang) {
                    $menitSelesai += 40; // Tambahkan 20 menit
                }
                if ($menitSelesai >= 60) {
                    $jamSelesai += intdiv($menitSelesai, 60); // Tambahkan jam jika menit melebihi 59
                    $menitSelesai %= 60; // Sisa dari pembagian adalah menit baru
                }

                $waktu_mulai = sprintf('%02d:%02d', $jamMulai, $menitMulai);
                $waktu_selesai =  sprintf('%02d:%02d', $jamSelesai, $menitSelesai);
                $params = [
                    'kode_jadwalmapel' => $kode_jadwalmapel,
                    'id_pengampu' => $pengampus->id,
                    'id_hari'   => $hari,
                    'id_waktu'  => $waktu_mulai . "-" . $waktu_selesai,
                    'id_ruangan'  => $ruangan->id,
                    'status' => '0',
                    'id_tahunajar' => $pengampus->id_tahunajar,
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now(),

                ];


                Jadwalmapel::create($params);
                $jamMulai = $jamSelesai;
                $menitMulai = $menitSelesai;
            }
        } else {
            echo "Tidak ditemukan kombinasi pengampu yang total JP-nya tepat 11.";
        }




        // Jumat //

        $pengampu1 = Pengampu::where('id_tahunajar', $tahun)
            ->whereNotIn(
                'id',
                function ($query) {
                    $query->select('id_pengampu')
                        ->from('jadwalmapels');
                }
            )
            ->where('kelas', $kelas)
            ->inRandomOrder()
            ->get();



        $pengampu_count1 = count($pengampu1);
        $found_combination1 = false;

        // Iterasi melalui setiap kombinasi pengampu
        for ($i = 0; $i < $pengampu_count1; $i++) {
            $total_jp1 = 0;
            $selected_pengampus1 = [];

            // Mengambil satu pengampu
            $current_pengampu1 = $pengampu1[$i];

            // Menambahkan jp dari pengampu saat ini ke total_jp
            $jp1 = $current_pengampu1->mapels->jp;
            $total_jp1 += $jp1;
            $selected_pengampus1[] = $current_pengampu1;

            // Jika total jp sudah tepat 11, keluar dari loop
            if ($total_jp1 == 9) {
                $found_combination1 = true;
                break;
            }

            // Iterasi melalui pengampu lainnya untuk mencari kombinasi yang tepat
            for ($j1 = $i + 1; $j1 < $pengampu_count1; $j1++) {
                $next_pengampu1 = $pengampu1[$j1];
                $jp1 = $next_pengampu1->mapels->jp;

                // Jika total jp bersama dengan pengampu saat ini sudah tepat 11, keluar dari loop
                if ($total_jp1 + $jp1 == 9) {
                    $total_jp1 += $jp1;
                    $selected_pengampus1[] = $next_pengampu1;
                    $found_combination1 = true;
                    break 2; // Keluar dari loop luar
                } elseif ($total_jp1 + $jp1 < 9) {
                    // Jika total jp masih kurang dari 11, tambahkan ke total_jp dan lanjutkan pencarian
                    $total_jp1 += $jp1;
                    $selected_pengampus1[] = $next_pengampu1;
                }
            }
        }

        // Jika ditemukan kombinasi yang total JP-nya tepat 11, buat entri jadwalmapel
        if ($found_combination1) {
            $hari1 = '5'; // Misalnya, hari diatur ke '1'
            $jamMulai1 = 8; // Jam mulai pertama
            $menitMulai1 = 0; // Menit mulai pertama
            foreach ($selected_pengampus1 as $pengampus1) {
                $tanggal1 = Carbon::now()->toDateString(); // '2023-10-17'
                $tanggal_tanpa_strip1 = str_replace("-", "", $tanggal1); // '20231017'

                // Generate 4 random digits
                $kode_acak1 = mt_rand(1000, 9999);
                do {
                    $kode_jadwalmapel1 = $tanggal_tanpa_strip1 . '.' . $kode_acak1;
                    $existingPengampu1 = Jadwalmapel::where('kode_jadwalmapel', $kode_jadwalmapel1)->first();
                } while (!empty($existingPengampu1));

                // $hari   = Hari::inRandomOrder()->first();
                $ruangan1 = Ruangan::where('id_jurusan', $pengampus1->mapels->id_jurusan)
                    ->where('type', $pengampus1->mapels->type)
                    ->inRandomOrder()
                    ->first();

                $jp1 = $pengampus1->mapels->jp;
                $totalMenit1 = $jp1 * 40;

                $jamSelesai1 = $jamMulai1 + intdiv($totalMenit1, 60); // Hitung jam selesai
                $menitSelesai1 = $menitMulai1 + ($totalMenit1 % 60); // Hitung menit selesai
                if ($menitSelesai1 >= 60) {
                    $jamSelesai1 += intdiv($menitSelesai1, 60); // Tambahkan jam jika menit melebihi 59
                    $menitSelesai1 %= 60; // Sisa dari pembagian adalah menit baru
                }
                $bersinggungan_istirahat_pagi1 = ($jamMulai1 < 10 && $jamSelesai1 >= 10) || ($jamMulai1 <= 10 && $jamSelesai1 >= 10 && $menitSelesai1 >= 20 && $menitMulai1 < 20);
                $bersinggungan_istirahat_siang1 = ($jamMulai1 < 11 || ($jamMulai1 == 11 && $menitMulai1 < 40)) && ($jamSelesai1 > 11 || ($jamSelesai1 == 11 && $menitSelesai1 >= 40)) || ($jamMulai1 < 13 || ($jamMulai1 == 13 && $menitMulai1 < 20)) && ($jamSelesai1 > 13 || ($jamSelesai1 == 13 && $menitSelesai1 > 20));
                if ($bersinggungan_istirahat_pagi1) {
                    $menitSelesai1 += 20; // Tambahkan 20 menit
                }
                if ($bersinggungan_istirahat_siang1) {
                    $menitSelesai1 += 100; // Tambahkan 20 menit
                }
                if ($menitSelesai1 >= 60) {
                    $jamSelesai1 += intdiv($menitSelesai1, 60); // Tambahkan jam jika menit melebihi 59
                    $menitSelesai1 %= 60; // Sisa dari pembagian adalah menit baru
                }
                $waktu_mulai1 = sprintf('%02d:%02d', $jamMulai1, $menitMulai1);
                $waktu_selesai1 =  sprintf('%02d:%02d', $jamSelesai1, $menitSelesai1);

                $params1 = [
                    'kode_jadwalmapel' => $kode_jadwalmapel1,
                    'id_pengampu' => $pengampus1->id,
                    'id_hari'   => $hari1,
                    'id_waktu'  => $waktu_mulai1 . "-" . $waktu_selesai1,
                    'id_ruangan'  => $ruangan1->id,
                    'status' => '0',
                    'id_tahunajar' => $pengampus1->id_tahunajar,
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now(),

                ];

                Jadwalmapel::create($params1);

                $jamMulai1 = $jamSelesai1;
                $menitMulai1 = $menitSelesai1;
            }
        } else {
            echo "Tidak ditemukan kombinasi pengampu yang total JP-nya tepat 11.";
        }



        // Senin //



        $pengampu2 = Pengampu::where('id_tahunajar', $tahun)

            ->whereNotIn(
                'id',
                function ($query) {
                    $query->select('id_pengampu')
                        ->from('jadwalmapels');
                }
            )
            ->where('kelas', $kelas)
            ->inRandomOrder()
            ->get();


        $pengampu_count2 = count($pengampu2);
        $found_combination2 = false;

        // Iterasi melalui setiap kombinasi pengampu
        for ($i = 0; $i < $pengampu_count2; $i++) {
            $total_jp2 = 0;
            $selected_pengampus2 = [];

            // Mengambil satu pengampu
            $current_pengampu2 = $pengampu2[$i];

            // Menambahkan jp dari pengampu saat ini ke total_jp
            $jp2 = $current_pengampu2->mapels->jp;
            $total_jp2 += $jp2;
            $selected_pengampus2[] = $current_pengampu2;

            // Jika total jp sudah tepat 22, keluar dari loop
            if ($total_jp2 == 10) {
                $found_combination2 = true;
                break;
            }

            // Iterasi melalui pengampu lainnya untuk mencari kombinasi yang tepat
            for ($j2 = $i + 1; $j2 < $pengampu_count2; $j2++) {
                $next_pengampu2 = $pengampu2[$j2];
                $jp2 = $next_pengampu2->mapels->jp;

                // Jika total jp bersama dengan pengampu saat ini sudah tepat 22, keluar dari loop
                if ($total_jp2 + $jp2 == 10) {
                    $total_jp2 += $jp2;
                    $selected_pengampus2[] = $next_pengampu2;
                    $found_combination2 = true;
                    break 2; // Keluar dari loop luar
                } elseif ($total_jp2 + $jp2 < 10) {
                    // Jika total jp masih kurang dari 22, tambahkan ke total_jp dan lanjutkan pencarian
                    $total_jp2 += $jp2;
                    $selected_pengampus2[] = $next_pengampu2;
                }
            }
        }

        // Jika ditemukan kombinasi yang total JP-nya tepat 22, buat entri jadwalmapel
        if ($found_combination2) {
            $hari2 = '1'; // Misalnya, hari diatur ke '2'
            $jamMulai2 = 8; // Jam mulai pertama
            $menitMulai2 = 0; // Menit mulai pertama
            foreach ($selected_pengampus2 as $pengampus2) {
                $tanggal2 = Carbon::now()->toDateString(); // '2023-20-27'
                $tanggal_tanpa_strip2 = str_replace("-", "", $tanggal2); // '20232027'

                // Generate 4 random digits
                $kode_acak2 = mt_rand(2000, 9999);
                do {
                    $kode_jadwalmapel2 = $tanggal_tanpa_strip2 . '.' . $kode_acak2;
                    $existingPengampu2 = Jadwalmapel::where('kode_jadwalmapel', $kode_jadwalmapel2)->first();
                } while (!empty($existingPengampu2));

                // $hari   = Hari::inRandomOrder()->first();
                $ruangan2 = Ruangan::where('id_jurusan', $pengampus2->mapels->id_jurusan)
                    ->where('type', $pengampus2->mapels->type)
                    ->inRandomOrder()
                    ->first();

                $jp2 = $pengampus2->mapels->jp;
                $totalMenit2 = $jp2 * 40;

                $jamSelesai2 = $jamMulai2 + intdiv($totalMenit2, 60); // Hitung jam selesai
                $menitSelesai2 = $menitMulai2 + ($totalMenit2 % 60); // Hitung menit selesai

                if ($menitSelesai2 >= 60) {
                    $jamSelesai2 += intdiv($menitSelesai2, 60); // Tambahkan jam jika menit melebihi 59
                    $menitSelesai2 %= 60; // Sisa dari pembagian adalah menit baru
                }

                $bersinggungan_istirahat_pagi2 = ($jamMulai2 < 10 && $jamSelesai2 >= 10) || ($jamMulai2 <= 10 && $jamSelesai2 >= 10 && $menitSelesai2 >= 20 && $menitMulai2 < 20);
                $bersinggungan_istirahat_siang2 = ($jamMulai2 < 12 && $jamSelesai2 >= 12) || ($jamMulai2 <= 12 && $jamSelesai2 >= 12 && $menitSelesai2 >= 20 && $menitMulai2 < 20);

                if ($bersinggungan_istirahat_pagi2) {
                    $menitSelesai2 += 20; // Tambahkan 20 menit
                }
                if ($bersinggungan_istirahat_siang2) {
                    $menitSelesai2 += 40; // Tambahkan 20 menit
                }
                if ($menitSelesai2 >= 60) {
                    $jamSelesai2 += intdiv($menitSelesai2, 60); // Tambahkan jam jika menit melebihi 59
                    $menitSelesai2 %= 60; // Sisa dari pembagian adalah menit baru
                }

                $waktu_mulai2 = sprintf('%02d:%02d', $jamMulai2, $menitMulai2);
                $waktu_selesai2 =  sprintf('%02d:%02d', $jamSelesai2, $menitSelesai2);

                $params2 = [
                    'kode_jadwalmapel' => $kode_jadwalmapel2,
                    'id_pengampu' => $pengampus2->id,
                    'id_hari'   => $hari2,
                    'id_waktu'  => $waktu_mulai2 . "-" . $waktu_selesai2,
                    'id_ruangan'  => $ruangan2->id,
                    'status' => '0',
                    'id_tahunajar' => $pengampus2->id_tahunajar,
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now(),

                ];

                Jadwalmapel::create($params2);

                $jamMulai2 = $jamSelesai2;
                $menitMulai2 = $menitSelesai2;
            }
        } else {
            echo "Tidak ditemukan kombinasi pengampu yang total JP-nya tepat 22.";
        }





        // rabu //

        $pengampu3 = Pengampu::where('id_tahunajar', $tahun)
            ->whereNotIn(
                'id',
                function ($query) {
                    $query->select('id_pengampu')
                        ->from('jadwalmapels');
                }
            )
            ->where('kelas', $kelas)
            ->inRandomOrder()
            ->get();

        $pengampu_count3 = count($pengampu3);
        $found_combination3 = false;

        // Iterasi melalui setiap kombinasi pengampu
        for ($i = 0; $i < $pengampu_count3; $i++) {
            $total_jp3 = 0;
            $selected_pengampus3 = [];

            // Mengambil satu pengampu
            $current_pengampu3 = $pengampu3[$i];

            // Menambahkan jp dari pengampu saat ini ke total_jp
            $jp3 = $current_pengampu3->mapels->jp;
            $total_jp3 += $jp3;
            $selected_pengampus3[] = $current_pengampu3;

            // Jika total jp sudah tepat 33, keluar dari loop
            if ($total_jp3 == 110) {
                $found_combination3 = true;
                break;
            }

            // Iterasi melalui pengampu lainnya untuk mencari kombinasi yang tepat
            for ($j3 = $i + 1; $j3 < $pengampu_count3; $j3++) {
                $next_pengampu3 = $pengampu3[$j3];
                $jp3 = $next_pengampu3->mapels->jp;

                // Jika total jp bersama dengan pengampu saat ini sudah tepat 33, keluar dari loop
                if ($total_jp3 + $jp3 == 10) {
                    $total_jp3 += $jp3;
                    $selected_pengampus3[] = $next_pengampu3;
                    $found_combination3 = true;
                    break 2; // Keluar dari loop luar
                } elseif ($total_jp3 + $jp3 < 10) {
                    // Jika total jp masih kurang dari 33, tambahkan ke total_jp dan lanjutkan pencarian
                    $total_jp3 += $jp3;
                    $selected_pengampus3[] = $next_pengampu3;
                }
            }
        }

        // Jika ditemukan kombinasi yang total JP-nya tepat 33, buat entri jadwalmapel
        if ($found_combination3) {
            $hari3 = '3'; // Misalnya, hari diatur ke '3'
            $jamMulai3 = 7; // Jam mulai pertama
            $menitMulai3 = 0; // Menit mulai pertama
            foreach ($selected_pengampus3 as $pengampus3) {
                $tanggal3 = Carbon::now()->toDateString(); // '2023-30-37'
                $tanggal_tanpa_strip3 = str_replace("-", "", $tanggal3); // '20233037'

                // Generate 4 random digits
                $kode_acak3 = mt_rand(3000, 9999);
                do {
                    $kode_jadwalmapel3 = $tanggal_tanpa_strip3 . '.' . $kode_acak3;
                    $existingPengampu3 = Jadwalmapel::where('kode_jadwalmapel', $kode_jadwalmapel3)->first();
                } while (!empty($existingPengampu3));

                // $hari   = Hari::inRandomOrder()->first();
                $ruangan3 = Ruangan::where('id_jurusan', $pengampus3->mapels->id_jurusan)
                    ->where('type', $pengampus3->mapels->type)
                    ->inRandomOrder()
                    ->first();

                $jp3 = $pengampus3->mapels->jp;
                $totalMenit3 = $jp3 * 40;

                $jamSelesai3 = $jamMulai3 + intdiv($totalMenit3, 60); // Hitung jam selesai
                $menitSelesai3 = $menitMulai3 + ($totalMenit3 % 60); // Hitung menit selesai

                if ($menitSelesai3 >= 60) {
                    $jamSelesai3 += intdiv($menitSelesai3, 60); // Tambahkan jam jika menit melebihi 59
                    $menitSelesai3 %= 60; // Sisa dari pembagian adalah menit baru
                }

                $bersinggungan_istirahat_pagi3 = ($jamMulai3 < 10 && $jamSelesai3 >= 10) || ($jamMulai3 <= 10 && $jamSelesai3 >= 10 && $menitSelesai3 >= 20 && $menitMulai3 < 20);
                $bersinggungan_istirahat_siang3 = ($jamMulai3 < 12 && $jamSelesai3 >= 12) || ($jamMulai3 <= 12 && $jamSelesai3 >= 12 && $menitSelesai3 >= 20 && $menitMulai3 < 20);

                if ($bersinggungan_istirahat_pagi3) {
                    $menitSelesai3 += 20; // Tambahkan 20 menit
                }
                if ($bersinggungan_istirahat_siang3) {
                    $menitSelesai3 += 40; // Tambahkan 20 menit
                }
                if ($menitSelesai3 >= 60) {
                    $jamSelesai3 += intdiv($menitSelesai3, 60); // Tambahkan jam jika menit melebihi 59
                    $menitSelesai3 %= 60; // Sisa dari pembagian adalah menit baru
                }

                $waktu_mulai3 = sprintf('%02d:%02d', $jamMulai3, $menitMulai3);
                $waktu_selesai3 =  sprintf('%02d:%02d', $jamSelesai3, $menitSelesai3);
                $params3 = [
                    'kode_jadwalmapel' => $kode_jadwalmapel3,
                    'id_pengampu' => $pengampus3->id,
                    'id_hari'   => $hari3,
                    'id_waktu'  => $waktu_mulai3 . "-" . $waktu_selesai3,
                    'id_ruangan'  => $ruangan3->id,
                    'status' => '0',
                    'id_tahunajar' => $pengampus3->id_tahunajar,
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now(),

                ];

                Jadwalmapel::create($params3);
                $jamMulai3 = $jamSelesai3;
                $menitMulai3 = $menitSelesai3;
            }
        } else {
            echo "Tidak ditemukan kombinasi pengampu yang total JP-nya tepat 33.";
        }




        // kamis /
        $pengampu4 = Pengampu::where('id_tahunajar', $tahun)
            // ->whereNotIn('id_mapel', function ($query) {
            //     $query->select('id_mapel')
            //         ->from('jadwalmapels')
            //         ->join('pengampus', 'jadwalmapels.id_pengampu', '=', 'pengampus.id')
            //         ->where('id_hari', 4); // Menambahkan kondisi id_hari di sini
            // })
            ->whereNotIn(
                'id',
                function ($query) {
                    $query->select('id_pengampu')
                        ->from('jadwalmapels');
                }
            )
            ->where('kelas', $kelas)
            ->inRandomOrder()
            ->get();

        $pengampu_count4 = count($pengampu4);
        $found_combination4 = false;

        // Iterasi melalui setiap kombinasi pengampu
        for ($i = 0; $i < $pengampu_count4; $i++) {
            $total_jp4 = 0;
            $selected_pengampus4 = [];

            // Mengambil satu pengampu
            $current_pengampu4 = $pengampu4[$i];

            // Menambahkan jp dari pengampu saat ini ke total_jp
            $jp4 = $current_pengampu4->mapels->jp;
            $total_jp4 += $jp4;
            $selected_pengampus4[] = $current_pengampu4;

            // Jika total jp sudah tepat 44, keluar dari loop
            if ($total_jp4 == 10) {
                $found_combination4 = true;
                break;
            }

            // Iterasi melalui pengampu lainnya untuk mencari kombinasi yang tepat
            for ($j4 = $i + 1; $j4 < $pengampu_count4; $j4++) {
                $next_pengampu4 = $pengampu4[$j4];
                $jp4 = $next_pengampu4->mapels->jp;

                // Jika total jp bersama dengan pengampu saat ini sudah tepat 44, keluar dari loop
                if ($total_jp4 + $jp4 == 10) {
                    $total_jp4 += $jp4;
                    $selected_pengampus4[] = $next_pengampu4;
                    $found_combination4 = true;
                    break 2; // Keluar dari loop luar
                } elseif ($total_jp4 + $jp4 < 10) {
                    // Jika total jp masih kurang dari 44, tambahkan ke total_jp dan lanjutkan pencarian
                    $total_jp4 += $jp4;
                    $selected_pengampus4[] = $next_pengampu4;
                }
            }
        }

        // Jika ditemukan kombinasi yang total JP-nya tepat 44, buat entri jadwalmapel
        if ($found_combination4) {
            $hari4 = '4'; // Misalnya, hari diatur ke '4'
            $jamMulai4 = 7; // Jam mulai pertama
            $menitMulai4 = 0; // Menit mulai pertama
            foreach ($selected_pengampus4 as $pengampus4) {
                $tanggal4 = Carbon::now()->toDateString(); // '2023-40-47'
                $tanggal_tanpa_strip4 = str_replace("-", "", $tanggal4); // '20234047'

                // Generate 4 random digits
                $kode_acak4 = mt_rand(4000, 9999);
                do {
                    $kode_jadwalmapel4 = $tanggal_tanpa_strip4 . '.' . $kode_acak4;
                    $existingPengampu4 = Jadwalmapel::where('kode_jadwalmapel', $kode_jadwalmapel4)->first();
                } while (!empty($existingPengampu4));

                // $hari   = Hari::inRandomOrder()->first();
                $ruangan4 = Ruangan::where('id_jurusan', $pengampus4->mapels->id_jurusan)
                    ->where('type', $pengampus4->mapels->type)
                    ->inRandomOrder()
                    ->first();

                $jp4 = $pengampus4->mapels->jp;
                $totalMenit4 = $jp4 * 40;

                $jamSelesai4 = $jamMulai4 + intdiv($totalMenit4, 60); // Hitung jam selesai
                $menitSelesai4 = $menitMulai4 + ($totalMenit4 % 60); // Hitung menit selesai

                if ($menitSelesai4 >= 60) {
                    $jamSelesai4 += intdiv($menitSelesai4, 60); // Tambahkan jam jika menit melebihi 59
                    $menitSelesai4 %= 60; // Sisa dari pembagian adalah menit baru
                }

                $bersinggungan_istirahat_pagi4 = ($jamMulai4 < 10 && $jamSelesai4 >= 10) || ($jamMulai4 <= 10 && $jamSelesai4 >= 10 && $menitSelesai4 >= 20 && $menitMulai4 < 20);
                $bersinggungan_istirahat_siang4 = ($jamMulai4 < 12 && $jamSelesai4 >= 12) || ($jamMulai4 <= 12 && $jamSelesai4 >= 12 && $menitSelesai4 >= 20 && $menitMulai4 < 20);

                if ($bersinggungan_istirahat_pagi4) {
                    $menitSelesai4 += 20; // Tambahkan 20 menit
                }
                if ($bersinggungan_istirahat_siang4) {
                    $menitSelesai4 += 40; // Tambahkan 20 menit
                }
                if ($menitSelesai4 >= 60) {
                    $jamSelesai4 += intdiv($menitSelesai4, 60); // Tambahkan jam jika menit melebihi 59
                    $menitSelesai4 %= 60; // Sisa dari pembagian adalah menit baru
                }

                $waktu_mulai4 = sprintf('%02d:%02d', $jamMulai4, $menitMulai4);
                $waktu_selesai4 =  sprintf('%02d:%02d', $jamSelesai4, $menitSelesai4);
                $params4 = [
                    'kode_jadwalmapel' => $kode_jadwalmapel4,
                    'id_pengampu' => $pengampus4->id,
                    'id_hari'   => $hari4,
                    'id_waktu'  => $waktu_mulai4 . "-" . $waktu_selesai4,
                    'id_ruangan'  => $ruangan4->id,
                    'status' => '0',
                    'id_tahunajar' => $pengampus4->id_tahunajar,
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now(),

                ];

                Jadwalmapel::create($params4);
                $jamMulai4 = $jamSelesai4;
                $menitMulai4 = $menitSelesai4;
            }
        } else {
            echo "Tidak ditemukan kombinasi pengampu yang total JP-nya tepat 44.";
        }

        return redirect()->back();
    } // end method
}
