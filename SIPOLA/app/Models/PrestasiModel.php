<?php

namespace App\Models;

use App\Models\MahasiswaModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PrestasiModel extends Model
{
    protected $table = 'prestasi';
    protected $primaryKey = 'id';
    protected $fillable = ['id_mahasiswa', 'nama_prestasi', 'kategori_prestasi', 'tingkat_prestasi', 'penyelenggara', 'tanggal', 'bukti_file', 'status'];

    public function mahasiswa() {
        return $this->belongsTo(MahasiswaModel::class, 'id_mahasiswa');
    }

    public function verifikasi() {
        return $this->hasMany(VerifikasiPrestasiModel::class, 'id_prestasi');
    }
}