<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformasiSurat extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function suratkeluar()
    {
        return $this->belongsTo(TujuanSurat::class, 'id', 'id_informasi');
    }
    
}
