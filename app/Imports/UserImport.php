<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            //
            'name' => $row['nama'],
            'username' => $row['username'],
            'email' => substr(str_shuffle('0123456789'), 0, 4)  . '@example.com', // Menyertakan 'email' berdasarkan 'username'
            'profile_image' => 0, // Gunakan gambar profil default
            'role' => $row['role'], // Atur peran pengguna
            'status' => 1, // Set status aktif
            'password' => Hash::make('12345678'),
        ]);
    }
}
