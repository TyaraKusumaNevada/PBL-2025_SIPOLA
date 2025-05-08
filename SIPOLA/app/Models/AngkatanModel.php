<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AngkatanModel extends Model
{
    protected $table = 'angkatan';
    protected $primaryKey = 'id_angkatan';
    protected $fillable = ['semester', 'tahun_ajaran'];

    public function mahasiswa() {
        return $this->hasMany(MahasiswaModel::class, 'id_angkatan');
    }
}

