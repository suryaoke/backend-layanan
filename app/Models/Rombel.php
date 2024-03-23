<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rombel extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function gurus()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id');
    }

    public function jurusans()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan', 'id');
    }

    public function kelass()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id');
    }
    public function kelassa()
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

    public function tahuns()
    {
        return $this->belongsTo(Tahunajar::class, 'id_tahunjar', 'id');
    }

    public function seksis()
    {
        return $this->belongsTo(Seksi::class, 'id_rombel', 'id');
    }
    public function rombelsiswas()
    {
        return $this->hasMany(RombelSiswa::class, 'id_rombel', 'id');
    }
}
