<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'foto',
    ];

    // Relasi ke InputHafalan
    public function hafalans()
    {
        return $this->hasMany(InputHafalan::class);
    }

    public function presensis()
    {
        return $this->hasMany(\App\Models\Presensi::class);
    }
}
