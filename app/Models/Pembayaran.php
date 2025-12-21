<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'santri_id',
        'admin_id',
        'jenis_pembayaran_id',
        'bulan',
        'tahun',
        'jumlah',
        'tanggal_bayar',
        'status_pembayaran',
        'bukti_pembayaran',
    ];

    public function santri()
    {
        return $this->belongsTo(SantriDetail::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function jenisPembayaran()
    {
        return $this->belongsTo(JenisPembayaran::class);
    }
}
