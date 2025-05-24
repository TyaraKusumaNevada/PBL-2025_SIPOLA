<?php
namespace App\Models;

use App\Models\PrestasiModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MahasiswaModel extends Model
{
    protected $table = 'mahasiswa';
    protected $primaryKey = 'id_mahasiswa';
    
    // Menambahkan 'id_role' ke dalam $fillable
    protected $fillable = [
        'id_prodi', 
        'nama', 
        'nim', 
        'password', 
        'email', 
        'bidang_keahlian', 
        'minat', 
        'id_angkatan', 
        'id_role', // Menambahkan id_role di sini
    ];

    public function role(): BelongsTo {         //1 mahasiswa memiliki 1 role
        return $this->belongsTo(RoleModel::class, 'id_role', 'id_role');
    }

    public function prestasi(): HasMany {       //mahasiswa memiliki banyak prestasi
        return $this->hasMany(PrestasiModel::class, 'id_mahasiswa', 'id_mahasiswa');
    }

    public function angkatan() {
        return $this->belongsTo(AngkatanModel::class, 'id_angkatan');
    }

    public function prodi() {
        return $this->belongsTo(ProgramStudiModel::class, 'id_prodi');
    }

    public function rekomendasi() {
        return $this->hasMany(RekomendasiModel::class, 'id_mahasiswa');
    }
}