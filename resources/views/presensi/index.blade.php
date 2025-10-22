@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap text-center text-md-start">
            <h3 class="mb-3 mb-md-0">📅 Presensi Anggota - {{ $tanggal }}</h3>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary shadow-sm">
                ⬅️ Kembali ke Halaman Utama
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-success">
                        <tr>
                            <th>Nama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($anggotas as $a)
                            <tr>
                                <td>{{ $a->nama }}</td>
                                <td>
                                    <div class="d-flex flex-wrap justify-content-center gap-2">
                                        <button class="btn btn-success btn-hadir"
                                            data-id="{{ $a->id }}">Hadir</button>
                                        <button class="btn btn-danger btn-tidak-hadir" data-id="{{ $a->id }}">Tidak
                                            Hadir</button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Handle presensi hadir
        document.querySelectorAll('.btn-hadir').forEach(btn => {
            btn.addEventListener('click', function() {
                const anggota_id = this.dataset.id;
                const tanggal = "{{ $tanggal }}";

                fetch("{{ route('presensi.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        anggota_id: anggota_id,
                        hadir: 1,
                        tanggal: tanggal
                    })
                }).then(r => r.json()).then(res => {
                    Swal.fire('✅', 'Presensi berhasil disimpan', 'success');
                    // Ganti warna tombol agar terlihat sudah presensi
                    this.classList.remove('btn-success');
                    this.classList.add('btn-secondary');
                    this.innerText = 'Sudah Hadir';
                    this.disabled = true;
                    this.nextElementSibling.disabled = true;
                });
            });
        });

        // Handle presensi tidak hadir
        document.querySelectorAll('.btn-tidak-hadir').forEach(btn => {
            btn.addEventListener('click', function() {
                const anggota_id = this.dataset.id;
                const tanggal = "{{ $tanggal }}";

                Swal.fire({
                    title: 'Alasan tidak hadir?',
                    input: 'text',
                    inputPlaceholder: 'Masukkan alasan...',
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                }).then(result => {
                    if (result.isConfirmed) {
                        fetch("{{ route('presensi.store') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                anggota_id: anggota_id,
                                hadir: 0,
                                alasan: result.value,
                                tanggal: tanggal
                            })
                        }).then(r => r.json()).then(res => {
                            Swal.fire('📋', 'Presensi tersimpan', 'success');
                            // Ganti warna tombol agar terlihat sudah presensi
                            this.classList.remove('btn-danger');
                            this.classList.add('btn-secondary');
                            this.innerText = 'Sudah Tidak Hadir';
                            this.disabled = true;
                            this.previousElementSibling.disabled = true;
                        });
                    }
                });
            });
        });
    </script>

    <style>
        @media (max-width: 576px) {
            .btn {
                width: 100%;
            }
        }
    </style>
@endsection
