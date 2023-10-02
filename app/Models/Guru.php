<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function pengampu()
    {
        return $this->hasMany(Pengampu::class, 'id_guru');
    }
}
