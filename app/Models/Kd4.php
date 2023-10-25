<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kd4 extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function ki4s()
    {
        return $this->belongsTo(Ki4::class, 'id_ki4', 'id');
    }
}
