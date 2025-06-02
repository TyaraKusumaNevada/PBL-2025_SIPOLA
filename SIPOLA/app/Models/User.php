<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'username', 'email', 'password', 'id_role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function mahasiswa(): HasOne {         //1 user memiliki 1 mahasiswa
        return $this->hasOne(MahasiswaModel::class, 'user_id');
    }

    public function role(): BelongsTo {         
        return $this->belongsTo(RoleModel::class, 'id_role', 'id_role');
    }
}