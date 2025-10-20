@extends('layouts.app')

@section('title', 'Edit Anggota')

@section('content')
    <div class="container py-4">
        <h2 class="mb-4 text-success">Edit Data Anggota</h2>

        <form action="{{ route('anggota.update', $anggota->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Nama Anggota</label>
                <input type="text" name="nama" class="form-control" value="{{ $anggota->nama }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Foto Saat Ini</label><br>
                @if ($anggota->foto)
                    <img src="{{ asset('storage/' . $anggota->foto) }}" alt="Foto Anggota" width="100"
                        class="rounded mb-2">
                @else
                    <p class="text-muted">Belum ada foto.</p>
                @endif
                <input type="file" name="foto" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('anggota.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection
