<?php

namespace App\Models;

use App\Models\DospemModel;
use App\Models\AdminModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleModel extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'id_role';
    protected $fillable = ['role_kode', 'role_nama'];

    public function mahasiswa()
    {
        return $this->hasMany(MahasiswaModel::class, 'id_role');
    }

    public function dosen()
    {
        return $this->hasMany(DospemModel::class, 'id_role');
    }

    public function admin()
    {
        return $this->hasMany(AdminModel::class, 'id_role');
    }
}