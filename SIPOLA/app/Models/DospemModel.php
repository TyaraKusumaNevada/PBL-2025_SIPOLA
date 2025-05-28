<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DospemModel extends Model
{
    protected $table = 'dospem';
    protected $primaryKey = 'id_dosen';
    protected $fillable = ['id_role', 'nama', 'nidn', 'email', 'password', 'bidang_minat'];

    public function role(): BelongsTo {         //1 dospem memiliki 1 role
        return $this->belongsTo(RoleModel::class, 'id_role', 'id_role');
    }

    public function rekomendasi() {
        return $this->hasMany(RekomendasiModel::class, 'id_dosen');
    }
    
}