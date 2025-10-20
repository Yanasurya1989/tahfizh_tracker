<?php

namespace App\Http\Controllers;

use App\Models\InputHafalan;
use App\Models\Anggota;
use Illuminate\Http\Request;

class ProgressTahfidzController extends Controller
{
    public function show($id)
    {
        $anggota = Anggota::findOrFail($id);

        // Ambil semua hafalan anggota ini
        $hafalan = InputHafalan::where('anggota_id', $id)
            ->orderBy('tanggal', 'asc')
            ->get();

        // Kelompokkan berdasarkan tanggal untuk grafik
        $grafikData = $hafalan->groupBy('tanggal')->map(function ($item) {
            return $item->sum(function ($h) {
                return $h->ayat_akhir - $h->ayat_awal + 1;
            });
        });

        return view('tahfidz.progress', compact('anggota', 'hafalan', 'grafikData'));
    }
}
