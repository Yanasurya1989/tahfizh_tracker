<?php

namespace App\Http\Controllers;

use App\Models\Mutabaah;
use App\Models\Anggota;
use Illuminate\Http\Request;

class MutabaahController extends Controller
{
    public function index(Request $request)
    {
        $anggotas = Anggota::all();

        $query = Mutabaah::with('anggota')->orderBy('tanggal', 'desc');

        if ($request->filled('anggota_id')) {
            $query->where('anggota_id', $request->anggota_id);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal', [$request->start_date, $request->end_date]);
        }

        $mutabaahs = $query->get();

        return view('mutabaah.index', compact('mutabaahs', 'anggotas'));
    }

    public function rekap(Request $request)
    {
        $anggotas = Anggota::all();

        $anggotaId = $request->anggota_id;

        // Query rekap bulanan
        $query = Mutabaah::selectRaw('
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

        return view('mutabaah.rekap', compact('rekaps', 'anggotas', 'anggotaId'));
    }

    public function create()
    {
        $anggotas = Anggota::all();
        return view('mutabaah.create', compact('anggotas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggotas,id',
            'tanggal' => 'required|date',
            'nama_surat' => 'required|string|max:255',
            'ayat_awal' => 'required|integer|min:1',
            'ayat_akhir' => 'required|integer|min:1|gte:ayat_awal',
            'keterangan' => 'nullable|string',
            'shalat_duha' => 'nullable|boolean',
            'qiyamul_lail' => 'nullable|boolean',
        ]);

        Mutabaah::create([
            'anggota_id' => $request->anggota_id,
            'tanggal' => $request->tanggal,
            'nama_surat' => $request->nama_surat,
            'ayat_awal' => $request->ayat_awal,
            'ayat_akhir' => $request->ayat_akhir,
            'keterangan' => $request->keterangan,
            'shalat_duha' => $request->shalat_duha ? 1 : 0,
            'qiyamul_lail' => $request->qiyamul_lail ? 1 : 0,
        ]);

        return redirect()->route('mutabaah.index')->with('success', 'Data mutabaah tilawah berhasil ditambahkan.');
    }


    public function edit(Mutabaah $mutabaah)
    {
        $anggotas = Anggota::all();
        return view('mutabaah.edit', compact('mutabaah', 'anggotas'));
    }

    public function update(Request $request, Mutabaah $mutabaah)
    {
        $request->validate([
            'anggota_id' => 'required|exists:anggotas,id',
            'tanggal' => 'required|date',
            'nama_surat' => 'required|string|max:255',
            'ayat_awal' => 'required|integer|min:1',
            'ayat_akhir' => 'required|integer|min:1|gte:ayat_awal',
            'keterangan' => 'nullable|string',
            'shalat_duha' => 'nullable|boolean',
            'qiyamul_lail' => 'nullable|boolean',
        ]);

        $mutabaah->update([
            'anggota_id' => $request->anggota_id,
            'tanggal' => $request->tanggal,
            'nama_surat' => $request->nama_surat,
            'ayat_awal' => $request->ayat_awal,
            'ayat_akhir' => $request->ayat_akhir,
            'keterangan' => $request->keterangan,
            'shalat_duha' => $request->shalat_duha ? 1 : 0,
            'qiyamul_lail' => $request->qiyamul_lail ? 1 : 0,
        ]);

        return redirect()->route('mutabaah.index')->with('success', 'Data mutabaah tilawah berhasil diperbarui.');
    }


    public function destroy(Mutabaah $mutabaah)
    {
        $mutabaah->delete();
        return redirect()->route('mutabaah.index')->with('success', 'Data mutabaah tilawah berhasil dihapus.');
    }
}
