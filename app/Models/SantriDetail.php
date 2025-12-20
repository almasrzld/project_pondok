<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SantriDetail extends Model
{
    protected $table = 'santri_detail';

    protected $fillable = [
        'user_id',
        'nisn',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat',
        'no_hp',
        'nama_wali',
        'no_hp_wali',
        'status_pendaftaran',
        'tanggal_daftar',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pembayaran()
    {
        return $this->hasMany(Pembayaran::class, 'santri_id');
    }
}
