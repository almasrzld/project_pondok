<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPembayaran extends Model
{
    protected $fillable = ['nama', 'harga'];
    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class);
    }
}
