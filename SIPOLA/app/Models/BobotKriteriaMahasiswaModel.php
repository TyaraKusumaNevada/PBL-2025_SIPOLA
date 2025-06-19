<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BobotKriteriaMahasiswaModel extends Model
{
    use HasFactory;

    protected $table = 'bobot_kriteria_mahasiswa';

    protected $fillable = [
        'user_id',
        'bobot_biaya',
        'bobot_hadiah',
        'bobot_tingkat',
        'bobot_sisa_hari',
        'bobot_format',
        'bobot_minat',
        'bobot_tipe_lomba'
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(MahasiswaModel::class, 'user_id', 'user_id');
    }
}