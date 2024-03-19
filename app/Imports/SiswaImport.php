<?php

namespace App\Imports;

use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SiswaImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (!empty($row['username'])) {

            $user = new User([
                'name' => $row['nama'],
                'username' => $row['username'],
                'email' => substr(str_shuffle('0123456789'), 0, 4)  . '@example.com', // Menyertakan 'email' berdasarkan 'username'
                'profile_image' => 0, // Gunakan gambar profil default
                'role' => 6, // Atur peran pengguna
                'status' => 1, // Set status aktif
                'password' => Hash::make('12345678'), // Hash kata sandi
            ]);

            // Simpan pengguna
            $user->save();

            // Buat guru baru dengan mengaitkannya dengan pengguna yang baru dibuat
            $siswa = new Siswa([
                'nama' => $row['nama'],
                'nisn' =>  $row['nisn'],
                'jk' =>  $row['jenis_kelamin'],
                'tempat' =>  $row['tempat'],
                'tanggal' =>  $row['tanggal'],
                'id_user' => $user->id, // Mengaitkan guru dengan id pengguna baru
            ]);

            // Simpan data guru
            $siswa->save();
        } else {
            $siswa = new Siswa([
                'nama' => $row['nama'],
                'nisn' =>  $row['nisn'],
                'jk' =>  $row['jenis_kelamin'],
                'tempat' =>  $row['tempat'],
                'tanggal' =>  $row['tanggal'],
                'id_user' => 0, // Mengaitkan guru dengan id pengguna baru
            ]);

            // Simpan data guru
            $siswa->save();
        }
    }
}
