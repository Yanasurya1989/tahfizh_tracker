@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Tambah Hafalan Anggota</h3>
        <a href="{{ route('hafalan.index') }}" class="btn btn-secondary mb-3">← Kembali</a>

        <form action="{{ route('hafalan.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="anggota_id" class="form-label">Nama Anggota</label>
                <select name="anggota_id" id="anggota_id" class="form-select" required>
                    <option value="">-- Pilih Anggota --</option>
                    @foreach ($anggotas as $a)
                        <option value="{{ $a->id }}">{{ $a->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal Hafalan</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="nama_surat" class="form-label">Nama Surat</label>
                <input type="text" name="nama_surat" id="nama_surat" class="form-control"
                    placeholder="Contoh: Al-Baqarah" required>
            </div>

            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="ayat_awal" class="form-label">Ayat Awal</label>
                    <input type="number" name="ayat_awal" id="ayat_awal" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="ayat_akhir" class="form-label">Ayat Akhir</label>
                    <input type="number" name="ayat_akhir" id="ayat_akhir" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Catatan tambahan..."></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Hafalan</button>
        </form>
    </div>
@endsection
