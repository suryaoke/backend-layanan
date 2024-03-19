<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rapor extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function rombels()
    {
        return $this->belongsTo(Rombel::class, 'id_rombel', 'id');
    }

    public function rombelsiswas()
    {
        return $this->belongsTo(Rombelsiswa::class, 'id_rombelsiswa', 'id');
    }

    public function tahun()
    {
        return $this->belongsTo(Tahunajar::class, 'id_tahunajar', 'id');
    }
}
