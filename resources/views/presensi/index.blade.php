@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">Presensi Anggota - {{ $tanggal }}</h3>
            <a href="{{ route('home') }}" class="btn btn-secondary">
                ← Kembali ke Halaman Utama
            </a>
        </div>

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
                        <td>{{ $a->nama }}</td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-success btn-hadir" data-id="{{ $a->id }}">Hadir</button>
                                <button class="btn btn-danger btn-tidak-hadir" data-id="{{ $a->id }}">Tidak
                                    Hadir</button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const token = '{{ csrf_token() }}';
        const urlStore = "{{ route('presensi.store') }}";
        const tanggal = "{{ $tanggal }}";

        function kunciTombol(anggota_id, status) {
            const row = document.querySelector(`#row-${anggota_id}`);
            const btnHadir = row.querySelector('.btn-hadir');
            const btnTidakHadir = row.querySelector('.btn-tidak-hadir');

            btnHadir.disabled = true;
            btnTidakHadir.disabled = true;

            if (status === 'hadir') {
                btnHadir.textContent = '✅ Sudah Hadir';
                btnHadir.classList.remove('btn-success');
                btnHadir.classList.add('btn-secondary');
            } else {
                btnTidakHadir.textContent = '❌ Tidak Hadir';
                btnTidakHadir.classList.remove('btn-danger');
                btnTidakHadir.classList.add('btn-secondary');
            }
        }

        document.querySelectorAll('.btn-hadir').forEach(btn => {
            btn.addEventListener('click', function() {
                const anggota_id = this.dataset.id;

                fetch(urlStore, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        anggota_id: anggota_id,
                        hadir: 1,
                        tanggal: tanggal
                    })
                }).then(r => r.json()).then(res => {
                    if (res.success) {
                        Swal.fire('✅', 'Presensi berhasil disimpan', 'success');
                        kunciTombol(anggota_id, 'hadir');
                    }
                });
            });
        });

        document.querySelectorAll('.btn-tidak-hadir').forEach(btn => {
            btn.addEventListener('click', function() {
                const anggota_id = this.dataset.id;

                Swal.fire({
                    title: 'Alasan tidak hadir?',
                    input: 'text',
                    inputPlaceholder: 'Masukkan alasan...',
                    showCancelButton: true,
                    confirmButtonText: 'Simpan',
                }).then(result => {
                    if (result.isConfirmed) {
                        fetch(urlStore, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({
                                anggota_id: anggota_id,
                                hadir: 0,
                                alasan: result.value,
                                tanggal: tanggal
                            })
                        }).then(r => r.json()).then(res => {
                            if (res.success) {
                                Swal.fire('✅', 'Presensi tersimpan', 'success');
                                kunciTombol(anggota_id, 'tidak_hadir');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
