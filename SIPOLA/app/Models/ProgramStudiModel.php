<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramStudiModel extends Model
{
    protected $table = 'program_studi';
    protected $primaryKey = 'id';
    protected $fillable = ['nama_prodi', 'jenjang'];

    public function mahasiswa() {
    return $this->hasMany(MahasiswaModel::class, 'id', 'id');
}

}