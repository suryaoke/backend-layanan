<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ki4 extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function seksis()
    {
        return $this->belongsTo(Seksi::class, 'id_seksi', 'id');
    }
}
