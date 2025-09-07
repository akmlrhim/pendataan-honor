<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Kontrak extends Model
{
    protected $table = 'kontrak';

    protected $fillable = [
        'nomor_kontrak',
        'mitra_id',
        'tanggal_kontrak',
        'tanggal_surat',
        'tanggal_bast',
        'status',
        'total_honor',
        'keterangan',
        'tanggal_mulai',
        'tanggal_berakhir'
    ];

    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }

    // Accesor 
    public function getTanggalKontrakTerbilangAttribute()
    {
        return $this->formatTanggalIndo($this->tanggal_kontrak);
    }

    public function getTanggalSuratTerbilangAttribute()
    {
        return $this->formatTanggalIndo($this->tanggal_surat);
    }

    public function getTanggalBastTerbilangAttribute()
    {
        return $this->formatTanggalIndo($this->tanggal_bast);
    }

    private function formatTanggalIndo($tanggal)
    {
        if (!$tanggal) return null;

        $hariMap = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => "Jum'at",
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        $carbon = Carbon::parse($tanggal);
        $namaHari = $hariMap[$carbon->format('l')] ?? $carbon->format('l');

        return $namaHari . ', Tanggal ' .
            $this->terbilang($carbon->day) .
            ' Bulan ' . $carbon->translatedFormat('F') .
            ' Tahun ' . $this->terbilang($carbon->year);
    }

    private function terbilang($angka)
    {
        $bilangan = [
            '',
            'Satu',
            'Dua',
            'Tiga',
            'Empat',
            'Lima',
            'Enam',
            'Tujuh',
            'Delapan',
            'Sembilan',
            'Sepuluh',
            'Sebelas'
        ];

        if ($angka < 12) return $bilangan[$angka];
        elseif ($angka < 20) return $this->terbilang($angka - 10) . ' Belas';
        elseif ($angka < 100) return $this->terbilang(intval($angka / 10)) . ' Puluh ' . $this->terbilang($angka % 10);
        elseif ($angka < 200) return 'Seratus ' . $this->terbilang($angka - 100);
        elseif ($angka < 1000) return $this->terbilang(intval($angka / 100)) . ' Ratus ' . $this->terbilang($angka % 100);
        elseif ($angka < 2000) return 'Seribu ' . $this->terbilang($angka - 1000);
        elseif ($angka < 1000000) return $this->terbilang(intval($angka / 1000)) . ' Ribu ' . $this->terbilang($angka % 1000);

        return (string) $angka;
    }
}
