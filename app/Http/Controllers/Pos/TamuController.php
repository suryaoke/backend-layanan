<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Tamu;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class TamuController extends Controller
{
    public function TamuAll()
    {


        $tamu = Tamu::latest()->get();

        return view('backend.data.tamu.tamu_all', compact('tamu'));
    } // end method

    public function TamuAdd()
    {

        return view('backend.data.tamu.tamu_add');
    } // end method
    public function TamuStore(Request $request)
    {

        Tamu::insert([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'individu' => $request->individu,
            'tujuan' => $request->tujuan,
            'no_hp' => $request->no_hp,
            'status' => $request->status,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Tamu Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('tamu.all')->with($notification);
    }

    public function TamuSelesai($id)
    {

        // $users = User::findOrFail($id);
        // $img = $users->profile_image;
        // unlink($img);

        $tamu = Tamu::findOrFail($id);
        $tamu->status = '1';
        $tamu->save();

        $notification = array(
            'message' => 'User Active Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method

    public function TamuDelete($id)
    {

        Tamu::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Tamu Deleted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method
    public function TamuStoreFrontend(Request $request)
    {

        Tamu::insert([
            'nama' => $request->nama,
            'jabatan' => $request->jabatan,
            'individu' => $request->individu,
            'tujuan' => $request->tujuan,
            'no_hp' => $request->no_hp,
            'status' => $request->status,
            'created_by' => '0',
            'created_at' => Carbon::now(),

        ]);

        $notification = array(
            'message' => 'Tamu Insert SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('frontend')->with($notification);
    } // End Method

    public function TamuReport()
    {

        $tamu = Tamu::where('status', '1')->latest()->get();

        return view('backend.data.tamu.tamu_report', compact('tamu'));
    } // End Method
    // public function TamuReportPdf()
    // {

    //     $tamu = Tamu::where('status', '1')->latest()->get();

    //     return view('backend.data.pdf.tamu_report_pdf', compact('tamu'));
    // } // End Method

     public function TamuReportPdf()
    {

        $tamu = Tamu::where('status', '1')->latest()->get();



        $pdf = PDF::loadview('backend.data.pdf.tamu_report_pdf', ['tamu' => $tamu]);
        return $pdf->download('contoh.pdf');
    } // End Method
}
