@extends('layouts.app')

@section('content')
    <div class="container py-3">
        <h4 class="fw-bold mb-4 text-success">✏️ Edit Presensi – {{ $anggota->nama }}</h4>

        <form action="{{ route('presensi.update', $presensi->id) }}" method="POST" class="card p-4 shadow-sm">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Tanggal</label>
                <input type="text" class="form-control"
                    value="{{ \Carbon\Carbon::parse($presensi->tanggal)->translatedFormat('d M Y') }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label">Status Kehadiran</label>
                <select name="hadir" class="form-select">
                    <option value="1" {{ $presensi->hadir ? 'selected' : '' }}>Hadir</option>
                    <option value="0" {{ !$presensi->hadir ? 'selected' : '' }}>Tidak Hadir</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Alasan (jika tidak hadir)</label>
                <textarea name="alasan" class="form-control" rows="3">{{ $presensi->alasan }}</textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('presensi.riwayat', $anggota->id) }}" class="btn btn-outline-secondary">⬅️ Kembali</a>
                <button type="submit" class="btn btn-success">💾 Simpan Perubahan</button>
            </div>
        </form>
    </div>
@endsection
