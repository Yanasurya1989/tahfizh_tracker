<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anggota;
use App\Models\Presensi;
use Carbon\Carbon;

class PresensiController extends Controller
{
    public function index()
    {
        $anggotas = Anggota::all();
        $tanggal = Carbon::today()->toDateString();

        return view('presensi.index', compact('anggotas', 'tanggal'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'anggota_id' => 'required|exists:anggotas,id',
            'hadir' => 'required|boolean',
            'alasan' => 'nullable|string',
            'tanggal' => 'required|date',
        ]);

        // Cegah duplikasi data presensi pada tanggal sama
        Presensi::updateOrCreate(
            [
                'anggota_id' => $validated['anggota_id'],
                'tanggal' => $validated['tanggal'],
            ],
            [
                'hadir' => $validated['hadir'],
                'alasan' => $validated['alasan'] ?? null,
            ]
        );

        return response()->json(['success' => true]);
    }

    public function rekap(Request $request)
    {
        $start = $request->input('start', \Carbon\Carbon::today()->startOfMonth()->toDateString());
        $end = $request->input('end', \Carbon\Carbon::today()->toDateString());

        $rekap = \App\Models\Presensi::whereBetween('tanggal', [$start, $end])
            ->select(
                'anggota_id',
                \DB::raw('SUM(hadir) as total_hadir'),
                \DB::raw('COUNT(*) - SUM(hadir) as total_tidak_hadir')
            )
            ->groupBy('anggota_id')
            ->with([
                'anggota',
                // relasi untuk mengambil alasan ketidakhadiran
                'anggota.presensis' => function ($q) use ($start, $end) {
                    $q->whereBetween('tanggal', [$start, $end])
                        ->where('hadir', false)
                        ->whereNotNull('alasan');
                }
            ])
            ->get();

        return view('presensi.rekap', compact('rekap', 'start', 'end'));
    }
}
