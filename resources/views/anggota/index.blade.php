@extends('layouts.app')

@section('title', 'Data Anggota')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-success">Data Anggota</h2>
            <a href="{{ route('anggota.create') }}" class="btn btn-success">➕ Tambah Anggota</a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($anggotas as $a)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $a->nama }}</td>
                        <td>
                            @if ($a->foto)
                                <img src="{{ asset('storage/' . $a->foto) }}" width="70" class="rounded">
                            @else
                                <span class="text-muted">Tidak ada foto</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('anggota.edit', $a->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('anggota.destroy', $a->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Hapus anggota ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Belum ada data anggota</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
