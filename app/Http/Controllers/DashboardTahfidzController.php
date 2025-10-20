<?php

namespace App\Http\Controllers;

use App\Models\InputHafalan;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardTahfidzController extends Controller
{
    public function index()
    {
        $bulanIni = Carbon::now()->format('Y-m');

        // Total ayat semua santri bulan ini
        $totalBulanIni = InputHafalan::whereRaw('DATE_FORMAT(tanggal, "%Y-%m") = ?', [$bulanIni])
            ->selectRaw('SUM(ayat_akhir - ayat_awal + 1) as total')
            ->value('total') ?? 0;

        // Top 5 santri dengan hafalan terbanyak bulan ini
        $topSantri = InputHafalan::selectRaw('
                anggota_id,
                SUM(ayat_akhir - ayat_awal + 1) as total_ayat
            ')
            ->whereRaw('DATE_FORMAT(tanggal, "%Y-%m") = ?', [$bulanIni])
            ->groupBy('anggota_id')
            ->orderByDesc('total_ayat')
            ->with('anggota')
            ->take(5)
            ->get();

        // Total ayat per santri (untuk grafik keseluruhan)
        $chartData = InputHafalan::selectRaw('
                anggota_id,
                SUM(ayat_akhir - ayat_awal + 1) as total_ayat
            ')
            ->groupBy('anggota_id')
            ->with('anggota')
            ->get();

        return view('dashboard.tahfidz', compact('totalBulanIni', 'topSantri', 'chartData', 'bulanIni'));
    }
}
