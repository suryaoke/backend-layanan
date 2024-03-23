<?php

namespace App\Http\Controllers\Pos;

use App\Exports\GuruExport;
use App\Http\Controllers\Controller;
use App\Imports\GuruImport;
use App\Imports\UserImport;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class GuruController extends Controller
{
    public function GuruAll(request $request)
    {

        $searchKode = $request->input('searchkode');
        $searchNama = $request->input('searchnama');
        $searchNohp = $request->input('searchnohp');
        $searchWalas = $request->input('searchwalas');
        $searchUsername = $request->input('searchusername');


        $query = Guru::query();
        if (!empty($searchKode)) {
            $query->where('kode_gr', '=', $searchKode);
        }
        if (!empty($searchNama)) {
            $query->where('nama', '=', $searchNama);
        }
        if (!empty($searchNohp)) {
            $query->where('no_hp', '=', $searchNohp);
        }

        if (!empty($searchWalas)) {
            $query->whereHas('walass', function ($lecturerQuery) use ($searchWalas) {
                $lecturerQuery->whereHas('kelass', function ($courseQuery) use ($searchWalas) {
                    $courseQuery->where('id', 'LIKE', '%' .  $searchWalas . '%');
                });
            });
        }
        if (!empty($searchUsername)) {
            $query->whereHas('users', function ($lecturerQuery) use ($searchUsername) {
                $lecturerQuery->where('username', 'LIKE', '%' . $searchUsername . '%');
            });
        }
        $guru = $query->OrderBy('kode_gr')->get();

        $kelas = Kelas::whereIn('id', function ($query) {
            $query->select('id_kelas')
                ->from('walas');
        })->orderBy('tingkat')
            ->get();


        return view('backend.data.guru.guru_all', compact('guru', 'kelas'));
    } // end method

    public function GuruAdd()
    {

        $guruIds = Guru::pluck('id_user')->toArray();
        $user = User::where('role', '4')
            ->whereNotIn('id', $guruIds)
            ->get();



        return view('backend.data.guru.guru_add', compact('user'));
    } // end method
    public function GuruStore(Request $request)
    {
        $this->validate($request, [
            'kode_gr' => 'required|max:50|unique:gurus,kode_gr',
            'nama' => 'required',
            'no_hp' => 'required',
            'password' => 'required|min:8',
        ]);

        $guruData = [
            'kode_gr' => $request->kode_gr,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'created_by' => Auth::id(),
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
                'role' => 4,
                'status' => 1,
                'password' => Hash::make($request->password),
            ]);
            $guruData['id_user'] = $user->id;
        }
        $guru = Guru::create($guruData);
        $notification = array(
            'message' => 'Guru Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('guru.all')->with($notification);
    }


    public function GuruEdit($id)
    {
        $guru = Guru::findOrFail($id);

        $user = User::where('role', '4')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('gurus')
                    ->whereRaw('gurus.id_user = users.id');
            })
            ->get();
        // Mendapatkan semua user yang belum digunakan pada tabel guru


        return view('backend.data.guru.guru_edit', compact('guru', 'user'));
    }

    public function GuruUpdate(Request $request)
    {
        $this->validate($request, [
            'kode_gr' => 'required|max:50',
            'nama' => 'required',
            'no_hp' => 'required',

        ]);

        $guru = Guru::findOrFail($request->id);
        $guru->update([
            'kode_gr' => $request->kode_gr,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'id_user' => $request->id_user,
            'updated_by' => Auth::id(),
            'updated_at' => now(),
        ]);

        if ($request->has('username')) {
            User::where('id', $guru->id_user)->update([
                'username' => $request->username,
                'name'  => $guru->nama,
            ]);
        }

        $notification = [
            'message' => 'Guru Updated Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('guru.all')->with($notification);
    }


    public function GuruDelete($id)
    {
        Guru::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Guru Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function guruImport(Request $request)
    {
        // Pastikan file telah diunggah sebelum melanjutkan
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $namfile = date('YmdHi') . $file->getClientOriginalName();
            $file->move('DataGuru', $namfile);
            Excel::import(new GuruImport, public_path('/DataGuru/' . $namfile));
        } else {
            // File tidak diunggah atau tidak valid
            $notification = [
                'message' => 'Guru Upload Successfully',
                'alert-type' => 'success'
            ];
        }

        return redirect()->route('guru.all')->with($notification);
    }


    public function GuruExport(Request $request)
    {


        $guru = Guru::get();

        return Excel::download(new GuruExport($guru), 'Data Guru.xlsx');
    }
}
