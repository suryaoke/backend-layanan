<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Walas;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalasController extends Controller
{
    public function WalasAll(request $request)
    {
        $searchNama = $request->input('searchnama');
        $searchKode = $request->input('searchkode');
        $searchKelas = $request->input('searchkelas');


        $query = Walas::query();
        if (!empty($searchNama)) {
            $query->whereHas('gurus', function ($lecturerQuery) use ($searchNama) {
                $lecturerQuery->where('nama', 'LIKE', '%' . $searchNama . '%');
            });
        }
        if (!empty($searchKode)) {
            $query->whereHas('gurus', function ($lecturerQuery) use ($searchKode) {
                $lecturerQuery->where('kode_gr', 'LIKE', '%' . $searchKode . '%');
            });
        }
        if (!empty($searchKelas)) {
            $query->whereHas('kelass', function ($lecturerQuery) use ($searchKelas) {
                $lecturerQuery->where('id', 'LIKE', '%' . $searchKelas . '%');
            });
        }

        $walas = $query->join('kelas', 'walas.id_kelas', '=', 'kelas.id')
            ->select('walas.*', 'kelas.tingkat')
            ->orderBy('kelas.tingkat', 'asc')
            ->get();

        $kelas = Kelas::whereIn('id', function ($query) {
            $query->select('id_kelas')
                ->from('walas');
        })->orderBy('tingkat')
            ->get();

        return view('backend.data.walas.walas_all', compact('walas', 'kelas'));
    } // end method

    public function WalasAdd()
    {


        $guru = Guru::orderBy('kode_gr', 'asc')
            ->whereNotIn('id', function ($query) {
                $query->select('id_guru')
                    ->from('walas');
            })
            ->get();
        $kelas = Kelas::orderBy('tingkat', 'asc')
            ->whereNotIn('id', function ($query) {
                $query->select('id_kelas')
                    ->from('walas');
            })
            ->get();

        return view('backend.data.walas.walas_add', compact('guru', 'kelas'));
    } // end method
    public function WalasStore(Request $request)
    {
        $request->validate([
            'id_guru' => ['required', 'string', 'max:255', 'unique:' . Walas::class],
            'id_kelas' => ['required', 'string', 'max:255', 'unique:' . Walas::class],
        ]);
        Walas::insert([
            'id_guru' => $request->id_guru,
            'id_kelas' => $request->id_kelas,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Walas Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('walas.all')->with($notification);
    } // end method

    public function WalasEdit($id)
    {
        $walas = Walas::findOrFail($id);

        $guru = Guru::orderBy('kode_gr', 'asc')
            ->whereNotIn('id', function ($query) {
                $query->select('id_guru')
                    ->from('walas');
            })
            ->get();
        $kelas = Kelas::orderBy('tingkat', 'asc')
            ->whereNotIn('id', function ($query) {
                $query->select('id_kelas')
                    ->from('walas');
            })
            ->get();
        return view('backend.data.walas.walas_edit', compact('walas', 'guru', 'kelas'));
    } // end method

    public function WalasUpdate(Request $request)
    {

        $walas_id = $request->id;
        Walas::findOrFail($walas_id)->update([
            'id_guru' => $request->id_guru,
            'id_kelas' => $request->id_kelas,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Walas Updated SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('walas.all')->with($notification);
    } // end method


    public function WalasDelete($id)
    {
        Walas::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Walas Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
