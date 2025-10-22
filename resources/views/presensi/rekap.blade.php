@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Rekap Presensi</h3>

        <a href="{{ route('home') }}" class="btn btn-secondary">
            ← Kembali ke Halaman Utama
        </a>

        <form method="GET" action="{{ route('presensi.rekap') }}" class="row g-3 mb-4">
            <div class="col-md-4">
                <label for="start" class="form-label">Tanggal Mulai</label>
                <input type="date" id="start" name="start" value="{{ $start }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="end" class="form-label">Tanggal Akhir</label>
                <input type="date" id="end" name="end" value="{{ $end }}" class="form-control">
            </div>
            <div class="col-md-4 align-self-end">
                <button class="btn btn-primary w-100">Tampilkan</button>
            </div>
        </form>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Nama Anggota</th>
                    <th>Total Hadir</th>
                    <th>Total Tidak Hadir</th>
                    <th>Keterangan Ketidakhadiran</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rekap as $r)
                    <tr>
                        <td>{{ $r->anggota->nama }}</td>
                        <td>{{ $r->total_hadir }}</td>
                        <td>{{ $r->total_tidak_hadir }}</td>
                        <td>
                            @if ($r->total_tidak_hadir > 0 && $r->anggota->presensis->isNotEmpty())
                                <ul class="mb-0">
                                    @foreach ($r->anggota->presensis as $p)
                                        <li>
                                            {{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }} -
                                            <em>{{ $p->alasan }}</em>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <em>-</em>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Tidak ada data presensi pada rentang tanggal ini.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
