@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="mb-4">Presensi Anggota - {{ $tanggal }}</h3>

        <table class="table table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th>Nama</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($anggotas as $a)
                    <tr id="row-{{ $a->id }}">
                        <td class="fw-semibold">{{ $a->nama }}</td>
                        <td>
                            <button class="btn btn-success btn-hadir" data-id="{{ $a->id }}">
                                Hadir
                            </button>
                            <button class="btn btn-danger btn-tidak-hadir" data-id="{{ $a->id }}">
                                Tidak Hadir
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.querySelectorAll('.btn-hadir').forEach(btn => {
            btn.addEventListener('click', function() {
                const anggota_id = this.dataset.id;
                const tanggal = "{{ $tanggal }}";
                const row = document.getElementById(`row-${anggota_id}`);
                const btnTidakHadir = row.querySelector('.btn-tidak-hadir');

                // Kirim data ke server
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

                    // Ubah tampilan tombol
                    btn.innerHTML = '<i class="bi bi-check-circle-fill"></i> Sudah Hadir';
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-outline-success');
                    btn.disabled = true;

                    btnTidakHadir.disabled = true;
                    btnTidakHadir.classList.add('btn-outline-secondary');
                });
            });
        });

        document.querySelectorAll('.btn-tidak-hadir').forEach(btn => {
            btn.addEventListener('click', function() {
                const anggota_id = this.dataset.id;
                const tanggal = "{{ $tanggal }}";
                const row = document.getElementById(`row-${anggota_id}`);
                const btnHadir = row.querySelector('.btn-hadir');

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
                            Swal.fire('✅', 'Presensi tersimpan', 'success');

                            // Ubah tampilan tombol
                            btn.innerHTML =
                                '<i class="bi bi-x-circle-fill"></i> Tidak Hadir';
                            btn.classList.remove('btn-danger');
                            btn.classList.add('btn-outline-danger');
                            btn.disabled = true;

                            btnHadir.disabled = true;
                            btnHadir.classList.add('btn-outline-secondary');
                        });
                    }
                });
            });
        });
    </script>

    {{-- Bootstrap Icon --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        .btn {
            transition: all 0.2s ease-in-out;
        }

        .btn:disabled {
            cursor: not-allowed;
            opacity: 0.8;
        }
    </style>
@endsection
