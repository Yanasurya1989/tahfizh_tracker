@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Rekap Hafalan Anggota</h3>

        <form action="{{ route('hafalan.index') }}" method="GET" class="row g-3 mb-4">
            <div class="col-md-3">
                <select name="anggota_id" class="form-select">
                    <option value="">-- Semua Anggota --</option>
                    @foreach ($anggotas as $a)
                        <option value="{{ $a->id }}" {{ request('anggota_id') == $a->id ? 'selected' : '' }}>
                            {{ $a->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            </div>
            <div class="col-md-3">
                <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
            </div>

            <div class="col-md-3">
                <button class="btn btn-primary w-100">Filter</button>
            </div>
        </form>

        <a href="{{ route('hafalan.create') }}" class="btn btn-success mb-3">+ Tambah Hafalan</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Anggota</th>
                    <th>Nama Surat</th>
                    <th>Ayat</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($hafalans as $h)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($h->tanggal)->format('d/m/Y') }}</td>
                        <td>{{ $h->anggota->nama }}</td>
                        <td>{{ $h->nama_surat }}</td>
                        <td>{{ $h->ayat_awal }} - {{ $h->ayat_akhir }}</td>
                        <td>{{ $h->keterangan ?? '-' }}</td>
                        <td>
                            <a href="{{ route('hafalan.edit', $h->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('hafalan.destroy', $h->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm"
                                    onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data hafalan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
