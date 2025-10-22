<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'anggota_id',
        'tanggal',
        'hadir',
        'alasan',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
}
