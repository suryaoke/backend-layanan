<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tahunajar extends Model
{
    use HasFactory;
    protected $guarded = [];

    // Dalam model Tahunajar
    public function rombels()
    {
        return $this->hasMany(Rombel::class, 'id_tahunjar', 'id');
    }

}
