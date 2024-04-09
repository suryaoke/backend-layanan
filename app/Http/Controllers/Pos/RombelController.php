<?php

namespace App\Http\Controllers\Pos;

use App\Exports\RombelExport;
use App\Http\Controllers\Controller;
use App\Models\CatataWalas;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Rapor;
use App\Models\Rombel;
use App\Models\Rombelsiswa;
use App\Models\Seksi;
use App\Models\Siswa;
use App\Models\Tahunajar;
use App\Models\Walas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class RombelController extends Controller
{
    public function RombelAll(request $request)
    {
        $searchKelas = $request->input('searchkelas');
        $searchTahun = $request->input('searchtahun');
        $searchWalas = $request->input('searchwalas');

        $query = Rombelsiswa::query();
        $query2 = Rombel::query();

        if (!empty($searchKelas)) {
            $query->whereHas('rombels', function ($teachQuery) use ($searchKelas) {
                $teachQuery->whereHas('kelass', function ($courseQuery) use ($searchKelas) {
                    $courseQuery->where('id', 'LIKE', '%' .   $searchKelas . '%');
                });
            });


            $query2->whereHas('kelass', function ($lecturerQuery) use ($searchKelas) {
                $lecturerQuery->where('id', 'LIKE', '%' . $searchKelas . '%');
            });
        }

        if (!empty($searchTahun)) {
            $query->whereHas('rombels', function ($teachQuery) use ($searchTahun) {
                $teachQuery->whereHas('tahuns', function ($courseQuery) use ($searchTahun) {
                    $courseQuery->where('id', 'LIKE', '%' .   $searchTahun . '%');
                });
            });


            $query2->whereHas('tahuns', function ($lecturerQuery) use ($searchTahun) {
                $lecturerQuery->where('id', 'LIKE', '%' . $searchTahun . '%');
            });
        }

        if (!empty($searchWalas)) {
            $query->whereHas('rombels', function ($teachQuery) use ($searchWalas) {
                $teachQuery->whereHas('walass', function ($courseQuery) use ($searchWalas) {

                    $courseQuery->whereHas('gurus', function ($course1Query) use ($searchWalas) {

                        $course1Query->where('id', 'LIKE', '%' .   $searchWalas . '%');
                    });
                });
            });


            $query2->whereHas('walass', function ($teachQuery) use ($searchWalas) {
                $teachQuery->whereHas('gurus', function ($courseQuery) use ($searchWalas) {
                    $courseQuery->where('id', 'LIKE', '%' .   $searchWalas . '%');
                });
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
            $searchTahun ==  $tahunAjartidakSaatIni->id || $searchKelas
        ) {
            $rombelsiswaa = $query
                ->orderBy('id_rombel', 'asc')
                ->get();
            $rombelsiswa = $rombelsiswaa
                ->first();
            $rombel = $query2->get();
        } elseif ($searchTahun) {
            $rombelsiswaa = $query
                ->join('rombels', 'rombelsiswas.id_rombel', '=', 'rombels.id')
                ->where('rombels.id_tahunjar', $tahunAjarSaatIni->id)
                ->orderBy('id_rombel', 'asc')
                ->get();

            $rombelsiswa =
                $rombelsiswaa->first();
            $rombel = $query2->get();
        } else {
            $rombelsiswaa = $query
                ->join('rombels', 'rombelsiswas.id_rombel', '=', 'rombels.id')
                ->where('rombels.id_tahunjar', $tahunAjarSaatIni->id)
                ->orderBy('id_rombel', 'asc')
                ->get();
            if (!$rombelsiswaa->isEmpty()) {
                // Mendapatkan id_rombel terkecil dari koleksi menggunakan first()
                $id_rombel_terkecil = $rombelsiswaa->first()->id_rombel;

                // Memfilter kembali koleksi untuk hanya menyertakan data dengan id_rombel terkecil
                $rombelsiswaa = $rombelsiswaa->where('id_rombel', $id_rombel_terkecil);
            }
            $rombelsiswa =
                $rombelsiswaa->first();
            $rombel = $query2->get();
        }



        $datatahun = Tahunajar::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('rombels')
                ->whereRaw('rombels.id_tahunjar = tahunajars.id');
        })->orderby('id', 'desc')
            ->get();
        $kelas = Kelas::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('rombels')
                ->whereRaw('rombels.id_kelas = kelas.id');
        })->orderby('tingkat', 'desc')
            ->get();
        $guru = Guru::whereExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('walas')
                ->join('rombels', 'rombels.id_walas', '=', 'walas.id')
                ->whereRaw('walas.id = gurus.id');
        })->orderBy('nama')
            ->get();

      


        return view('backend.data.rombel.rombel_all', compact('datatahun', 'kelas', 'rombelsiswaa', 'rombelsiswa', 'rombel', 'guru'));
    } // end method

    public function RombelAdd()
    {

        $guru = Guru::orderBy('kode_gr', 'asc')->get();
        $kelas = Kelas::orderBy('tingkat', 'asc')
            ->whereIn('id', function ($query) {
                $query->select('id_kelas')
                    ->from('walas');
            })
            ->get();


        $walas = Walas::orderBy('id', 'asc')
            ->whereNotIn('id', function ($query) {
                $query->select('id_walas')
                    ->from('rombels');
            })
            ->get();


        $siswa = Siswa::orderBy('id', 'asc')

            ->get();
        $tahun = Tahunajar::orderby('id')->get();

        return view('backend.data.rombel.rombel_add', compact('tahun', 'siswa', 'walas', 'guru', 'kelas'));
    } // end method
    public function RombelStore(Request $request)
    {

        $rombel = Rombel::create([
            'kode_rombel' => $request->kode_rombel,
            'id_walas' => $request->id_walas,
            'id_kelas' => $request->id_kelas,
            'id_tahunjar' => $request->id_tahunjar,
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

            $cttn = CatataWalas::insert([
                'id_tahunajar' => $request->id_tahunjar,
                'id_rombelsiswa' => $rombelsiswa->id // Menggunakan id siswa dari setiap iterasi

            ]);

            $nilai = array_fill(0, 7, "-");
            $nilai2 = array_fill(0, 5, "-"); // Membuat array dengan panjang 7 dan mengisi semua nilai dengan "-"
            $rapor = Rapor::insert([
                'id_tahunajar' => $request->id_tahunjar,
                'id_rombelsiswa' => $rombelsiswa->id, // Menggunakan id siswa dari setiap iterasi
                'nilai_sosial' => json_encode($nilai), // Menyimpan nilai sosial sebagai string JSON
                'nilai_spiritual' => json_encode($nilai2),
                'naik_kelas' => 0
            ]);
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
                    ->from('walas')
                    ->where('id', '=', 'walas.id_kelas');
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


        $selectedSiswa = RombelSiswa::where('id_rombel', $id)->pluck('id_siswa')->all();
        $tahun = Tahunajar::orderby('id')->get();

        return view('backend.data.rombel.rombel_edit', compact('tahun', 'siswa', 'walas', 'guru', 'kelas', 'rombel', 'selectedSiswa'));
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
        $rombel->id_tahunjar = $request->id_tahunjar;
        $rombel->updated_by = Auth::user()->id; // Atur pengguna yang melakukan pembaruan
        $rombel->updated_at = Carbon::now(); // Atur waktu pembaruan

        $rombel->save();

        // Menghapus RombelSiswa yang tidak termasuk dalam kumpulan siswa yang diberikan

        $deletedRombelSiswa = RombelSiswa::where('id_rombel', $id)
            ->whereNotIn('id_siswa', $request->input('id_siswa', []))
            ->get();

        foreach ($deletedRombelSiswa as $rombelsiswa) {
            // Menghapus catatan wali kelas
            CatataWalas::where('id_rombelsiswa', $rombelsiswa->id)->delete();

            // Menghapus data rapor
            Rapor::where('id_rombelsiswa', $rombelsiswa->id)->delete();

            // Menghapus entri RombelSiswa
            $rombelsiswa->delete();
        }

        if (!RombelSiswa::where('id_rombel', $id)->exists()) {
            // Jika tidak ada, hapus juga Rombel
            $rombel->delete();
        }
        // Memperbarui atau tambahkan RombelSiswa baru
        $selectedSiswa = $request->input('id_siswa');
        if (!is_null($selectedSiswa)) {
            foreach ($selectedSiswa as $siswaId) {
                $siswa =  RombelSiswa::updateOrCreate(
                    ['id_rombel' => $id, 'id_siswa' => $siswaId],
                    ['id_rombel' => $id, 'id_siswa' => $siswaId]
                );

                // Periksa apakah CatataWalas sudah ada
                $existingCttn = CatataWalas::where('id_rombelsiswa', $siswa->id)->exists();
                if (!$existingCttn) {
                    // Menambahkan catatan wali kelas
                    $cttn = CatataWalas::create([
                        'id_tahunajar' => $rombel->id_tahunjar,
                        'id_rombelsiswa' => $siswa->id,
                    ]);
                }

                // Periksa apakah Rapor sudah ada
                $existingRapor = Rapor::where('id_rombelsiswa', $siswa->id)->exists();
                if (!$existingRapor) {
                    // Menambahkan data rapor
                    $nilai = array_fill(0, 7, "-");
                    $rapor = Rapor::create([
                        'id_tahunajar' => $rombel->id_tahunjar,
                        'id_rombelsiswa' => $siswa->id,
                        'nilai_sosial' => json_encode($nilai),
                        'nilai_spiritual' => json_encode($nilai),
                    ]);
                }
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
            $seksi =  Seksi::where('id_rombel', $id)->first(); // Mengambil data seksi sebelum dihapus
            if ($seksi) {
                $nilai = Nilai::where('id_seksi', $seksi->id)->delete();
                $seksi->delete();
            }

            RombelSiswa::where('id_rombel', $id)->delete();

            $rombel->delete();
            $notification = array(
                'message' => 'Rombel Deleted Successfully',
                'alert-type' => 'success'
            );
            return redirect()->route('rombel.all')->with($notification);
        } else {
            $notification = array(
                'message' => 'Rombel not found',
                'alert-type' => 'error'
            );
            return redirect()->route('rombel.all')->with($notification);
        }
    }


    public function RombelExport(Request $request)
    {
        $tahun =  $request->input('tahun');
        $kelas =  $request->input('kelas');

        $rombelsiswa = Rombelsiswa::orderBy('id_rombel', 'asc')
            ->join('rombels', 'rombelsiswas.id_rombel', '=', 'rombels.id')
            ->where('rombels.id_tahunjar', $tahun)
            ->where('rombels.id_kelas', $kelas)
            ->get();
        $kelasdata = Kelas::where('id', $kelas)->first();
        $tahundata = Tahunajar::where('id', $tahun)->first();
        $jurusan = Jurusan::where('id', $kelasdata->id_jurusan)->first();

        $fileName = 'Data Rombel Kelas' . ' ' . $kelasdata->tingkat . $kelasdata->nama . $jurusan->nama . ' ' . 'Tahun Ajar' . ' ' . $tahundata->tahun . ' Semester ' . $tahundata->semester . '.xlsx';

        return Excel::download(new RombelExport($rombelsiswa), $fileName);
    }
}
