<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifikasiSurat extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function suratkeluarinfo()
    {
        return $this->belongsTo(InformasiSurat::class, 'id_informasi', 'id');
    }

}
