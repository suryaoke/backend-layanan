<?php

namespace App\Http\Controllers\Pos;

use App\Exports\UserExport;
use App\Http\Controllers\Controller;
use App\Helpers\ResponseFormatter;
use App\Imports\UserImport;
use App\Models\Guru;
use App\Models\OrangTua;
use App\Models\Siswa;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Image;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{


    public function UserAll()
    {
        $users = User::orderBy('role')->orderby('name')->get();

        return view('backend.master.user.user_all', compact('users',));
    } // End Method


    public function UserAdd()
    {

        return view('backend.master.user.user_add');
    }    // End Method

    public function create(): View
    {
        return view('auth.register');
    }


    public function UserStore(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'profile_image' => ['string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $existingUser = User::whereIn('role', [1, 2,])->first();

        if ($existingUser && !in_array($request->role, [3, 4, 5, 6])) {
            // If a user with role 1, 2, or 3 already exists, and the new user's role is not 4, 5, or 6, show an alert and redirect
            $notification = [
                'message' => 'Data Role Admin/Kepsek/Sudah Ada',
                'alert-type' => 'error'
            ];
            return redirect()->back()->withInput()->with($notification);
        }

        // If no user with role 1, 2, or 3 exists, create the user
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'profile_image' => $request->profile_image,
            'role' => $request->role,
            'email' => $request->email,
            'status' => $request->status,
            'password' => Hash::make($request->password),
        ]);

        $notification = [
            'message' => 'Create User Successfully',
            'alert-type' => 'success'
        ];
        return redirect()->route('user.all')->with($notification);
    }


    public function UserView($id)
    {

        $user = User::findOrFail($id);
        return view('backend.master.user.user_view', compact('user'));
    } // End Method


    public function UserEdit($id)
    {

        $editData = User::findOrFail($id);
        return view('backend.master.user.user_edit', compact('editData'));
    } // End Method



    public function UserUpdate(Request $request)
    {
        $user_id = $request->id;


        if ($request->file('profile_image')) {

            $image = $request->file('profile_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension(); // 343434.png
            Image::make($image)->resize(200, 200)->save('uploads/admin_images/' . $name_gen);
            $save_url = '' . $name_gen;



            User::findOrFail($user_id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'profile_image' => $save_url,
                'role' => $request->role,
                'updated_at' => Carbon::now(),

            ]);

            $notification = array(
                'message' => 'User Updated  Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('user.all')->with($notification);
        } else {

            User::findOrFail($user_id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
                'username' => $request->username,
                'updated_at' => Carbon::now(),

            ]);

            $notification = array(
                'message' => 'User Updated Successfully',
                'alert-type' => 'success'
            );

            return redirect()->route('user.all')->with($notification);
        } // end else

    } // End Method

    public function UserTidakAktif($id)
    {

        $user = User::findOrFail($id);
        $user->status = '0';
        $user->save();

        $notification = array(
            'message' => 'User Inactive Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method

    public function UserAktif($id)
    {

        $user = User::findOrFail($id);
        $user->status = '1';
        $user->save();

        $notification = array(
            'message' => 'User Active Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method



    public function  UserReset(Request $request)
    {

        $user_id = $request->id;
        User::findOrFail($user_id)->update([
            'updated_at' => Carbon::now(),
            'password' => bcrypt($request->password),

        ]);

        $notification = array(
            'message' => 'Reset Password Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    } // End Method




    public function login(Request $request)
    {
        try {
            // Validate request
            $request->validate([
                'username' => 'required',
                'password' => 'required',
            ]);

            // Find user by username
            $user = User::where('username', $request->username)->first();
            $user->last =  Carbon::now();
            $user->save();

            if (!$user) {
                return ResponseFormatter::error('User not found', 404);
            }

            if ($user->role != 5) {

                return ResponseFormatter::error('Unauthorized. Hanya bisa akses di web.', 401);
            }


            if (!Hash::check($request->password, $user->password)) {
                throw new Exception('Invalid password');
            }

            // Generate token
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            // Add token and token_type to the user object
            $user->token = $tokenResult;
            $user->token_type = 'Bearer';

            // Remove the token and token_type from the root of the response
            $response = [
                'user' => $user,
            ];

            return ResponseFormatter::success($response, 'Login success');
        } catch (Exception $error) {
            return ResponseFormatter::error('Authentication Failed');
        }
    }


    public function Logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();
        return ResponseFormatter::success($token, 'Logout success');
    }


    public function fetch(Request $request)
    {
        $user = $request->user();
        return ResponseFormatter::success($user, 'Logout success');
    }


    public function forgotPassword(Request $request): JsonResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => $status], 200);
        } else {
            return response()->json(['error' => $status], 400);
        }
    }

    public function updateUser(Request $request)
    {
        try {
            // Validate request

            $user = Auth::user();

            // Update user information
            $user->name = $request->name;
            $user->email = $request->email;
            $user->username = $request->username;

            // Check if a new password is provided
            if (!empty($request->password)) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            // Prepare success response
            $response = [
                'user' => $user,
            ];

            return ResponseFormatter::success($response, 'User updated successfully');
        } catch (Exception $error) {
            return ResponseFormatter::error('Failed to update user');
        }
    }

    public function userImport(Request $request)
    {
        // Pastikan file telah diunggah sebelum melanjutkan
        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $namfile = date('YmdHi') . $file->getClientOriginalName();
            $file->move('DataUser', $namfile);
            Excel::import(new UserImport, public_path('/DataUser/' . $namfile));
        } else {
            // File tidak diunggah atau tidak valid
            $notification = [
                'message' => 'User Upload Successfully',
                'alert-type' => 'success'
            ];
        }

        return redirect()->route('user.all')->with($notification);
    }

    public function UserDelete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        $datasiswa = Siswa::where('id_user', $id)->first();
        if ($datasiswa) {
            $datasiswa->id_user = 0;
            $datasiswa->save();
        }

        $dataguru = Guru::where('id_user', $id)->first();
        if ($dataguru) {
            $dataguru->id_user = 0;
            $dataguru->save();
        }

        $dataorangtua = OrangTua::where('id_user', $id)->first();
        if ($dataorangtua) {
            $dataorangtua->id_user = 0;
            $dataorangtua->save();
        }

        $notification = array(
            'message' => 'User Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function UserExport(Request $request)
    {


        $user = User::get();

        return Excel::download(new UserExport($user), 'Data Akun Pengguna.xlsx');
    }
}
