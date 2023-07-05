<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status_pajak extends Model
{
    protected $table = 'status_pajak';
    protected $primarykey = "id";
    protected $fillable = [
        'id',
        'statuspajak',
        'updated_at',
        'created_at',
    ];
}
