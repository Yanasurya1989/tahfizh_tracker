<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\InputHafalan;

class HomeController extends Controller
{
    public function index()
    {
        $jumlahAnggota = Anggota::count();

        // Total seluruh ayat yang dihafal oleh semua santri
        $totalAyat = InputHafalan::sum(\DB::raw('ayat_akhir - ayat_awal + 1'));

        // Ambil 5 hafalan terakhir
        $hafalanTerbaru = InputHafalan::with('anggota')
            ->latest('tanggal')
            ->take(5)
            ->get();

        return view('home', compact('jumlahAnggota', 'totalAyat', 'hafalanTerbaru'));
    }
}
