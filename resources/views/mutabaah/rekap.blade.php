@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Rekap Mutabaah Tilawah Bulanan</h3>
        <a href="{{ route('mutabaah.index') }}" class="btn btn-secondary mb-3">← Kembali</a>

        <form method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-4">
                    <select name="anggota_id" class="form-select">
                        <option value="">-- Semua Anggota --</option>
                        @foreach ($anggotas as $a)
                            <option value="{{ $a->id }}" {{ $anggotaId == $a->id ? 'selected' : '' }}>
                                {{ $a->nama }}</option>
                        @endforeach
                    </select>
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
                    <th>Bulan</th>
                    <th>Total Ayat</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rekaps as $r)
                    <tr>
                        <td>{{ $r->anggota->nama }}</td>
                        <td>{{ $r->bulan }}</td>
                        <td>{{ $r->total_ayat }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">Tidak
