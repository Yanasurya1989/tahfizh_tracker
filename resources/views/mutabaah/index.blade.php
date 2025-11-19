@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Daftar Mutabaah Tilawah</h3>
        <a href="{{ route('mutabaah.create') }}" class="btn btn-primary mb-3">Tambah Mutabaah</a>
        <a href="{{ route('mutabaah.rekap') }}" class="btn btn-info mb-3">Rekap Bulanan</a>

        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <select name="anggota_id" class="form-select">
                        <option value="">-- Semua Anggota --</option>
                        @foreach ($anggotas as $a)
                            <option value="{{ $a->id }}" {{ request('anggota_id') == $a->id ? 'selected' : '' }}>
                                {{ $a->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3">
                    <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-secondary">Filter</button>
                </div>
            </div>
        </form>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama Anggota</th>
                    <th>Tanggal</th>
                    <th>Surat</th>
                    <th>Ayat Awal - Akhir</th>
                    <th>Shalat Duha</th>
                    <th>Qiyamul Lail</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($mutabaahs as $m)
                    <tr>
                        <td>{{ $m->anggota->nama }}</td>
                        <td>{{ $m->tanggal }}</td>
                        <td>{{ $m->nama_surat }}</td>
                        <td>{{ $m->ayat_awal }} - {{ $m->ayat_akhir }}</td>
                        <td>
                            @if ($m->shalat_duha)
                                <span class="badge bg-success">Iya</span>
                            @else
                                <span class="badge bg-danger">Tidak</span>
                            @endif
                        </td>
                        <td>
                            @if ($m->qiyamul_lail)
                                <span class="badge bg-success">Iya</span>
                            @else
                                <span class="badge bg-danger">Tidak</span>
                            @endif
                        </td>
                        <td>{{ $m->keterangan }}</td>
                        <td>
                            <a href="{{ route('mutabaah.edit', $m) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('mutabaah.destroy', $m) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">Tidak ada data mutabaah tilawah.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
