<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggaran extends Model
{
    protected $table = 'anggaran';

    protected $fillable = [
        'kode_anggaran',
        'nama_kegiatan',
        'batas_honor',
        'sisa_anggaran',
    ];

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }
}
