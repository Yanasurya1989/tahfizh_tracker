@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap text-center text-md-start">
            <h3 class="mb-3 mb-md-0">📊 Rekap Presensi</h3>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary shadow-sm">
                ⬅️ Kembali ke Halaman Utama
            </a>
        </div>

        {{-- Form Filter --}}
        <form method="GET" action="{{ route('presensi.rekap') }}" class="row g-3 mb-4">
            <div class="col-md-4">
                <label for="start" class="form-label fw-semibold">Tanggal Mulai</label>
                <input type="date" id="start" name="start" value="{{ $start }}" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="end" class="form-label fw-semibold">Tanggal Akhir</label>
                <input type="date" id="end" name="end" value="{{ $end }}" class="form-control">
            </div>
            <div class="col-md-4 align-self-end">
                <button class="btn btn-primary w-100 fw-semibold">Tampilkan</button>
            </div>
        </form>

        {{-- Tabel Rekap --}}
        <div class="card shadow-sm border-0">
            <div class="card-body table-responsive">
                <table class="table table-striped table-bordered align-middle text-center">
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
                                <td class="fw-semibold">{{ $r->anggota->nama }}</td>
                                <td>{{ $r->total_hadir }}</td>
                                <td>{{ $r->total_tidak_hadir }}</td>
                                <td class="text-start">
                                    @if (!empty($r->keterangan_ketidakhadiran))
                                        <ul class="mb-0 ps-3">
                                            @foreach ($r->keterangan_ketidakhadiran as $k)
                                                <li>
                                                    <strong>{{ \Carbon\Carbon::parse($k['tanggal'])->translatedFormat('d M Y') }}</strong>
                                                    — {{ $k['alasan'] }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Tidak ada data presensi pada rentang tanggal ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <style>
        /* Responsif & tampilan tabel */
        table th,
        table td {
            vertical-align: middle;
        }

        ul {
            padding-left: 1rem;
            margin-bottom: 0;
        }

        /* Mobile optimization */
        @media (max-width: 768px) {
            .table {
                font-size: 14px;
            }

            th:nth-child(1),
            td:nth-child(1) {
                min-width: 130px;
            }

            th:nth-child(4),
            td:nth-child(4) {
                min-width: 220px;
                text-align: left;
            }
        }

        @media (max-width: 576px) {
            .btn {
                width: 100%;
            }

            .table th,
            .table td {
                padding: 8px;
            }
        }
    </style>
@endsection
