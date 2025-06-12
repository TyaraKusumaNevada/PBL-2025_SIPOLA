<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoLombaModel extends Model
{
    protected $table = 'info_lomba';
    protected $primaryKey = 'id_info';
    protected $fillable = ['id_lomba'];

    public function lomba() {
        return $this->belongsTo(TambahLombaModel::class, 'id_lomba');
    }
}