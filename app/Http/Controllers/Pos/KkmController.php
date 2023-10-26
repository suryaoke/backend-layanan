<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Kkm;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KkmController extends Controller
{
    public function KkmAll()
    {

        $kkm = Kkm::orderBy('id_kelas', 'asc')
            ->get();

        return view('backend.data.kkm.kkm_all', compact('kkm'));
    } // end method

    public function KkmAdd()
    {


        return view('backend.data.kkm.kkm_add');
    } // end method

    public function KkmStore(Request $request)
    {
        // Pastikan id_kelas tidak sama saat diinputkan
        $existingKkm = Kkm::where('id_kelas', $request->id_kelas)->first();
        if ($existingKkm) {
            // Jika id_kelas sudah ada, tampilkan pesan error atau lakukan tindakan yang sesuai.
            $notification = array(
                'message' => 'Kelas already has KKM data',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        Kkm::insert([
            'kkm' => $request->kkm,
            'id_kelas' => $request->id_kelas,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Kkm Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('kkm.all')->with($notification);
    }


    public function KkmEdit($id)
    {
        $kkm = Kkm::findOrFail($id);


        return view('backend.data.kkm.kkm_edit', compact('kkm'));
    } // end method

    public function KkmUpdate(Request $request)
    {
        $kkm_id = $request->id;
        // Pastikan id_kelas tidak sama saat diinputkan
        $existingKkm = Kkm::where('id_kelas', $request->id_kelas)
            ->where('id', '!=', $kkm_id)
            ->first();
        if ($existingKkm) {
            // Jika id_kelas sudah ada, tampilkan pesan error atau lakukan tindakan yang sesuai.
            $notification = array(
                'message' => 'Kelas already has KKM data',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }

        Kkm::findOrFail($kkm_id)->update([
            'kkm' => $request->kkm,
            'id_kelas' => $request->id_kelas,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Kkm Updated SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('kkm.all')->with($notification);
    }


    public function KkmDelete($id)
    {
        Kkm::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Kkm Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
