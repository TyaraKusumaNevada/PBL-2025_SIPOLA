<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BidangMinatModel extends Model
{
    use HasFactory;

    protected $table = 'bidang_minat';

    protected $fillable = ['nama_minat', 'parent_id'];
}