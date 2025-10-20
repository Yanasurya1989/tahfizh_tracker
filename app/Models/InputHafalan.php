<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InputHafalan extends Model
{
    use HasFactory;

    protected $fillable = [
        'anggota_id',
        'tanggal',
        'nama_surat',
        'ayat_awal',
        'ayat_akhir',
        'keterangan',
    ];

    // Relasi ke Anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
}
