<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kd3 extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function seksis()
    {
        return $this->belongsTo(Seksi::class, 'id_seksi', 'id');
    }

    public function ki3s()
    {
        return $this->belongsTo(Ki3::class, 'id_ki3', 'id');
    }
}
