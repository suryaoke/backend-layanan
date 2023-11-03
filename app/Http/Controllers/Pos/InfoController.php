<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Info;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Image;

class InfoController extends Controller
{
    public function InfoAll()
    {

        $info = Info::orderBy('created_at', 'asc')
            ->get();

        return view('backend.data.info.info_all', compact('info'));
    } // end method

    public function InfoAdd()
    {

        return view('backend.data.info.info_add');
    } // end method
    public function InfoStore(Request $request)
    {
        $image = $request->file('image');
        $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension(); // 343434.png
        Image::make($image)->resize(200, 200)->save('uploads/admin_images/' . $name_gen);
        $save_url = '' . $name_gen;

        Info::insert([
            'nama' => $request->nama,
            'ket' => $request->ket,
            'link' => $request->link,
            'image' => $save_url,
            'created_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);

        $notification = array(
            'message' => 'Info Inserted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->route('info.all')->with($notification);
    } // end method

    public function InfoEdit($id)
    {
        $info = Info::findOrFail($id);

        return view('backend.data.info.info_edit', compact('info',));
    } // end method

    public function InfoUpdate(Request $request)
    {

        if ($request->file('image')) {
            $image = $request->file('image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension(); // 343434.png
            Image::make($image)->resize(200, 200)->save('uploads/admin_images/' . $name_gen);
            $save_url = '' . $name_gen;

            $info_id = $request->id;
            Info::findOrFail($info_id)->update([
                'nama' => $request->nama,
                'ket' => $request->ket,
                'link' => $request->link,
                'image' => $save_url,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),

            ]);

            $notification = array(
                'message' => 'Info Updated  Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('info.all')->with($notification);
        } else {
            $info_id = $request->id;
            Info::findOrFail($info_id)->update([
                'nama' => $request->nama,
                'ket' => $request->ket,
                'link' => $request->link,
                'updated_by' => Auth::user()->id,
                'updated_at' => Carbon::now(),

            ]);

            $notification = array(
                'message' => 'info Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('info.all')->with($notification);
        } // end else
    } // end method


    public function InfoDelete($id)
    {
        Info::findOrFail($id)->delete();

        $notification = array(
            'message' => 'Info Deleted SuccessFully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }
}
