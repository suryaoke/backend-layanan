<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Cttnwalas;
use App\Models\Guru;
use App\Models\Jadwalmapel;
use App\Models\Kd3;
use App\Models\Kd4;
use App\Models\Kelas;
use App\Models\Ki3;
use App\Models\Ki4;
use App\Models\Kkm;
use App\Models\Mapel;
use App\Models\NilaiKd3;
use App\Models\NilaiKd4;
use App\Models\NilaisiswaKd3;
use App\Models\NilaisiswaKd4;
use App\Models\Pengampu;
use App\Models\Rombel;
use App\Models\Rombelsiswa;
use App\Models\Seksi;
use App\Models\Siswa;
use App\Models\Walas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StandarkompetensiController extends Controller
{
    public function SkAll($id)
    {


        $ki3 = Ki3::where('id_seksi', $id)->get();
        $ki4 = Ki4::where('id_seksi', $id)->get();
        $ki3data = Ki3::where('id_seksi', $id)->first();
        $kd3 = Kd3::where('id_ki3', $ki3data->id)->orderby('urutan', 'asc')->get();

        $ki4data = Ki4::where('id_seksi', $id)->first();
        $kd4 = Kd4::where('id_ki4', $ki4data->id)->orderby('urutan', 'asc')->get();

        $seksi = Seksi::where('id', $id)->first();
        $jadwal = Jadwalmapel::where('id', $seksi->id_jadwal)->first();
        $pengampu = Pengampu::where('id', $jadwal->id_pengampu)->first();


        return view('backend.data.standar_kompetensi.sk_all',  compact('pengampu', 'ki4data', 'kd4', 'ki3data', 'kd3', 'ki3', 'ki4'));
    }


    public function ki3Update(Request $request)
    {
        $ki3_id = $request->id;

        // Mengambil ki3 berdasarkan ID
        $ki3 = Ki3::findOrFail($ki3_id);

        // Mendapatkan id_mapel dari ki3
        $id_mapel = $ki3->seksis->jadwalMapels->pengampus->id_mapel;

        // Mendapatkan tingkat dari ki3
        $tingkat = $ki3->seksis->jadwalMapels->pengampus->kelass->tingkat;

        // Menemukan semua ki3 dengan id_mapel dan tingkat yang sama
        $ki3s_with_same_mapel_and_tingkat = Ki3::whereHas('seksis.jadwalMapels.pengampus.kelass', function ($query) use ($tingkat) {
            $query->where('tingkat', $tingkat);
        })->whereHas('seksis.jadwalMapels.pengampus', function ($query) use ($id_mapel) {
            $query->where('id_mapel', $id_mapel);
        })->get();

        // Mengupdate semua ki3 dengan id_mapel dan tingkat yang sama
        foreach ($ki3s_with_same_mapel_and_tingkat as $ki3_item) {
            $ki3_item->update([
                'ket' => $request->ket,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);
        }

        $notification = array(
            'message' => 'Ki3 Updated SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }


    public function ki4Update(Request $request)
    {
        $ki3_id = $request->id;

        // Mengambil ki3 berdasarkan ID
        $ki3 = Ki4::findOrFail($ki3_id);

        // Mendapatkan id_mapel dari ki3
        $id_mapel = $ki3->seksis->jadwalMapels->pengampus->id_mapel;

        // Mendapatkan tingkat dari ki3
        $tingkat = $ki3->seksis->jadwalMapels->pengampus->kelass->tingkat;

        // Menemukan semua ki3 dengan id_mapel dan tingkat yang sama
        $ki3s_with_same_mapel_and_tingkat = Ki4::whereHas('seksis.jadwalMapels.pengampus.kelass', function ($query) use ($tingkat) {
            $query->where('tingkat', $tingkat);
        })->whereHas('seksis.jadwalMapels.pengampus', function ($query) use ($id_mapel) {
            $query->where('id_mapel', $id_mapel);
        })->get();

        // Mengupdate semua ki3 dengan id_mapel dan tingkat yang sama
        foreach ($ki3s_with_same_mapel_and_tingkat as $ki3_item) {
            $ki3_item->update([
                'ket' => $request->ket,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);
        }

        $notification = array(
            'message' => 'Ki3 Updated SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }



    public function Kd3Store(Request $request)
    {
        // Dapatkan nilai 'id_seksi' dari tabel 'ki3' berdasarkan 'id_ki3' yang diberikan
        $id_seksi = Ki3::where('id', $request->id_ki3)->value('id_seksi');

        // Dapatkan nilai 'id_pengampu' dari tabel 'jadwalmapels' berdasarkan 'id_jadwal' yang ditemukan pada tabel 'seksis'
        $id_pengampu = JadwalMapel::where('id', function ($query) use ($id_seksi) {
            $query->select('id_jadwal')->from('seksis')->where('id', $id_seksi);
        })->value('id_pengampu');

        // Dapatkan nilai 'id_mapel' dan 'tingkat' dari tabel 'pengampus' berdasarkan 'id_pengampu'
        $pengampu = Pengampu::find($id_pengampu);
        $id_mapel = $pengampu->id_mapel;

        // Dapatkan nilai 'tingkat' dari tabel 'kelas' berdasarkan 'id_kelas' yang terkait dengan pengampu
        $tingkat = $pengampu->kelass->tingkat;

        // Mengambil semua data 'ki3' yang memiliki 'id_mapel' dan 'tingkat' yang sama
        $ki3sWithSameMapel = Ki3::whereHas('seksis.jadwalmapels', function ($query) use ($id_mapel, $tingkat) {
            $query->whereHas('pengampus', function ($q) use ($id_mapel, $tingkat) {
                $q->where('id_mapel', $id_mapel);
                $q->whereHas('kelass', function ($r) use ($tingkat) {
                    $r->where('tingkat', $tingkat);
                });
            });
        })
            ->where('id', '!=', $request->id_ki3)
            ->get();

        // Memasukkan data ke dalam tabel 'kd3' untuk setiap 'ki3' dengan 'id_mapel' yang sama
        foreach ($ki3sWithSameMapel as $ki3) {
            Kd3::insert([
                'id_ki3' => $ki3->id,
                'urutan' => $request->urutan,
                'ket' => $request->ket,
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),
            ]);
        }

        // Memasukkan data untuk 'id_ki3' saat ini
        Kd3::insert([
            'id_ki3' => $request->id_ki3,
            'urutan' => $request->urutan,
            'ket' => $request->ket,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        // Menyiapkan notifikasi untuk ditampilkan setelah pengalihan
        $notification = array(
            'message' => 'Kd3 berhasil dimasukkan',
            'alert-type' => 'success'
        );

        // Mengarahkan pengguna kembali ke halaman sebelumnya dengan notifikasi
        return redirect()->back()->with($notification);
    }



    public function Kd4Store(Request $request)
    {
        // Dapatkan nilai 'id_seksi' dari tabel 'ki4' berdasarkan 'id_ki4' yang diberikan
        $id_seksi = Ki4::where('id', $request->id_ki4)->value('id_seksi');

        // Dapatkan nilai 'id_pengampu' dari tabel 'jadwalmapels' berdasarkan 'id_jadwal' yang ditemukan pada tabel 'seksis'
        $id_pengampu = JadwalMapel::where('id', function ($query) use ($id_seksi) {
            $query->select('id_jadwal')->from('seksis')->where('id', $id_seksi);
        })->value('id_pengampu');

        // Dapatkan nilai 'id_mapel' dan 'tingkat' dari tabel 'pengampus' berdasarkan 'id_pengampu'
        $pengampu = Pengampu::find($id_pengampu);
        $id_mapel = $pengampu->id_mapel;

        // Dapatkan nilai 'tingkat' dari tabel 'kelas' berdasarkan 'id_kelas' yang terkait dengan pengampu
        $tingkat = $pengampu->kelass->tingkat;

        // Mengambil semua data 'ki4' yang memiliki 'id_mapel' dan 'tingkat' yang sama
        $ki4sWithSameMapel = Ki4::whereHas('seksis.jadwalmapels', function ($query) use ($id_mapel, $tingkat) {
            $query->whereHas('pengampus', function ($q) use ($id_mapel, $tingkat) {
                $q->where('id_mapel', $id_mapel);
                $q->whereHas('kelass', function ($r) use ($tingkat) {
                    $r->where('tingkat', $tingkat);
                });
            });
        })
            ->where('id', '!=', $request->id_ki4)
            ->get();

        // Memasukkan data ke dalam tabel 'kd4' untuk setiap 'ki4' dengan 'id_mapel' yang sama
        foreach ($ki4sWithSameMapel as $ki4) {
            Kd4::insert([
                'id_ki4' => $ki4->id,
                'urutan' => $request->urutan,
                'ket' => $request->ket,
                'created_by' => Auth::user()->id,
                'created_at' => Carbon::now(),
            ]);
        }

        // Memasukkan data untuk 'id_ki4' saat ini
        Kd4::insert([
            'id_ki4' => $request->id_ki4,
            'urutan' => $request->urutan,
            'ket' => $request->ket,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        // Menyiapkan notifikasi untuk ditampilkan setelah pengalihan
        $notification = array(
            'message' => 'Kd4 berhasil dimasukkan',
            'alert-type' => 'success'
        );

        // Mengarahkan pengguna kembali ke halaman sebelumnya dengan notifikasi
        return redirect()->back()->with($notification);
    } // end method



    public function NilaikdAll($id)
    {
        $nilaikd3 = NilaiKd3::where('id_seksi', $id)->orderby('ph', 'asc')->get();
        $nilaikd4 = NilaiKd4::where('id_seksi', $id)->orderby('ph', 'asc')->get();
        $seksi = Seksi::where('id', $id)->first();

        $datanilaikd3 = NilaiKd3::where('id_seksi', $id)->orderby('ph', 'desc')->first();
        $datanilaikd4 = NilaiKd4::where('id_seksi', $id)->orderby('ph', 'desc')->first();

        $ki3 = Ki3::where('id_seksi', $id)->first();
        $kd3 = null;
        if ($ki3) {
            $kd3 = Kd3::where('id_ki3', $ki3->id)->get();
        }

        $ki4 = Ki4::where('id_seksi', $id)->first();
        $kd4 = null;
        if ($ki4) {
            $kd4 = Kd4::where('id_ki4', $ki4->id)->get();
        }

        $jadwal = Jadwalmapel::where('id', optional($seksi)->id_jadwal)->first();
        $pengampu = Pengampu::where('id', optional($jadwal)->id_pengampu)->first();
        $rombel = Rombel::where('id_kelas', optional($pengampu)->kelas)->first();

        $nilaisiswakd3 = null;
        $kkm1 = null;
        if ($datanilaikd3) {
            $nilaisiswakd3 = NilaisiswaKd3::where('id_nilaikd3', $datanilaikd3->id)->get();

            $nilaisiswakd3id = NilaisiswaKd3::where('id_nilaikd3', $datanilaikd3->id)->first();
            $rombelsiswa = Rombelsiswa::where('id', $nilaisiswakd3id->id_rombelsiswa)->first();
            $rombel = Rombel::where('id', $rombelsiswa->id_rombel)->first();
            $kelas = Kelas::where('id', $rombel->id_kelas)->first();
            $kkm1 =  Kkm::where('id_kelas', $kelas->tingkat)->first();
        }


        $nilaisiswakd4 = null;
        if ($datanilaikd4) {
            $nilaisiswakd4 = NilaisiswaKd4::where('id_nilaikd4', $datanilaikd4->id)->get();
        }

        return view('backend.data.standar_kompetensi.nilaikd_all',  compact('kkm1', 'nilaisiswakd4', 'nilaisiswakd3', 'rombel', 'pengampu', 'datanilaikd4', 'kd4', 'ki4', 'kd3', 'ki3', 'datanilaikd3', 'seksi', 'nilaikd3', 'nilaikd4'));
    } // end method



    public function Nilaikd3Store(Request $request)
    {
        // Simpan data ke dalam tabel NilaiKd3
        $nilaikd3 = NilaiKd3::create([
            'id_kd3' => $request->id_kd3,
            'ph' => $request->ph,
            'id_seksi' => $request->id_seksi,
            'skema' => $request->skema,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);


        $search = $request->search;
        $rombelsiswa = Rombelsiswa::where('id_rombel', $search)->get();

        foreach ($rombelsiswa as $row) {

            $nilaisiswakd3 = new  NilaisiswaKd3();
            $nilaisiswakd3->id_rombelsiswa = $row->id;
            $nilaisiswakd3->id_nilaikd3 = $nilaikd3->id;
            $nilaisiswakd3->created_by = Auth::user()->id;
            $nilaisiswakd3->created_at = Carbon::now();
            $nilaisiswakd3->save();
        }

        // Set notifikasi untuk ditampilkan kepada pengguna
        $notification = array(
            'message' => 'NilaiKd3 Inserted Successfully',
            'alert-type' => 'success'
        );

        // Redirect kembali ke halaman sebelumnya dengan notifikasi
        return redirect()->back()->with($notification);
    }



    public function Nilaikd4Store(Request $request)
    {

        $nilaikd4 =  NilaiKd4::create([
            'id_kd4' => $request->id_kd4,
            'ph' => $request->ph,
            'id_seksi' => $request->id_seksi,
            'skema' => $request->skema,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $search = $request->search;
        $rombelsiswa = Rombelsiswa::where('id_rombel', $search)->get();

        foreach ($rombelsiswa as $row) {

            $nilaisiswakd4 = new  NilaisiswaKd4();
            $nilaisiswakd4->id_rombelsiswa = $row->id;
            $nilaisiswakd4->id_nilaikd4 = $nilaikd4->id;
            $nilaisiswakd4->created_by = Auth::user()->id;
            $nilaisiswakd4->created_at = Carbon::now();
            $nilaisiswakd4->save();
        }

        $notification = array(
            'message' => 'NilaiKd4 Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // end method



    public function Kd3Delete($id)
    {
        // Cari data Kd3 berdasarkan ID
        $kd3 = Kd3::find($id);

        if (!$kd3) {
            // Jika data tidak ditemukan, kembalikan response atau lakukan aksi sesuai kebutuhan aplikasi
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Mendapatkan ki3 berdasarkan id_ki3 dari kd3
        $ki3 = Ki3::where('id', $kd3->id_ki3)->first();

        // Mendapatkan id_mapel dari ki3
        $id_mapel = $ki3->seksis->jadwalMapels->pengampus->id_mapel;

        // Mendapatkan tingkat dari ki3
        $tingkat = $ki3->seksis->jadwalMapels->pengampus->kelass->tingkat;

        // Menghapus data Kd3 yang memiliki id_mapel dan tingkat yang sama dengan Kd3 yang akan dihapus
        Kd3::whereHas('ki3s.seksis.jadwalMapels.pengampus.kelass', function ($query) use ($id_mapel, $tingkat) {
            $query->where('id_mapel', $id_mapel)->where('tingkat', $tingkat);
        })->delete();

        // Hapus data Kd3
        $kd3->delete();

        // Siapkan notifikasi untuk ditampilkan setelah penghapusan
        $notification = array(
            'message' => 'Kd3 berhasil dihapus',
            'alert-type' => 'success'
        );

        // Redirect atau kembalikan response sesuai kebutuhan aplikasi
        return redirect()->back()->with($notification);
    }


    public function Kd4Delete($id)
    {
        // Cari data Kd4 berdasarkan ID
        $kd4 = Kd4::find($id);

        if (!$kd4) {
            // Jika data tidak ditemukan, kembalikan response atau lakukan aksi sesuai kebutuhan aplikasi
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Mendapatkan ki4 berdasarkan id_ki4 dari kd4
        $ki4 = Ki4::where('id', $kd4->id_ki4)->first();

        // Mendapatkan id_mapel dari ki4
        $id_mapel = $ki4->seksis->jadwalMapels->pengampus->id_mapel;

        // Mendapatkan tingkat dari ki4
        $tingkat = $ki4->seksis->jadwalMapels->pengampus->kelass->tingkat;

        // Menghapus data Kd4 yang memiliki id_mapel dan tingkat yang sama dengan Kd4 yang akan dihapus
        Kd4::whereHas('ki4s.seksis.jadwalMapels.pengampus.kelass', function ($query) use ($id_mapel, $tingkat) {
            $query->where('id_mapel', $id_mapel)->where('tingkat', $tingkat);
        })->delete();

        // Hapus data Kd4
        $kd4->delete();

        // Siapkan notifikasi untuk ditampilkan setelah penghapusan
        $notification = array(
            'message' => 'Kd4 berhasil dihapus',
            'alert-type' => 'success'
        );

        // Redirect atau kembalikan response sesuai kebutuhan aplikasi
        return redirect()->back()->with($notification);
    }

    public function Nilaikd3Delete($id)
    {
        $nilaikd3 = NilaiKd3::findOrFail($id);
        if ($nilaikd3) {
            $nilaikd3->delete();
            NilaisiswaKd3::where('id_nilaikd3', $id)->delete();
            $notification = array(
                'message' => 'NilaiKd3 Deleted SuccessFully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'NilaiKd3 not found',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    } // end method

    public function Nilaikd4Delete($id)
    {
        $nilaikd4 = NilaiKd4::findOrFail($id);
        if ($nilaikd4) {
            $nilaikd4->delete();
            NilaisiswaKd4::where('id_nilaikd4', $id)->delete();
            $notification = array(
                'message' => 'NilaiKd4 Deleted SuccessFully',
                'alert-type' => 'success'
            );
            return redirect()->back()->with($notification);
        } else {
            $notification = array(
                'message' => 'NilaiKd4 not found',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
    } // end method


    public function Nilaisiswakd3Update(Request $request)
    {
        $cttnwalas_ids = $request->id; // Ambil array id dari permintaan
        foreach ($cttnwalas_ids as $key => $cttnwalas_id) {
            $nilaiSiswaKd3 = NilaisiswaKd3::findOrFail($cttnwalas_id); // Mencari data sesuai dengan id

            $nilaiSiswaKd3->nilai = $request->nilai[$key]; // Perbarui nilai
            $nilaiSiswaKd3->remedial = $request->remedial[$key]; // Perbarui remedial
            $nilaiSiswaKd3->feedback = $request->feedback[$key]; // Perbarui feedback
            $nilaiSiswaKd3->status = $request->status[$key];

            $nilaiSiswaKd3->updated_by = Auth::user()->id; // Perbarui updated_by dengan user yang sedang login
            $nilaiSiswaKd3->updated_at = Carbon::now(); // Perbarui updated_at dengan waktu sekarang

            $nilaiSiswaKd3->save(); // Simpan perubahan
        }

        $notification = array(
            'message' => 'Nilaisiswakd3 Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    public function Nilaisiswakd4Update(Request $request)
    {
        $cttnwalas_ids = $request->id; // Ambil array id dari permintaan
        foreach ($cttnwalas_ids as $key => $cttnwalas_id) {
            $nilaiSiswaKd4 = NilaisiswaKd4::findOrFail($cttnwalas_id); // Mencari data sesuai dengan id

            $nilaiSiswaKd4->nilai = $request->nilai[$key]; // Perbarui nilai
            $nilaiSiswaKd4->remedial = $request->remedial[$key]; // Perbarui remedial
            $nilaiSiswaKd4->feedback = $request->feedback[$key]; // Perbarui feedback
            $nilaiSiswaKd4->status = $request->status[$key];
            $nilaiSiswaKd4->updated_by = Auth::user()->id; // Perbarui updated_by dengan user yang sedang login
            $nilaiSiswaKd4->updated_at = Carbon::now(); // Perbarui updated_at dengan waktu sekarang

            $nilaiSiswaKd4->save(); // Simpan perubahan
        }

        $notification = array(
            'message' => 'Nilaisiswakd4 Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }


    public function NilaiSiswaGuruWalas(Request $request)
    {

        $searchMapel = $request->input('searchmapel');
        $searchMapel1 = $request->input('searchmapel1');
        $query = NilaisiswaKd3::query();
        $query1 = NilaisiswaKd4::query();

        if (!empty($searchMapel)) {
            $query->whereHas('nilaikd3', function ($nilaiQuery) use ($searchMapel) {
                $nilaiQuery->whereHas('seksis', function ($seksiQuery) use ($searchMapel) {
                    $seksiQuery->whereHas('jadwalmapels', function ($jadwalQuery) use ($searchMapel) {
                        $jadwalQuery->whereHas('pengampus', function ($pengampuQuery) use ($searchMapel) {
                            $pengampuQuery->whereHas('mapels', function ($mapelQuery) use ($searchMapel) {
                                $mapelQuery->where('id', 'LIKE', '%' . $searchMapel . '%');
                            });
                        });
                    });
                });
            });
        }



        if (!empty($searchMapel1)) {
            $query1->whereHas('nilaikd4', function ($nilaiQuery) use ($searchMapel1) {
                $nilaiQuery->whereHas('seksis', function ($seksiQuery) use ($searchMapel1) {
                    $seksiQuery->whereHas('jadwalmapels', function ($jadwalQuery) use ($searchMapel1) {
                        $jadwalQuery->whereHas('pengampus', function ($pengampuQuery) use ($searchMapel1) {
                            $pengampuQuery->whereHas('mapels', function ($mapelQuery) use ($searchMapel1) {
                                $mapelQuery->where('id', 'LIKE', '%' . $searchMapel1 . '%');
                            });
                        });
                    });
                });
            });
        }


        $userId = Auth::user()->id;
        $guru = Guru::where('id_user', $userId)->first();
        $walas = $guru ? Walas::where('id_guru', $guru->id)->first() : null;
        $siswa = null; // inisialisasi variabel $siswa



        if ($walas) {
            $rombel = Rombel::where('id_walas', $walas->id)->first();
            if ($rombel) {
                $rombelSiswaIds = RombelSiswa::where('id_rombel', $rombel->id)->pluck('id')->toArray();
                if ($rombelSiswaIds) {
                    $rombelSiswa = RombelSiswa::whereIn('id', $rombelSiswaIds)->get();
                    if ($rombelSiswa) {
                        $nilaiSiswaKd3 = $query->whereIn('id_rombelsiswa', $rombelSiswaIds)->get();
                        $nilaiSiswaKd4 = $query1->whereIn('id_rombelsiswa', $rombelSiswaIds)->get();
                    }
                }
            }
        }

        $data = [
            'walas' => $walas,
            'siswa' => $siswa,
        ];

        return view('backend.data.nilai.nilai_siswaguruwalas', compact('nilaiSiswaKd4', 'rombel', 'nilaiSiswaKd3', 'data', 'walas', 'siswa'));
    }
}
