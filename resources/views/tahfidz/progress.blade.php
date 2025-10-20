@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">📈 Progress Hafalan: {{ $anggota->nama }}</h2>

        {{-- Profil Singkat --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-body text-center">
                <img src="{{ asset('storage/' . $anggota->foto) }}" alt="Foto" width="100" height="100"
                    class="rounded-circle mb-3">
                <h4>{{ $anggota->nama }}</h4>
                <p class="text-muted">Total Hafalan: {{ $hafalan->sum(fn($h) => $h->ayat_akhir - $h->ayat_awal + 1) }} ayat
                </p>
            </div>
        </div>

        {{-- Grafik Hafalan --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-primary text-white fw-bold">📅 Grafik Perkembangan Hafalan</div>
            <div class="card-body">
                <canvas id="chartProgress" height="100"></canvas>
            </div>
        </div>

        {{-- Tabel Detail Hafalan --}}
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white fw-bold">📖 Rekap Hafalan Detail</div>
            <div class="card-body table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama Surat</th>
                            <th>Ayat Awal</th>
                            <th>Ayat Akhir</th>
                            <th>Jumlah Ayat</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($hafalan as $h)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($h->tanggal)->translatedFormat('d M Y') }}</td>
                                <td>{{ $h->nama_surat }}</td>
                                <td>{{ $h->ayat_awal }}</td>
                                <td>{{ $h->ayat_akhir }}</td>
                                <td>{{ $h->ayat_akhir - $h->ayat_awal + 1 }}</td>
                                <td>{{ $h->keterangan }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada hafalan yang tercatat.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('chartProgress');

        const labels = {!! json_encode($grafikData->keys()->toArray()) !!};
        const data = {!! json_encode($grafikData->values()->toArray()) !!};

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Ayat per Tanggal',
                    data: data,
                    fill: false,
                    borderColor: '#0d6efd',
                    tension: 0.3,
                    pointBackgroundColor: '#0d6efd'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Grafik Perkembangan Hafalan per Hari'
                    },
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Ayat'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Tanggal'
                        }
                    }
                }
            }
        });
    </script>
@endsection
