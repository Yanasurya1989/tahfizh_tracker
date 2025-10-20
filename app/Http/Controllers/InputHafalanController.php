<?php

namespace App\Http\Controllers;

use App\Models\InputHafalan;
use App\Models\Anggota;
use Illuminate\Http\Request;

class InputHafalanController extends Controller
{
    public function index(Request $request)
    {
        $anggotas = \App\Models\Anggota::all();

        $query = \App\Models\InputHafalan::with('anggota')->orderBy('tanggal', 'desc');

        if ($request->filled('anggota_id')) {
            $query->where('anggota_id', $request->anggota_id);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }

        $hafalans = $query->get();

        return view('hafalan.index', compact('hafalans', 'anggotas'));
    }

    public function rekap(Request $request)
    {
        $anggotas = \App\Models\Anggota::all();

        $anggotaId = $request->anggota_id;

        // Query rekap bulanan
        $query = \App\Models\InputHafalan::selectRaw('
            anggota_id,
            DATE_FORMAT(tanggal, "%Y-%m") as bulan,
            SUM(ayat_akhir - ayat_awal + 1) as total_ayat
        ')
            ->groupBy('anggota_id', 'bulan')
            ->orderBy('bulan', 'asc')
            ->with('anggota');

        if ($anggotaId) {
            $query->where('anggota_id', $anggotaId);
        }

        $rekaps = $query->get();

        return view('hafalan.rekap', compact('rekaps', 'anggotas', 'anggotaId'));
    }

    public function create()
    {
        $anggotas = Anggota::all();
        return view('hafalan.create', compact('anggotas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggotas,id',
            'tanggal' => 'required|date',
            'nama_surat' => 'required|string|max:255',
            'ayat_awal' => 'required|integer',
            'ayat_akhir' => 'required|integer',
            'keterangan' => 'nullable|string',
        ]);

        InputHafalan::create($request->all());

        return redirect()->route('hafalan.index')->with('success', 'Data hafalan berhasil ditambahkan.');
    }

    public function edit(InputHafalan $hafalan)
    {
        $anggotas = Anggota::all();
        return view('hafalan.edit', compact('hafalan', 'anggotas'));
    }

    public function update(Request $request, InputHafalan $hafalan)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggotas,id',
            'tanggal' => 'required|date',
            'nama_surat' => 'required|string|max:255',
            'ayat_awal' => 'required|integer',
            'ayat_akhir' => 'required|integer',
            'keterangan' => 'nullable|string',
        ]);

        $hafalan->update($request->all());

        return redirect()->route('hafalan.index')->with('success', 'Data hafalan berhasil diperbarui.');
    }

    public function destroy(InputHafalan $hafalan)
    {
        $hafalan->delete();
        return redirect()->route('hafalan.index')->with('success', 'Data hafalan berhasil dihapus.');
    }
}
