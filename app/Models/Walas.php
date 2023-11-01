<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Walas extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function kelass()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id');
    }

    public function gurus()
    {
        return $this->belongsTo(Guru::class, 'id_guru', 'id');
    }
  
}
