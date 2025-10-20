@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Edit Data Hafalan</h3>
        <a href="{{ route('hafalan.index') }}" class="btn btn-secondary mb-3">← Kembali</a>

        <form action="{{ route('hafalan.update', $hafalan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="anggota_id" class="form-label">Nama Anggota</label>
                <select name="anggota_id" id="anggota_id" class="form-select" required>
                    @foreach ($anggotas as $a)
                        <option value="{{ $a->id }}" {{ $hafalan->anggota_id == $a->id ? 'selected' : '' }}>
                            {{ $a->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal Hafalan</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $hafalan->tanggal }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="nama_surat" class="form-label">Nama Surat</label>
                <input type="text" name="nama_surat" id="nama_surat" class="form-control"
                    value="{{ $hafalan->nama_surat }}" required>
            </div>

            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="ayat_awal" class="form-label">Ayat Awal</label>
                    <input type="number" name="ayat_awal" id="ayat_awal" class="form-control"
                        value="{{ $hafalan->ayat_awal }}" required>
                </div>
                <div class="col-md-6">
                    <label for="ayat_akhir" class="form-label">Ayat Akhir</label>
                    <input type="number" name="ayat_akhir" id="ayat_akhir" class="form-control"
                        value="{{ $hafalan->ayat_akhir }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea name="keterangan" id="keterangan" class="form-control" rows="3">{{ $hafalan->keterangan }}</textarea>
            </div>

            <button type="submit" class="btn btn-success">Perbarui Data</button>
        </form>
    </div>
@endsection
