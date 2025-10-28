@extends('layouts.app')

@section('content')
    <div class="container py-3">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
            <h4 class="fw-bold text-success mb-2 mb-md-0">
                🕓 Riwayat Presensi – {{ $anggota->nama }}
            </h4>
            <a href="{{ route('presensi.rekap') }}" class="btn btn-outline-secondary">
                ⬅️ Kembali ke Rekap
            </a>

            <a href="{{ route('presensi.rekap') }}" class="btn btn-outline-secondary shadow-sm">
                ⬅️ Kembali ke Rekap
            </a>

        </div>

        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-success">
                        <tr>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Alasan (Jika Tidak Hadir)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($riwayat as $r)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($r->tanggal)->translatedFormat('d M Y') }}</td>
                                <td>
                                    @if ($r->hadir)
                                        <span class="badge bg-success">Hadir</span>
                                    @else
                                        <span class="badge bg-danger">Tidak Hadir</span>
                                    @endif
                                </td>
                                <td>{{ $r->alasan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-muted">Belum ada riwayat presensi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        table {
            font-size: 0.95rem;
        }

        .badge {
            font-size: 0.9rem;
            padding: 0.5em 0.8em;
        }
    </style>
@endsection
