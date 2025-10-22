@extends('layouts.app')

@section('content')
    <div class="container py-3">

        {{-- Header Presensi --}}
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <h4 class="fw-bold mb-0 text-success flex-grow-1 text-center text-md-start">
                Presensi Anggota – {{ $tanggal }}
            </h4>
            <a href="{{ url('/') }}" class="btn btn-secondary shadow-sm px-3 py-2 d-inline-flex align-items-center">
                <i class="bi bi-arrow-left-circle me-2"></i>
                <span>Kembali ke Halaman Utama</span>
            </a>
        </div>

        {{-- Tabel Presensi --}}
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle shadow-sm">
                <thead class="table-success">
                    <tr>
                        <th style="width: 40%">Nama Anggota</th>
                        <th style="width: 60%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($anggotas as $a)
                        <tr id="row-{{ $a->id }}">
                            <td class="fw-semibold">{{ $a->nama }}</td>
                            <td>
                                <div class="d-flex justify-content-center flex-wrap gap-2">
                                    <button class="btn btn-success btn-hadir" data-id="{{ $a->id }}">
                                        <i class="bi bi-check-circle"></i> Hadir
                                    </button>
                                    <button class="btn btn-danger btn-tidak-hadir" data-id="{{ $a->id }}">
                                        <i class="bi bi-x-circle"></i> Tidak Hadir
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <script>
        document.querySelectorAll('.btn-hadir').forEach(btn => {
            btn.addEventListener('click', function() {
                const anggota_id = this.dataset.id;
                const tanggal = "{{ $tanggal }}";
                const row = document.getElementById(`row-${anggota_id}`);
                const btnTidakHadir = row.querySelector('.btn-tidak-hadir');

                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';
                btn.disabled = true;

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
                }).then(r => r.json()).then(() => {
                    Swal.fire('✅', 'Presensi berhasil disimpan', 'success');
                    btn.innerHTML = '<i class="bi bi-check-circle-fill"></i> Sudah Hadir';
                    btn.classList.remove('btn-success');
                    btn.classList.add('btn-outline-success');
                    btnTidakHadir.disabled = true;
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
                        btn.innerHTML =
                            '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';
                        btn.disabled = true;

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
                        }).then(r => r.json()).then(() => {
                            Swal.fire('❌', 'Presensi tersimpan', 'success');
                            btn.innerHTML =
                                '<i class="bi bi-x-circle-fill"></i> Tidak Hadir';
                            btn.classList.remove('btn-danger');
                            btn.classList.add('btn-outline-danger');
                            btnHadir.disabled = true;
                        });
                    }
                });
            });
        });
    </script>

    <style>
        /* Tombol umum */
        .btn {
            transition: all 0.2s ease-in-out;
            border-radius: 10px;
            font-size: 0.9rem;
        }

        .btn:hover {
            transform: scale(1.03);
        }

        .btn:disabled {
            opacity: 0.85;
            cursor: not-allowed;
        }

        /* Tombol khusus “Kembali” */
        .btn-kembali {
            font-size: 0.9rem;
            border-radius: 10px;
            white-space: nowrap;
            transition: all 0.2s ease-in-out;
        }

        .btn-kembali:hover {
            transform: scale(1.03);
        }

        /* Tabel */
        table {
            border-radius: 12px;
            overflow: hidden;
            font-size: 0.95rem;
        }

        /* Judul halaman */
        h4 {
            font-weight: 600;
        }

        /* Responsif untuk layar kecil */
        @media (max-width: 768px) {
            h4 {
                width: 100%;
                font-size: 1rem;
                text-align: center;
                margin-bottom: 10px;
            }

            a.btn,
            .btn-kembali {
                width: 100%;
                justify-content: center;
            }

            th,
            td {
                font-size: 0.85rem;
                padding: 8px;
            }

            .btn {
                width: 100px;
                font-size: 0.8rem;
            }

            .table-responsive {
                border-radius: 10px;
            }
        }
    </style>
@endsection
