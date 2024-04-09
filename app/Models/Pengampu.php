<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengampu extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function gurus()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id');
    }

    public function mapels()
    {
        return $this->belongsTo(Mapel::class, 'id_mapel', 'id');
    }

    public function kelass()
    {
        return $this->belongsTo(Kelas::class, 'kelas', 'id');
    }
    public function tahuns()
    {
        return $this->belongsTo(Tahunajar::class, 'id_tahunajar', 'id');
    }
}
