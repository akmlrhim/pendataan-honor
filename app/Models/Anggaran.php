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
        'anggaran_diperbarui',
        'sisa_anggaran',
        'alokasi_anggaran'
    ];

    protected $casts = [
        'anggaran_diperbarui' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }
}
