<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kontrak extends Model
{
    protected $table = 'kontrak';
    protected $fillable = [
        'mitra_id',
        'tanggal_kontrak',
        'tanggal_surat',
        'tanggal_bast',
        'status',
        'total_honor'
    ];

    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }
}
