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

        if (auth()->check() && (auth()->user()->status == '0')) {
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();
            $notification = array(
                'message' => 'Akun User Tidak Aktif ',
                'alert-type' => 'warning'
            );

            return redirect()->route('login')->with($notification);
        }

        return $next($request);
    }
}
