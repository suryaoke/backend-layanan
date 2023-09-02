<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratMasuk extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    // public function suratmasuk()
    // {
    //     return $this->belongsTo(suratmasuk::class, 'id_sm', 'id');
    // }

    public function suratterkirim()
    {
        return $this->belongsTo(SuratMasukTerkirim::class, 'id_sm', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'tujuan', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'pengirim', 'id');
    }
}
