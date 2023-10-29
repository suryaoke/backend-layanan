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

    public function nilaikd3()
    {
        return $this->belongsTo(NilaiKd3::class, 'id_nilaikd3', 'id');
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
