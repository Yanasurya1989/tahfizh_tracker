@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">📖 Dashboard Rekap Tahfidz</h2>

        {{-- Statistik Utama --}}
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="text-secondary">Total Hafalan Bulan Ini</h5>
                        <h2 class="text-primary fw-bold">{{ $totalBulanIni }} Ayat</h2>
                        <small>{{ \Carbon\Carbon::parse($bulanIni . '-01')->translatedFormat('F Y') }}</small>
                    </div>
                </div>
            </div>
        </div>

        {{-- Top 5 Santri --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-success text-white fw-bold">🌟 Top 5 Anggota Bulan Ini</div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Peringkat</th>
                            <th>Nama Anggota</th>
                            <th>Total Ayat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($topSantri as $index => $s)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $s->anggota->nama }}</td>
                                <td>{{ $s->total_ayat }} ayat</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Belum ada data hafalan bulan ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Grafik Total Hafalan per Santri --}}
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white fw-bold">📊 Grafik Total Hafalan per Santri</div>
            <div class="card-body">
                <canvas id="chartTotal" height="120"></canvas>
            </div>
        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('chartTotal');

        const data = {
            labels: {!! json_encode($chartData->pluck('anggota.nama')) !!},
            datasets: [{
                label: 'Total Ayat Dihafal',
                data: {!! json_encode($chartData->pluck('total_ayat')) !!},
                borderWidth: 1,
                backgroundColor: '#0d6efd'
            }]
        };

        new Chart(ctx, {
            type: 'bar',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Total Ayat Hafalan Keseluruhan'
                    }
                }
            }
        });
    </script>
@endsection
