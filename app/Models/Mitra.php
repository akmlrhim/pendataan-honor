<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    protected $table = 'mitra';

    protected $fillable = [
        'nms',
        'nama_lengkap',
        'jenis_kelamin',
        'alamat'
    ];
}
