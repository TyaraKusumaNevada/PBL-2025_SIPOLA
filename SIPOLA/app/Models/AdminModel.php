<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminModel extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'id_admin';
    protected $fillable = ['id_role', 'nama', 'email', 'nomor_telepon', 'password'];

    public function role(): BelongsTo {         //1 admin memiliki 1 role
        return $this->belongsTo(RoleModel::class, 'id_role', 'id_role');
    }
}