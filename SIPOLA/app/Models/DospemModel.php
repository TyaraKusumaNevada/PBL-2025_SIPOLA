<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DospemModel extends Model
{
    protected $table = 'dospem';
    protected $primaryKey = 'id_dosen';
    protected $fillable = ['id_role', 'nama', 'nidn', 'email', 'password', 'bidang_minat'];

    public function rekomendasi() {
        return $this->hasMany(RekomendasiModel::class, 'id_dosen');
    }
}