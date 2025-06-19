<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreferensiMahasiswaModel extends Model
{
    use HasFactory;

    protected $table = 'preferensi_mahasiswa';

    protected $fillable = [
        'user_id',
        'bidang_minat_id',
        'prefer_format',
        'prefer_tipe_lomba',
        'max_biaya',
        'min_hadiah',
        'min_tingkat',
        'min_sisa_hari',
    ];

    public function mahasiswa() {
        return $this->belongsTo(MahasiswaModel::class, 'user_id', 'user_id');
    }
}