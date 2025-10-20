@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Rekap Hafalan Bulanan Anggota</h3>

        <form action="{{ route('hafalan.rekap') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-4">
                <select name="anggota_id" class="form-select">
                    <option value="">-- Semua Anggota --</option>
                    @foreach ($anggotas as $a)
                        <option value="{{ $a->id }}" {{ $anggotaId == $a->id ? 'selected' : '' }}>
                            {{ $a->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100">Tampilkan</button>
            </div>
        </form>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th>Nama Anggota</th>
                    <th>Total Ayat Dihafal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rekaps as $r)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($r->bulan . '-01')->translatedFormat('F Y') }}</td>
                        <td>{{ $r->anggota->nama }}</td>
                        <td><strong>{{ $r->total_ayat }}</strong> ayat</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Belum ada data rekap.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
