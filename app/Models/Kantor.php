<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kantor extends Model
{
    protected $table = 'kantor';
    protected $primarykey = "id";
    protected $fillable = [
        'id',
        'kode_kantor',
        'nama_kantor',
        'updated_at',
        'created_at',
    ];

}
