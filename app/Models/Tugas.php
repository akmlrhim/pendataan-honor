<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    protected $table = 'tugas';

    protected $fillable = [
        'kontrak_id',
        'anggaran_id',
        'deskripsi_tugas',
        'jumlah_dokumen',
        'jumlah_target_dokumen',
        'satuan',
        'harga_satuan',
        'harga_total_tugas'
    ];

    public function kontrak()
    {
        return $this->belongsTo(Kontrak::class);
    }

    public function anggaran()
    {
        return $this->belongsTo(Anggaran::class);
    }
}
