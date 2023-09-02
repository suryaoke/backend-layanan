<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratMasukTerkirim extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function suratmasuk()
    {
        return $this->belongsTo(SuratMasuk::class, 'id_sm', 'id');
    }
}
