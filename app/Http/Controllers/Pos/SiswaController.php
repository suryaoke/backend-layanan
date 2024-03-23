<?php

namespace App\Http\Controllers\Pos;

use App\Exports\SiswaExport;
use App\Exports\SiswaWalasExport;
use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Jadwalmapel;
use App\Models\Kelas;
use App\Models\Pengampu;
use App\Models\Rombel;
use App\Models\Rombelsiswa;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Walas;
use Carbon\Carbon;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function Pest\Laravel\get;
use App\Imports\SiswaImport;
use App\Models\Jurusan;
use App\Models\Tahunajar;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    public function SiswaAll(request $request)
    {

        $searchNisn = $request->input('searchnisn');
        $searchNama = $request->input('searchnama');
        $searchJk = $request->input('searchjk');
        $searchUsername = $request->input('searchusername');

        $query = Siswa::query();
        if (!empty($searchNisn)) {
            $query->where('nisn', '=', $searchNisn);
        }
        if (!empty($searchNama)) {
            $query->where('nama', '=', $searchNama);
        }
        if (!empty($searchJk)) {
            $query->where('jk', '=', $searchJk);
        }

        if (!empty($searchUsername)) {
            $query->whereHas('users', function ($lecturerQuery) use ($searchUsername) {
                $lecturerQuery->where('username', 'LIKE', '%' . $searchUsername . '%');
            });
        }

        $siswa = $query->orderBy('nama')
            ->get();

        return view('backend.data.siswa.siswa_all', compact('siswa'));
    } // end method

    public function SiswaAdd()
    {
        $orangtuaIds = Siswa::pluck('id_user')->toArray();
        $user = User::where('role', '6')
            ->whereNotIn('id', $orangtuaIds)
            ->get();
        return view('backend.data.siswa.siswa_add', compact('user'));
    } // end method
    public function SiswaStore(Request $request)
    {
        $request->validate([
            'nisn' => ['required', 'string', 'max:255', 'unique:' . Siswa::class],

        ]);

        $siswa = [
            'nama' => $request->nama,
            'nisn' => $request->nisn,
            'jk' => $request->jk,
            'tempat' => $request->tempat,
            'tanggal' => $request->tanggal,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ];

        $user = null;

        if ($request->has('username') && $request->username !== null) {
            // Membuat email unik dengan menggunakan waktu saat ini
            $email =  time() . '@example.com';

            $user = User::create([
                'name' => $request->nama,
                'username' => $request->username,
                'email' => $email,
                'profile_image' => '',
                'role' => 6,
                'status' => 1,
                'password' => Hash::make($request->password),
            ]);
            $siswa['id_user'] = $user->id;
        }
        $siswadata = Siswa::create($siswa);


        $notification = array(
            'message' => 'Siswa Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('siswa.all')->with($notification);
    }


    public function SiswaEdit($id)
    {
        $siswa = Siswa::findOrFail($id);

        $user = User::where('role', '6')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('siswas')
                    ->whereRaw('siswas.id_user = users.id');
            })
            ->get();
        return view('backend.data.siswa.siswa_edit', compact('siswa', 'user'));
    }
    public function SiswaUpdate(Request $request)
    {


        $siswa = Siswa::findOrFail($request->id);
        $siswa->update([
            'nama' => $request->nama,
            'nisn' => $request->nisn,
            'jk' => $request->jk,
            'id_user' => $request->id_user,
            'tempat' => $request->tempat,
            'tanggal' => $request->tanggal,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);
        if ($request->has('username')) {
            User::where('id', $siswa->id_user)->update([
                'username' => $request->username,
                'name'  => $siswa->nama,
            ]);
        }

        $notification = array(
            'message' => 'Siswa Updated SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('siswa.all')->with($notification);
    }

    public function SiswaDelete($id)
    {
        Siswa::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Siswa Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $siswa = Siswa::where(function ($query) use ($search) {
            $query->where('kelas', 'like', "%$search");
        })->orderBy('nama', 'asc')->paginate(perPage: 50);
        $kelas = Kelas::orderBy('nama')->get();

        return view('backend.data.siswa.siswa_all', compact('siswa', 'search', 'kelas'));
    }

    public function SiswaProfile()
    {

        return view('backend.data.siswa.siswa_profile');
    } // end method

    public function SiswaGuru()
    {
        $userId = Auth::user()->id;

        // Ambil ID guru berdasarkan ID user yang aktif
        $guruId = Guru::where('id_user', $userId)->value('id');

        // Ambil ID pengampu yang berelasi dengan guru melalui jadwalmapels
        $pengampuIds = Jadwalmapel::whereHas('pengampus', function ($query) use ($guruId) {
            $query->where('id_guru', $guruId);
        })->pluck('id_pengampu')->unique();

        // Ambil data siswa dengan kelas yang sama dengan pengampu yang diambil dari jadwalmapels
        $siswa = Siswa::whereIn('kelas', function ($query) use ($pengampuIds) {
            $query->select('kelas')
                ->from('pengampus')
                ->whereIn('id', $pengampuIds);
        })
            ->orderBy('kelas', 'desc')
            ->orderBy('nama', 'asc')
            ->paginate(50);

        // Sekarang $siswa akan berisi data siswa yang terkait dengan guru yang aktif melalui jadwalmapels


        // Sekarang $siswa akan berisi data siswa dengan kelas yang diajar oleh guru yang aktif

        return view('backend.data.siswa.siswa_guru', compact('siswa'));
    } // end method

    public function SiswaGuruwalas(request $request)
    {

        $searchTahun = $request->input('searchtahun');
        $searchNisn = $request->input('searchnisn');
        $searchNama = $request->input('searchnama');
        $searchJk = $request->input('searchjk');
        $query = Rombelsiswa::query();

        if (!empty($searchTahun)) {
            $query->whereHas('rombels', function ($teachQuery) use ($searchTahun) {
                $teachQuery->whereHas('tahuns', function ($courseQuery) use ($searchTahun) {
                    $courseQuery->where('id', 'LIKE', '%' .   $searchTahun . '%');
                });
            });
        }

        if (!empty($searchNisn)) {
            $query->whereHas('siswas', function ($lecturerQuery) use ($searchNisn) {
                $lecturerQuery->where('nisn', 'LIKE', '%' . $searchNisn . '%');
            });
        }
        if (!empty($searchNama)) {
            $query->whereHas('siswas', function ($lecturerQuery) use ($searchNama) {
                $lecturerQuery->where('nama', 'LIKE', '%' . $searchNama . '%');
            });
        }

        if (!empty($searchJk)) {
            $query->whereHas('siswas', function ($lecturerQuery) use ($searchJk) {
                $lecturerQuery->where('jk', 'LIKE', '%' . $searchJk . '%');
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

            $rombelsiswa = $query->join('rombels', 'rombelsiswas.id_rombel', '=', 'rombels.id')
                ->join('walas', 'rombels.id_walas', '=', 'walas.id')
                ->join('gurus', 'walas.id_guru', '=', 'gurus.id')
                ->where('gurus.id_user', '=', $userId)
                ->select('rombelsiswas.*') // Memilih semua kolom dari tabel catata_walas
                ->get();
            $datarombelsiswa =
                $rombelsiswa->first();
        } elseif ($searchTahun) {

            $userId = Auth::user()->id;

            $rombelsiswa = $query->join('rombels', 'rombelsiswas.id_rombel', '=', 'rombels.id')
                ->join('walas', 'rombels.id_walas', '=', 'walas.id')
                ->join('gurus', 'walas.id_guru', '=', 'gurus.id')
                ->where('gurus.id_user', '=', $userId)
                ->select('rombelsiswas.*') // Memilih semua kolom dari tabel catata_walas
                ->get();
            $datarombelsiswa =
                $rombelsiswa->first();
        } else {

            $userId = Auth::user()->id;

            $rombelsiswa = $query->join('rombels', 'rombelsiswas.id_rombel', '=', 'rombels.id')
                ->join('walas', 'rombels.id_walas', '=', 'walas.id')
                ->join('gurus', 'walas.id_guru', '=', 'gurus.id')
                ->where('rombels.id_tahunjar', $tahunAjarSaatIni->id)
                ->where('gurus.id_user', '=', $userId)
                ->select('rombelsiswas.*') // Memilih semua kolom dari tabel catata_walas
                ->get();
            $datarombelsiswa =
                $rombelsiswa->first();
        }

        $datatahun = Tahunajar::whereHas('rombels', function ($query) use ($userId) {
            $query->join('walas', 'rombels.id_walas', '=', 'walas.id')
                ->join('gurus', 'walas.id_guru', '=', 'gurus.id')
                ->where('gurus.id_user', '=', $userId);
        })->orderBy('id', 'desc')
            ->get();

        return view('backend.data.siswa.siswa_guruwalas', compact('datarombelsiswa', 'datatahun', 'rombelsiswa'));
    }

    public function siswaImport(Request $request)
    {
        // Pastikan file telah diunggah sebelum melanjutkan
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $namfile = date('YmdHi') . $file->getClientOriginalName();
            $file->move('DataSiswa', $namfile);
            Excel::import(new SiswaImport, public_path('/DataSiswa/' . $namfile));
        } else {
            // File tidak diunggah atau tidak valid
            $notification = [
                'message' => 'Siswa Upload Successfully',
                'alert-type' => 'success'
            ];
        }

        return redirect()->route('siswa.all')->with($notification);
    }

    public function SiswaWalasEdit($id)
    {
        $siswa = Siswa::findOrFail($id);

        $user = User::where('role', '6')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('siswas')
                    ->whereRaw('siswas.id_user = users.id');
            })
            ->get();
        return view('backend.data.siswa.siswa_guruwalas_edit', compact('siswa', 'user'));
    }

    public function SiswaWalasUpdate(Request $request)
    {

        $siswa = Siswa::findOrFail($request->id);
        $siswa->update([
            'nis' => $request->nis,
            'nisn' => $request->nisn,
            'nama' => $request->nama,
            'jk' => $request->jk,
            'tempat' => $request->tempat,
            'tanggal' => $request->tanggal,
            'agama' => $request->agama,
            'status_keluarga' => $request->status_keluarga,
            'anak_ke' => $request->anak_ke,
            'no_hp' => $request->no_hp,
            'alamat_siswa' => $request->alamat_siswa,
            'alamat_sekolah' => $request->alamat_sekolah,
            'nama_ayah' => $request->nama_ayah,
            'nama_ibu' => $request->nama_ibu,
            'pekerjaan_ayah' => $request->pekerjaan_ayah,
            'pekerjaan_ibu' => $request->pekerjaan_ibu,
            'alamat_ortu' => $request->alamat_ortu,
            'nama_wali' => $request->nama_wali,
            'pekerjaan_wali' => $request->pekerjaan_wali,
            'alamat_wali' => $request->alamat_wali,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);


        $notification = array(
            'message' => 'Siswa Updated SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('siswa.guruwalas')->with($notification);
    }

    public function SiswaWalasExport(Request $request)
    {
        $tahunId =  $request->input('tahun');
        $userId = Auth::user()->id;

        $rombelsiswa = Rombelsiswa::join('rombels', 'rombelsiswas.id_rombel', '=', 'rombels.id')
            ->join('walas', 'rombels.id_walas', '=', 'walas.id')
            ->join('gurus', 'walas.id_guru', '=', 'gurus.id')
            ->where('rombels.id_tahunjar', $tahunId)
            ->where('gurus.id_user', '=', $userId)
            ->select('rombelsiswas.*') // Memilih semua kolom dari tabel catata_walas
            ->get();
        $datarombelsiswa = $rombelsiswa->first();
        $rombel = Rombel::where('id', $datarombelsiswa->id_rombel)->first();
        $kelas = Kelas::where('id', $rombel->id_kelas)->first();
        $jurusan = Jurusan::where('id', $kelas->id_jurusan)->first();

        $tahun = Tahunajar::where('id', $tahunId)->first();

        $fileName = 'Data Siswa Kelas' . ' ' . $kelas->tingkat . $kelas->nama . $jurusan->nama . ' ' . 'Tahun Ajar ' . $tahun->tahun . ' Semester ' . $tahun->semester . '.xlsx';


        return Excel::download(new SiswaWalasExport($rombelsiswa, $tahun), $fileName);
    }


    public function SiswaExport(Request $request)
    {


        $siswa = Siswa::orderby('nama')->get();

        return Excel::download(new SiswaExport($siswa), 'Data Siswa.xlsx');
    }
}
