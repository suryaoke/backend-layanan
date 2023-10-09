<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwalmapel extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function haris()
    {
        return $this->belongsTo(Hari::class, 'id_hari');
    }

    public function pengampus()
    {
        return $this->belongsTo(Pengampu::class, 'id_pengampu');
    }

    public function waktus()
    {
        return $this->belongsTo(Waktu::class, 'id_waktu');
    }

    public function ruangans()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan');
    }

    public function gurus()
    {
        return $this->belongsTo(Guru::class, 'id_guru');
    }
    public function mapels()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel');
    }

    public function kelass()
    {
        return $this->belongsTo(Kelas::class, 'kelas');
    }
}
