<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    protected $table = 'semester';

    protected $fillable = [
        'nama',
        'tahun_ajaran',
        'is_active',
        'is_locked',
    ];

    public function rapot()
    {
        return $this->hasMany(Rapot::class);
    }
}
