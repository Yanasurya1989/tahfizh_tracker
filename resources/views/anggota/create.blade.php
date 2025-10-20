@extends('layouts.app')

@section('title', 'Tambah Anggota')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4 text-success">Tambah Anggota Baru</h2>

        <form action="{{ route('anggota.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Anggota</label>
                <input type="text" name="nama" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Foto (opsional)</label>
                <input type="file" name="foto" class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="{{ route('anggota.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
