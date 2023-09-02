<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'ttd' => ['string', 'max:255'],
            'role' => ['string', 'max:255'],
            'profile_image' => ['string', 'max:255'],
            'jabatan' => ['string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'profile_image' => $request->profile_image,
            'role' => $request->role,
            'jabatan' => $request->jabatan,
            'email' => $request->email,
            'ttd' => '0',
            'password' => Hash::make($request->password),
        ]);

        $notification = array(
            'message' => 'Create User Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('login')->with($notification);
    }
}
