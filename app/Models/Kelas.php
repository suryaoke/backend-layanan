<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function jurusans()
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan', 'id');
    }
    public function pengampus()
    {
        return $this->hasMany(Pengampu::class, 'kelas', 'id');
    }

    public function kkms()
    {
        return $this->hasMany(Kkm::class, 'id_kelas', 'tingkat');
    }
    public function rombelss()
    {
        return $this->hasMany(Rombel::class, 'id', 'id_kelas');
    }
}
