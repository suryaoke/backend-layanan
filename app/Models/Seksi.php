<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seksi extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function jurusans()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan', 'id');
    }

    public function kelass()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id');
    }

    public function walass()
    {
        return $this->belongsTo(Walas::class, 'id_walas', 'id');
    }

    public function siswas()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id');
    }

    public function mapels()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel', 'id');
    }

    public function pengampus()
    {
        return $this->belongsTo(Pengampu::class, 'id_pengampu');
    }

    public function rombels()
    {
        return $this->belongsTo(Rombel::class, 'id_rombel');
    }
    public function semesters()
    {
        return $this->belongsTo(Tahunajar::class, 'semester');
    }

    public function jadwalmapels()
    {
        return $this->belongsTo(Jadwalmapel::class, 'id_jadwal', 'id');
    }
}
