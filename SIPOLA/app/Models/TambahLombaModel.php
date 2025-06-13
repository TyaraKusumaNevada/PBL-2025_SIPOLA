<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TambahLombaModel extends Model
{
    protected $table = 'tambah_lomba';
    protected $primaryKey = 'id_tambahLomba';

    protected $fillable = ['nama_lomba', 'kategori_lomba', 'tingkat_lomba', 'jenis_lomba', 'penyelenggara_lomba', 'deskripsi', 'tanggal_mulai', 'tanggal_selesai', 'pamflet_lomba', 'status_verifikasi', 'link_pendaftaran', 'user_id'];
    
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function mahasiswa() {
        return $this->belongsTo(MahasiswaModel::class, 'id_mahasiswa', 'id_mahasiswa');
    }

    public function infoLomba() {
        return $this->hasOne(InfoLombaModel::class, 'id_lomba');
    }

    public function rekomendasi() {
        return $this->hasMany(RekomendasiModel::class, 'id_lomba');
    }
}