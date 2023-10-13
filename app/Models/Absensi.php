<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function siswass()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id');
    }
    public function siswa1()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa');
    }

    public function jadwalss()
    {
        return $this->belongsTo(Jadwalmapel::class, 'id_jadwal');
    }

    public function pengampus()
    {
        return $this->belongsTo(Pengampu::class, 'id_pengampu');
    }

    public function kelass()
    {
        return $this->belongsTo(Kelas::class, 'kelas');
    }

    public function mapels()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel');
    }
    public function jurusans()
    {
        return $this->belongsTo(Mapel::class, 'id_jurusan');
    }
}
    