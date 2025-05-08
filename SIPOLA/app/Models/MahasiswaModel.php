<?php

namespace App\Models;

use App\Models\PrestasiModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MahasiswaModel extends Model
{
    protected $table = 'mahasiswa';
    protected $primaryKey = 'id_mahasiswa';
    protected $fillable = ['id_prodi', 'nama', 'nim', 'password', 'email', 'bidang_keahlian', 'minat', 'id_angkatan'];

    public function angkatan() {
        return $this->belongsTo(AngkatanModel::class, 'id_angkatan');
    }

    public function prodi() {
        return $this->belongsTo(ProgramStudiModel::class, 'id_prodi');
    }

    public function prestasi() {
        return $this->hasMany(PrestasiModel::class, 'id_mahasiswa');
    }

    public function rekomendasi() {
        return $this->hasMany(RekomendasiModel::class, 'id_mahasiswa');
    }
}

