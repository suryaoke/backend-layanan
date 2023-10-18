<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rombelsiswa extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function siswas()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id');
    }

    public function kelass()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id');
    }
    public function rombels()
    {
        return $this->belongsTo(Rombel::class, 'id_rombel', 'id');
    }
}
