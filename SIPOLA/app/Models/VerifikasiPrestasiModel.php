<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifikasiPrestasiModel extends Model
{
    protected $table = 'verifikasi_prestasi';
    protected $primaryKey = 'id_verifikasi';
    protected $fillable = ['id_prestasi', 'verifikator_type', 'id_verifikator', 'status', 'catatan', 'tanggal_verifikasi'];

    public function prestasi() {
        return $this->belongsTo(PrestasiModel::class, 'id_prestasi');
    }
}

