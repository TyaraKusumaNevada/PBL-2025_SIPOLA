<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MahasiswaModel extends Model
{
    use HasFactory;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'id_mahasiswa';

    protected $fillable = [
        'id', 
        'nama', 
        'nim', 
        'password', 
        'email', 
        'nomor_telepon',
        'bidang_keahlian', 
        'minat', 
        'id_angkatan', 
        'id_role',
    ];

    public function role(): BelongsTo {
        return $this->belongsTo(RoleModel::class, 'id_role', 'id_role');
    }

    public function prestasi(): HasMany {
        return $this->hasMany(PrestasiModel::class, 'id_mahasiswa', 'id_mahasiswa');
    }



    public function angkatan(): BelongsTo {
    return $this->belongsTo(AngkatanModel::class, 'id_angkatan', 'id_angkatan');
}


    public function prodi(): BelongsTo {
        return $this->belongsTo(ProgramStudiModel::class, 'id_prodi','id');

    }

    public function rekomendasi(): HasMany {
        return $this->hasMany(RekomendasiModel::class, 'id_mahasiswa');
    }
}
