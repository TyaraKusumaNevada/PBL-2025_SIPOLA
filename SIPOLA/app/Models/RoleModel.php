<?php

namespace App\Models;

use App\Models\DospemModel;
use App\Models\AdminModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoleModel extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'id_role';
    protected $fillable = ['role_kode', 'role_nama'];

    public function mahasiswas(): HasMany {        //1 role memiliki banyak mahasiswa
        return $this->hasMany(MahasiswaModel::class, 'id_role', 'id_role');
    }

    public function dospems(): HasMany {          //1 role memiliki banyak dospem
        return $this->hasMany(DospemModel::class, 'id_role', 'id_role');
    }

    public function admins(): HasMany {          //1 role memiliki banyak admin
        return $this->hasMany(AdminModel::class, 'id_role', 'id_role');
    }

    public function users(): HasMany {          //1 role memiliki banyak admin
        return $this->hasMany(User::class, 'id_role', 'id_role');
    }
}