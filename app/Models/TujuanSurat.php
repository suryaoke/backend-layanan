<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TujuanSurat extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function tujuan()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
