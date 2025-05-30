<?php

namespace App\Models;

use App\Models\MahasiswaModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrestasiModel extends Model
{
    protected $table = 'prestasi';
    protected $primaryKey = 'id_prestasi';
    protected $fillable = ['id_mahasiswa', 'nama_prestasi', 'kategori_prestasi', 'tingkat_prestasi', 'juara', 'penyelenggara', 'tanggal', 'bukti_file', 'status'];

    public function mahasiswa(): BelongsTo {        //1 prestasi milik 1 mahasiswa
        return $this->belongsTo(MahasiswaModel::class, 'id_mahasiswa', 'id_mahasiswa');
    }
}