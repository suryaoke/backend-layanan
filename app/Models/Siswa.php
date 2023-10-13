<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Siswa extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function kelass()
    {
        return $this->belongsTo(Kelas::class, 'kelas', 'id');
    }

    public function absensi1()
    {
        return $this->hasMany(Absensi::class, 'siswa');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function pengampus()
    {
        return $this->belongsTo(Pengampu::class, 'id_pengampu');
    }
    public function jurusans()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan' ,'id');
    }
}
