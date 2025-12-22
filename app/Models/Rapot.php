<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rapot extends Model
{
    protected $table = 'rapot';

    protected $fillable = [
        'santri_id',
        'admin_id',
        'semester_id',
        'nilai_akademik',
        'nilai_akhlak',
        'kehadiran',
        'catatan_guru',
        'tanggal_input',
    ];

    protected $casts = [
        'tanggal_input' => 'datetime',
    ];

    public $timestamps = false;

    protected function hitungPredikat(int $nilai): string
    {
        return match (true) {
            $nilai >= 90 => 'A',
            $nilai >= 80 => 'B',
            $nilai >= 70 => 'C',
            $nilai >= 60 => 'D',
            default      => 'E',
        };
    }

    public function getPredikatAkademikAttribute(): string
    {
        return $this->hitungPredikat($this->nilai_akademik);
    }

    public function getPredikatAkhlakAttribute(): string
    {
        return $this->hitungPredikat($this->nilai_akhlak);
    }

    protected function hitungPredikatKehadiran(int $nilai): string
    {
        return match (true) {
            $nilai >= 95 => 'Sangat Baik',
            $nilai >= 85 => 'Baik',
            $nilai >= 75 => 'Cukup',
            default      => 'Kurang',
        };
    }

    public function getPredikatKehadiranAttribute(): string
    {
        return $this->hitungPredikatKehadiran($this->kehadiran);
    }

    public function getNilaiRataRataAttribute(): float
    {
        return round(
            ($this->nilai_akademik + $this->nilai_akhlak + $this->kehadiran) / 3,
            2
        );
    }

    public function getPredikatAkhirAttribute(): string
    {
        return $this->hitungPredikat((int) $this->nilai_rata_rata);
    }

    protected $appends = [
        'predikat_akademik',
        'predikat_akhlak',
        'predikat_kehadiran',
        'nilai_rata_rata',
        'predikat_akhir',
    ];

    public function santri()
    {
        return $this->belongsTo(SantriDetail::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
