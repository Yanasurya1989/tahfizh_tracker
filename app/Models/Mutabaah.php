<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mutabaah extends Model
{
    use HasFactory;

    protected $fillable = [
        'anggota_id',
        'tanggal',
        'nama_surat',
        'ayat_awal',
        'ayat_akhir',
        'keterangan',
        'shalat_duha',
        'qiyamul_lail',
    ];


    // Relasi ke Anggota
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
}
