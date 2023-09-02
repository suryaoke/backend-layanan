<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function siswass()
    {
        return $this->belongsTo(Siswa::class, 'siswa', 'id');
    }
    public function siswa1()
    {
        return $this->belongsTo(Siswa::class, 'siswa');
    }
}
