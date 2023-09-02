<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\InformasiSurat;
use App\Models\IsiSurat;
use App\Models\LampiranSurat;
use App\Models\Naskah;
use App\Models\SuratMasuk;
use App\Models\SuratMasukTerkirim;
use App\Models\TandaTanganSurat;
use App\Models\TembusanSurat;
use App\Models\TujuanSurat;
use App\Models\User;
use App\Models\VerifikasiSurat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuratKeluarController extends Controller
{
    public function SuratKeluarInformasi()
    {
        $naskah = Naskah::all();
        return view('backend.surat.suratkeluar.informasi_surat', compact('naskah'));
    } // end method

    public function SuratKeluarInformasiStore(Request $request)
    {
        $surat = new InformasiSurat();
        $surat->tujuan_surat = $request->tujuan_surat;
        $surat->perihal = $request->perihal;
        $surat->id_naskah = $request->id_naskah;
        $surat->no_agenda = $request->no_agenda;
        $surat->tgl_surat = $request->tgl_surat;
        $surat->no_surat = $request->no_surat;
        $surat->status = "0";
        $surat->created_by = Auth::user()->id;
        $surat->created_at = Carbon::now();
        $surat->save();

        $notification = array(
            'message' => 'Surat Keluar Inforamsi Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('surat.keluar.tujuan', $surat->id)->with($notification);
    }

    public function SuratKeluarTujuan($id)
    {

        $user = User::all();
        $surat = InformasiSurat::latest()->where('id', $id)->get();

        return view('backend.surat.suratkeluar.tujuan_surat', compact('user', 'surat'));
    } // end method

    public function SuratKeluarTujuanStore(Request $request)
    {
        $surat = new TujuanSurat();
        $surat->id_informasi = $request->id_informasi;
        $surat->id_user = $request->id_user;
        $surat->created_by = Auth::user()->id;
        $surat->created_at = Carbon::now();
        $surat->save();
        $isi = new IsiSurat();
        $isi->id_informasi = $request->id_informasi;
        $isi->isi = $request->isi;
        $isi->created_by = Auth::user()->id;
        $isi->created_at = Carbon::now();
        $isi->save();
        $surats =  InformasiSurat::find($surat->id_informasi);
        if (strpos($isi->isi, '{tanggal_surat}')) {
            $data = str_replace('{tanggal_surat}', $surats->tgl_surat, $isi->isi);
            $isi->isi = $data;
            $isi->save();
        }
        if (strpos($isi->isi, '{no_surat}')) {
            $data = str_replace('{no_surat}', $surats->no_surat, $isi->isi);
            $isi->isi = $data;
            $isi->save();
        }

        $notification = array(
            'message' => 'Surat Keluar Tujuan Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('surat.keluar.isi', $surat->id_informasi)->with($notification);
    }

    public function SuratKeluarIsi($id)
    {

        $user1 = User::all();
        $surat = InformasiSurat::latest()->where('id', $id)->get();
        $surat1 = InformasiSurat::where('id', $id)->first();
        $isi = IsiSurat::latest()->where('id_informasi', $id)->get();
        $tujuan = TujuanSurat::latest()->where('id_informasi', $id)->get();
        $tujuan2 = TujuanSurat::latest()->where('id_informasi', $id)->get();
        $tujuan3 = count($tujuan2);
        $tujuan4 = TujuanSurat::where('id_informasi', $id)->first();
        $tembusan = TembusanSurat::latest()->where('id_informasi', $id)->get();
        $lampiran = LampiranSurat::latest()->where('id_informasi', $id)->get();
        $verifikasi = VerifikasiSurat::latest()->where('id_informasi', $id)->get();
        $tandatangan = TandatanganSurat::latest()->where('id_informasi', $id)->get();

        $suratmasuk = SuratMasuk::where('file', $id)->get();

        foreach ($suratmasuk as $row) {
            if ($row->tujuan == Auth::user()->id) {
                $row->status = '1';
                $row->save();
            }
        }


        return view('backend.surat.suratkeluar.isi_surat', compact('tujuan4', 'surat1', 'user1', 'surat', 'tujuan2', 'isi', 'tujuan', 'tujuan3', 'tembusan', 'lampiran', 'verifikasi', 'tandatangan'));
    } // end method


    public function SuratKeluarTujuanUpdate(Request $request)
    {
        $surat = new TujuanSurat();
        $surat->id_informasi = $request->id_informasi;
        $surat->id_user = $request->id_user;
        $surat->created_by = Auth::user()->id;
        $surat->created_at = Carbon::now();
        $surat->save();


        $notification = array(
            'message' => 'Surat Keluar Tujuan Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
    public function SuratKeluarTujuanDelete($id)
    {

        TujuanSurat::findOrFail($id)->delete();
        $notification = array(
            'message' => ' Surat Keluar Tujuan Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
    public function SuratKeluarTembusanStore(Request $request)
    {
        $surat = new TembusanSurat();
        $surat->id_informasi = $request->id_informasi;
        $surat->tujuan = $request->tujuan;
        $surat->created_by = Auth::user()->id;
        $surat->created_at = Carbon::now();
        $surat->save();

        $data = $request->id_informasi;
        $isi =  IsiSurat::where('id_informasi', $data)->first();

        if (strpos($isi->isi, '{tembusan}')) {
            $data = str_replace('{tembusan}', $surat->tujuan, $isi->isi);
            $isi->isi = $data;
            $isi->save();
        }


        $notification = array(
            'message' => 'Surat Keluar Tembusan Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function SuratKeluarTembusanDelete($id)
    {
        $tembusan =  TembusanSurat::find($id);
        $isi =  IsiSurat::where('id_informasi', $tembusan->id_informasi)->first();

        if (strpos($isi->isi, $tembusan->tujuan)) {
            $data = str_replace($tembusan->tujuan, '{tembusan}', $isi->isi);
            $isi->isi = $data;
            $isi->save();
        }
        TembusanSurat::findOrFail($id)->delete();
        $notification = array(
            'message' => ' Surat Keluar Tembusan Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function SuratKeluarLampiranStore(Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:pdf|max:2048',
        ]);

        $file = $request->file('file');
        $nama = 'FT' . date('Ymdhis') . '.' . $request->file('file')->getClientOriginalExtension();
        $file->move('uploads/lampiran', $nama);

        $surat = new LampiranSurat();
        $surat->id_informasi = $request->id_informasi;
        $surat->file = $nama;
        $surat->created_by = Auth::user()->id;
        $surat->created_at = Carbon::now();
        $surat->save();
        $notification = array(
            'message' => 'Surat Keluar Tembusan Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function SuratKeluarLampiranDelete($id)
    {


        LampiranSurat::findOrFail($id)->delete();
        $notification = array(
            'message' => ' Surat Keluar Tembusan Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function SuratKeluarTerkirimStore(Request $request)
    {
        $id = $request->id;
        $id_info = $request->id_informasi;
        IsiSurat::findOrFail($id)->update([
            'isi' => $request->isi,
            'updated_by' => Auth::user()->id,
            'updated_at' => Carbon::now(),
        ]);

        $surat =  InformasiSurat::findOrFail($id_info);
        $surat->status = "1";
        $surat->save();

        $user = User::latest()->where('role', '3')->first();
        $verifikasi = new VerifikasiSurat();
        $verifikasi->id_informasi = $id_info;
        $verifikasi->id_user = $user->id;
        $verifikasi->status = '0';
        $verifikasi->ket = "-";
        $verifikasi->created_by = Auth::user()->id;
        $verifikasi->created_at = Carbon::now();
        $verifikasi->save();

        $notification = array(
            'message' => 'Surat Keluar Terkirim Ke Verifikator SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('surat.keluar.all')->with($notification);
    } // end method


    public function SuratKeluarAll()
    {

        $suratkeluar = InformasiSurat::latest()->get();

        return view('backend.surat.suratkeluar.surat_keluar_all', compact('suratkeluar'));
    } // end method

    public function SuratKeluarVerifikasi()
    {

        $verifikasi = VerifikasiSurat::latest()->get();

        return view('backend.surat.suratkeluar.verifikasi_surat_keluar', compact('verifikasi'));
    } // end method

    public function SuratKeluarVerifikasiStore(Request $request)
    {
        $id = $request->id;
        $id_info = $request->id_informasi;


        $surat =  InformasiSurat::findOrFail($id_info);
        $surat->status = "2";
        $surat->save();

        $verifikasi =  VerifikasiSurat::latest()->where('id_informasi', $id_info)->first();
        $verifikasi->status = "2";
        $verifikasi->ket = "Surat OK";
        $verifikasi->save();

        $user = User::latest()->where('role', '1')->first();
        $tandatangan = new TandaTanganSurat();
        $tandatangan->id_informasi = $id_info;
        $tandatangan->id_user = $user->id;
        $tandatangan->status = '0';
        $tandatangan->ket = "-";
        $tandatangan->created_by = Auth::user()->id;
        $tandatangan->created_at = Carbon::now();
        $tandatangan->save();

        $notification = array(
            'message' => 'Surat Keluar  Verifikator SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('surat.keluar.verifikasi')->with($notification);
    } // end method

    public function SuratKeluarVerifikasiTolak(Request $request)
    {

        $id_info = $request->id_informasi;


        $surat =  InformasiSurat::findOrFail($id_info);
        $surat->status = "3";
        $surat->save();

        $verifikasi =  VerifikasiSurat::latest()->where('id_informasi', $id_info)->first();
        $verifikasi->status = "3";
        $verifikasi->ket = $request->ket;
        $verifikasi->save();


        $notification = array(
            'message' => 'Surat Keluar Tolak  SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('surat.keluar.verifikasi')->with($notification);
    } // end method

    public function SuratKeluarTandatangan()
    {

        $tandatangan = TandaTanganSurat::latest()->get();

        return view('backend.surat.suratkeluar.tandatangan_surat', compact('tandatangan'));
    } // end method

    public function SuratKeluarTandatanganCetak(Request $request)
    {

        $id_info = $request->id_informasi;
        $surat =  InformasiSurat::findOrFail($id_info);
        $surat->status = "4";
        $surat->save();
        $verifikasi =  TandaTanganSurat::latest()->where('id_informasi', $id_info)->first();
        $verifikasi->status = "1";
        $verifikasi->ket = "Surat OK";
        $verifikasi->save();

        $isi =  IsiSurat::where('id_informasi', $id_info)->first();
        if (strpos($isi->isi, '{ttd}')) {
            $data = str_replace('{ttd}', '', $isi->isi);
            $isi->isi = $data;
            $isi->save();
        }

        $tujuan = TujuanSurat::where('id_informasi', $id_info)->get();

        if ($surat->tujuan_Surat == "2") {
            foreach ($tujuan as $row) {
                $info = InformasiSurat::where('id', $row->id_informasi)->first();

                $surat = new SuratMasuk();
                $surat->asal_surat = $info->tujuan_surat;
                $surat->no_surat = $info->no_surat;
                $surat->tgl_surat = $info->tgl_surat;
                $surat->pengirim = $info->created_by;
                $surat->perihal = $info->perihal;
                $surat->tujuan = $row->id_user;
                $surat->file = $info->id;
                $surat->status = "0";
                $surat->created_by = Auth::user()->id;
                $surat->created_at = Carbon::now();
                $surat->save();

                SuratMasukTerkirim::insert([
                    'id_sm' => $surat->id,
                    'id_pengirim' =>   $surat->pengirim,
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                ]);
            }
        }

        $notification = array(
            'message' => 'Surat Keluar Tandatangan Dan Dikirim SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('surat.keluar.tandatangan')->with($notification);
    } // end method

    public function SuratKeluarTandatanganGambar(Request $request)
    {

        $id_info = $request->id_informasi;


        $surat =  InformasiSurat::findOrFail($id_info);
        $surat->status = "4";
        $surat->save();

        $verifikasi =  TandaTanganSurat::latest()->where('id_informasi', $id_info)->first();
        $verifikasi->status = "1";
        $verifikasi->ket = "Surat OK";
        $verifikasi->save();


        $isi =  IsiSurat::where('id_informasi', $id_info)->first();
        $user = User::where('role', '1')->first();
        if (strpos($isi->isi, '{ttd}')) {
            $gambar = " <img src='/uploads/ttd/$user->ttd' style=' width: 120px; height: 100px;'/> ";
            $data = str_replace('{ttd}', $gambar, $isi->isi);
            $isi->isi = $data;
            $isi->save();
        }
        $tujuan = TujuanSurat::where('id_informasi', $id_info)->get();
        if ($surat->tujuan_Surat == "2") {
            foreach ($tujuan as $row) {
                $info = InformasiSurat::where('id', $row->id_informasi)->first();

                $surat = new SuratMasuk();
                $surat->asal_surat = $info->tujuan_surat;
                $surat->no_surat = $info->no_surat;
                $surat->tgl_surat = $info->tgl_surat;
                $surat->pengirim = $info->created_by;
                $surat->perihal = $info->perihal;
                $surat->tujuan = $row->id_user;
                $surat->file = $info->id;
                $surat->status = "0";
                $surat->created_by = Auth::user()->id;
                $surat->created_at = Carbon::now();
                $surat->save();

                SuratMasukTerkirim::insert([
                    'id_sm' => $surat->id,
                    'id_pengirim' =>   $surat->pengirim,
                    'created_by' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                ]);
            }
        }

        $notification = array(
            'message' => 'Surat Keluar Tandatangan SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('surat.keluar.tandatangan')->with($notification);
    } // end method

    public function SuratKeluarReport()
    {

        $suratkeluar = InformasiSurat::where('status', '4')->latest()->get();

        return view('backend.surat.suratkeluar.surat_keluar_report', compact('suratkeluar'));
    } // end method

    public function SuratKeluarDelete($id)
    {

        InformasiSurat::findOrFail($id)->delete();
        TujuanSurat::where('id_informasi', $id)->delete();
        TembusanSurat::where('id_informasi', $id)->delete();
        IsiSurat::where('id_informasi', $id)->delete();
        LampiranSurat::where('id_informasi', $id)->delete();
        $notification = array(
            'message' => ' Surat Keluar Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }


    // public function SuratKeluarTandatanganLangsung(Request $request)
    // {

    //     $id_info = $request->id_informasi;


    //     $surat =  InformasiSurat::findOrFail($id_info);
    //     $surat->status = "4";
    //     $surat->save();

    //     $verifikasi =  TandaTanganSurat::latest()->where('id_informasi', $id_info)->first();
    //     $verifikasi->status = "1";
    //     $verifikasi->ket = "Surat OK";
    //     $verifikasi->save();



    //     $isi =  IsiSurat::where('id_informasi', $id_info)->first();

    //   //  $img = $request->file('img');
    //     if (strpos($isi->isi, '{ttd}')) {
    //      //   $gambar =  '<img src=data:' . $img . ' style="width: 200px; height: 60px;">';
    //         $data = str_replace('{ttd}', '' ,$isi->isi);
    //         $isi->isi = $data;
    //         $isi->save();
    //     }


    //     $notification = array(
    //         'message' => 'Surat Keluar Tandatangan SuccessFully',
    //         'alert-type' => 'success'
    //     );
    //     return redirect()->route('surat.keluar.tandatangan')->with($notification);
    // } // end method


}
