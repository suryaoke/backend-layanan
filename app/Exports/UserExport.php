<?php

namespace App\Exports;


use App\Models\Jadwalmapel;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;



class UserExport implements FromView
{
    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function view(): View
    {
        return view('backend.master.user.excel', [
            'user' => $this->user
        ]);
    }
}
