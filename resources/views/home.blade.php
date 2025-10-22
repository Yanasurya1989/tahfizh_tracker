@extends('layouts.app')

@section('title', 'Beranda - TahfidzTracker')

@section('content')
    <div class="container py-4">

        {{-- Judul Halaman --}}
        <div class="text-center mb-4">
            <h1 class="fw-bold text-success mb-2">🌿 Selamat Datang di TahfidzTracker</h1>
            <p class="text-muted mb-4">Sistem Rekap Perkembangan Hafalan Anggota UPA</p>

            {{-- 🔹 Tambahan Menu Akses Cepat --}}
            <div class="d-flex justify-content-center gap-3">
                <a href="{{ route('presensi.index') }}" class="btn btn-outline-success">
                    📝 Input Presensi
                </a>
                <a href="{{ route('presensi.rekap') }}" class="btn btn-outline-primary">
                    📊 Rekap Presensi
                </a>
            </div>
        </div>

        {{-- Statistik Utama --}}
        <div class="row mb-5">
            <div class="col-md-6 mb-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="text-muted">Jumlah Anggota</h5>
                        <h2 class="fw-bold text-success">{{ $jumlahAnggota }}</h2>
                        <p>Anggota terdaftar</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <h5 class="text-muted">Total Hafalan</h5>
                        <h2 class="fw-bold text-primary">{{ $totalAyat }}</h2>
                        <p>Ayat telah dihafal</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Hafalan Terbaru --}}
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white fw-bold">
                📖 Hafalan Terbaru
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama Anggota</th>
                            <th>Surat</th>
                            <th>Ayat Awal</th>
                            <th>Ayat Akhir</th>
                            <th>Jumlah Ayat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($hafalanTerbaru as $h)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($h->tanggal)->translatedFormat('d M Y') }}</td>
                                <td>{{ $h->anggota->nama }}</td>
                                <td>{{ $h->nama_surat }}</td>
                                <td>{{ $h->ayat_awal }}</td>
                                <td>{{ $h->ayat_akhir }}</td>
                                <td>{{ $h->ayat_akhir - $h->ayat_awal + 1 }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Belum ada data hafalan yang masuk.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
