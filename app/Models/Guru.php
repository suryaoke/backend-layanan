<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guru extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function pengampu()
    {
        return $this->hasMany(Pengampu::class, 'id_guru');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function kelass()
    {
        return $this->belongsTo(Walas::class, 'id_kelas', 'id');
    }

    public function walass()
    {
        return $this->belongsTo(Walas::class, 'id', 'id_guru');
    }
}
