<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiKd3 extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function kd3()
    {
        return $this->belongsTo(Kd3::class, 'id_kd3', 'id');
    }
}
