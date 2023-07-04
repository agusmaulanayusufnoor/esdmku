<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatan';
    protected $primarykey = "id";
    protected $fillable = [
        'id',
        'nama_jabatan',
        'updated_at',
        'created_at',
    ];
}
