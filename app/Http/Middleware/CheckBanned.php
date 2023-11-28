<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the user is attempting to login
        if ($request->isMethod('post') && $request->has('username') && $request->has('password')) {
            $credentials = $request->only('username', 'password');

            // Check if the username is provided and not empty
            if (empty($credentials['username'])) {
                $notification = array(
                    'message' => 'Username or Password harus diisi..!!',
                    'alert-type' => 'error'
                );

                return redirect()->route('login')->with($notification);
            }

            // Attempt to authenticate the user
            if (Auth::attempt($credentials)) {
                // Authentication successful, create a success response
                $notification = array(
                    'message' => 'User Login Successfully',
                    'alert-type' => 'success'
                );

                return redirect()->route('dashboard')->with($notification);
            } else {
                // Authentication failed, create an error response
                $notification = array(
                    'message' => 'Username or Password Salah..!!',
                    'alert-type' => 'error'
                );

                return redirect()->route('login')->with($notification);
            }
        }

        // Continue with the existing checks for banned and role conditions
        if (auth()->check() && (auth()->user()->status == '0')) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $notification = array(
                'message' => 'Akun User Tidak Aktif',
                'alert-type' => 'warning'
            );

            return redirect()->route('login')->with($notification);
        }

        if (auth()->check() && (auth()->user()->role == '5')) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $notification = array(
                'message' => 'Akun Pengguna Hanya Dapat Diakses di Aplikasi Mobile',
                'alert-type' => 'warning'
            );

            return redirect()->route('login')->with($notification);
        }

        return $next($request);
    }
}
