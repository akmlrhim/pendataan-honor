<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggaran extends Model
{
    protected $table = 'anggaran';

    protected $fillable = [
        'kode_anggaran',
        'nama_kegiatan',
        'pagu',
        'sisa_anggaran',
    ];

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }
}
