<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrangTua extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];
    public function users()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function siswas()
    {
        return $this->belongsTo(Siswa::class, 'id_siswa', 'id');
    }
}
