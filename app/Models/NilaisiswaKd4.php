<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaisiswaKd4 extends Model
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

    public function nilaikd4()
    {
        return $this->belongsTo(NilaiKd4::class, 'id_nilaikd4', 'id');
    }

    public function seksis()
    {
        return $this->belongsTo(Seksi::class, 'id_seksi', 'id');
    }
    public function mapels()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel');
    }
}
