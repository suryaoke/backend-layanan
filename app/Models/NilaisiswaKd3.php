<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaisiswaKd3 extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function rombelsiswa()
    {
        return $this->belongsTo(Rombelsiswa::class, 'id_rombelsiswa', 'id');
    }

    public function siswas()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id');
    }
}
