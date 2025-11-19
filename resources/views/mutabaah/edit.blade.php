@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Edit Mutabaah Tilawah Anggota</h3>
        <a href="{{ route('mutabaah.index') }}" class="btn btn-secondary mb-3">← Kembali</a>

        <form action="{{ route('mutabaah.update', $mutabaah) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-3">
                <label for="anggota_id" class="form-label">Nama Anggota</label>
                <select name="anggota_id" id="anggota_id" class="form-select" required>
                    <option value="">-- Pilih Anggota --</option>
                    @foreach ($anggotas as $a)
                        <option value="{{ $a->id }}" {{ $mutabaah->anggota_id == $a->id ? 'selected' : '' }}>
                            {{ $a->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal Tilawah</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $mutabaah->tanggal }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="nama_surat" class="form-label">Nama Surat</label>
                <input type="text" name="nama_surat" id="nama_surat" class="form-control"
                    value="{{ $mutabaah->nama_surat }}" required>
            </div>

            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="ayat_awal" class="form-label">Ayat Awal</label>
                    <input type="number" name="ayat_awal" id="ayat_awal" class="form-control"
                        value="{{ $mutabaah->ayat_awal }}" required>
                </div>
                <div class="col-md-6">
                    <label for="ayat_akhir" class="form-label">Ayat Akhir</label>
                    <input type="number" name="ayat_akhir" id="ayat_akhir" class="form-control"
                        value="{{ $mutabaah->ayat_akhir }}" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label d-block">Shalat Duha</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="shalat_duha" name="shalat_duha" value="1">
                    <label class="form-check-label" for="shalat_duha">Iya</label>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label d-block">Qiyamul Lail</label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="qiyamul_lail" name="qiyamul_lail" value="1">
                    <label class="form-check-label" for="qiyamul_lail">Iya</label>
                </div>
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea name="keterangan" id="keterangan" class="form-control" rows="3">{{ $mutabaah->keterangan }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Update Mutabaah</button>
        </form>
    </div>
@endsection
