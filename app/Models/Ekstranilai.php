<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekstranilai extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function ekstras()
    {
        return $this->belongsTo(Ekstra::class, 'id_ekstra', 'id');
    }
    public function siswas()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id');
    }

    public function gurus()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id');
    }
    public function kelass()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id');
    }
    public function jurusans()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan', 'id');
    }

    public function rombelsiswa()
    {
        return $this->belongsTo(Rombelsiswa::class, 'id_rombelsiswa', 'id');
    }

    public function rombels()
    {
        return $this->belongsTo(Rombel::class, 'id_rombel', 'id');
    }
}
