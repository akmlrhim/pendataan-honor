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

    protected $casts = [
        'tanggal_kontrak'   => 'date',
        'tanggal_surat'     => 'date',
        'tanggal_bast'      => 'date',
        'tanggal_mulai'     => 'date',
        'tanggal_berakhir'  => 'date',
    ];

    public function mitra()
    {
        return $this->belongsTo(Mitra::class);
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class);
    }

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

    // Accesor terbilang untuk tanggal
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
            $this->terbilangTanggal($carbon->day) .
            ' Bulan ' . $carbon->translatedFormat('F') .
            ' Tahun ' . $this->terbilangTanggal($carbon->year);
    }

    private function terbilangTanggal($angka)
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
        elseif ($angka < 20) return $this->terbilangTanggal($angka - 10) . ' Belas';
        elseif ($angka < 100) return $this->terbilangTanggal(intval($angka / 10)) . ' Puluh ' . $this->terbilangTanggal($angka % 10);
        elseif ($angka < 200) return 'Seratus ' . $this->terbilangTanggal($angka - 100);
        elseif ($angka < 1000) return $this->terbilangTanggal(intval($angka / 100)) . ' Ratus ' . $this->terbilangTanggal($angka % 100);
        elseif ($angka < 2000) return 'Seribu ' . $this->terbilangTanggal($angka - 1000);
        elseif ($angka < 1000000) return $this->terbilangTanggal(intval($angka / 1000)) . ' Ribu ' . $this->terbilangTanggal($angka % 1000);

        return (string) $angka;
    }

    // Accesor uang 
    public function getTotalHonorTerbilangAttribute()
    {
        return $this->terbilangUang($this->total_honor) . ' Rupiah';
    }

    private function terbilangUang($angka)
    {
        $angka = abs($angka);
        $baca = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];

        if ($angka < 12) {
            return " " . $baca[$angka];
        } elseif ($angka < 20) {
            return $this->terbilangUang($angka - 10) . " Belas";
        } elseif ($angka < 100) {
            return $this->terbilangUang(intval($angka / 10)) . " Puluh" . $this->terbilangUang($angka % 10);
        } elseif ($angka < 200) {
            return " Seratus" . $this->terbilangUang($angka - 100);
        } elseif ($angka < 1000) {
            return $this->terbilangUang(intval($angka / 100)) . " Ratus" . $this->terbilangUang($angka % 100);
        } elseif ($angka < 2000) {
            return " Seribu" . $this->terbilangUang($angka - 1000);
        } elseif ($angka < 1000000) {
            return $this->terbilangUang(intval($angka / 1000)) . " Ribu" . $this->terbilangUang($angka % 1000);
        } elseif ($angka < 1000000000) {
            return $this->terbilangUang(intval($angka / 1000000)) . " Juta" . $this->terbilangUang($angka % 1000000);
        } elseif ($angka < 1000000000000) {
            return $this->terbilangUang(intval($angka / 1000000000)) . " Miliar" . $this->terbilangUang($angka % 1000000000);
        } elseif ($angka < 1000000000000000) {
            return $this->terbilangUang(intval($angka / 1000000000000)) . " Triliun" . $this->terbilangUang($angka % 1000000000000);
        }

        return "";
    }
}
