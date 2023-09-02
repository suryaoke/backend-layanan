<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\SuratMasuk;
use App\Models\SuratMasukDisposisi;
use App\Models\SuratMasukTerkirim;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Image;

use function Pest\Laravel\post;

class SuratMasukController extends Controller
{
    public function SuratMasukAll()
    {

        //$suppliers = Supplier::all();
        $surat = SuratMasuk::latest()->where('tujuan', Auth::user()->id)->get();
        $surat2 = SuratMasukDisposisi::latest()->where('id_penerima', Auth::user()->id)->get();
        return view('backend.surat.suratmasuk.suratmasuk_all', compact('surat', 'surat2'));
    } // end method


    public function SuratMasukAdd()
    {
        $user = User::latest()->get();
        return view('backend.surat.suratmasuk.suratmasuk_add', compact('user'));
    } // end method

    public function SuratMasukStore(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        $file = $request->file('file');
        $nama = 'FT' . date('Ymdhis') . '.' . $request->file('file')->getClientOriginalExtension();
        $file->move('uploads/suratmasuk', $nama);

        $surat = new SuratMasuk();
        $surat->asal_surat = $request->asal_surat;
        $surat->no_surat = $request->no_surat;
        $surat->tgl_surat = $request->tgl_surat;
        $surat->pengirim = $request->pengirim;
        $surat->perihal = $request->perihal;
        $surat->tujuan = $request->tujuan;
        $surat->file = $nama;
        $surat->status = "0";
        $surat->created_by = Auth::user()->id;
        $surat->created_at = Carbon::now();
        $surat->save();


        SuratMasukTerkirim::insert([
            'id_sm' => $surat->id,
            'id_pengirim' =>  Auth::user()->id,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Surat Masuk Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('surat.masuk.terkirim.all')->with($notification);
    }

    public function SuratMasukDelete($id)
    {
        SuratMasuk::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Surat Masuk Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function SuratMasukView($id)
    {
        $user = User::latest()->get();
        $suratmasuk = SuratMasuk::findOrFail($id);
        $suratmasuk->status = '1';
        $suratmasuk->save();
        $suratmasukdisposisi = SuratMasukDisposisi::where('id_sm', $suratmasuk->id)->get();
        return view('backend.surat.suratmasuk.suratmasuk_view', compact('suratmasuk', 'user', 'suratmasukdisposisi'));
    } // End Method


    public function SuratMasukTerkirimAll()
    {

        $suratmasukterkirim = SuratMasukTerkirim::latest()->get();
        $user = User::latest()->get();
        return view('backend.surat.suratmasuk.suratmasukterkirim_all', compact(['suratmasukterkirim', 'user']));
    } // end method

    public function SuratMasukTerkirimView($id)
    {
        $user = User::latest()->get();
        $suratmasukterkirim = SuratMasukTerkirim::findOrFail($id);
        $surat = SuratMasuk::findOrFail($suratmasukterkirim->id_sm);

        $suratmasukdisposisi = SuratMasukDisposisi::where('id_sm', $suratmasukterkirim->id_sm)->get();

        return view('backend.surat.suratmasuk.suratmasukterkirim_view', compact('suratmasukterkirim', 'user', 'suratmasukdisposisi', 'surat'));
    } // End Method

    public function SuratMasukDisposisiStore(Request $request)
    {

        SuratMasukDisposisi::insert([
            'id_sm' => $request->id_sm,
            'id_pengirim' =>  Auth::user()->id,
            'isi' => $request->isi,
            'id_penerima' => $request->id_penerima,
            'status' => '0',
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Disposisi Surat Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // end method

    public function SuratMasukDisposisiDelete($id)
    {
        SuratMasukDisposisi::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Disposisi Surat Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // end method

    public function SuratMasukDisposisiApprove($id)
    {
        $surat =  SuratMasukDisposisi::findOrFail($id);
        $surat->status = "1";
        $surat->save();
        $notification = array(
            'message' => 'Disposisi Surat Approve SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // end method
    public function SuratMasukTerkirimDelete($id)
    {
        SuratMasuk::findOrFail($id)->delete();
        SuratMasukTerkirim::latest()->where('id_sm', $id)->delete();
        $notification = array(
            'message' => ' Surat Masuk Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    } // end method

    public function SuratMasukFrontendStore(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        $file = $request->file('file');
        $nama = 'FT' . date('Ymdhis') . '.' . $request->file('file')->getClientOriginalExtension();
        $file->move('uploads/suratmasuk', $nama);

        $surat = new SuratMasuk();

        $surat->asal_surat = $request->asal_surat;
        $surat->no_surat = $request->no_surat;
        $surat->tgl_surat = $request->tgl_surat;
        $surat->pengirim = $request->pengirim;
        $surat->perihal = $request->perihal;
        $surat->file = $nama;
        $surat->tujuan = "0";
        $surat->status = $request->status;
        $surat->created_by = "0";
        $surat->created_at = Carbon::now();
        $surat->save();

        SuratMasukTerkirim::insert([
            'id_sm' => $surat->id,
            'id_pengirim' =>  "0",
            'created_by' => "0",
            'created_at' => Carbon::now(),
        ]);
        $notification = array(
            'message' => 'Surat Masuk Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('frontend')->with($notification);
    }

    public function SuratMasukTujuanStore(Request $request)
    {

        $surat_id = $request->id;
        $surat =  SuratMasuk::findOrFail($surat_id);
        $surat->status = "0";
        $surat->tujuan = $request->tujuan;
        $surat->save();

        $notification = array(
            'message' => 'Surat Masuk Tujuan Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('surat.masuk.terkirim.all')->with($notification);
    }

    public function SuratMasukReport()
    {
        $suratmasuk = SuratMasuk::where('status', '1')->latest()->get();
        $user = User::latest()->get();
        return view('backend.surat.suratmasuk.suratmasuk_report', compact(['suratmasuk', 'user']));
    } // end method



}
