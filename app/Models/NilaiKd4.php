<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiKd4 extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function kd4()
    {
        return $this->belongsTo(Kd4::class, 'id_kd4', 'id');
    }
}
