<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    {{-- ✅ Viewport wajib agar tampilan responsif di HP --}}
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Sistem Rekap Tahfidz')</title>

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    {{-- Custom Styles --}}
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #198754 !important;
        }

        .navbar-brand {
            font-weight: 600;
            color: white !important;
        }

        .navbar-nav .nav-link {
            color: white !important;
        }

        .navbar-nav .nav-link.active {
            font-weight: bold;
            border-bottom: 2px solid #ffc107;
        }

        footer {
            background-color: #198754;
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: 40px;
        }

        .card {
            border-radius: 12px;
        }

        /* ✅ Biar tabel tidak pecah di layar kecil */
        .table-responsive {
            overflow-x: auto;
        }
    </style>
</head>

<body>
    {{-- NAVBAR --}}
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">TahfidzTracker</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="{{ url('/anggota') }}"
                            class="nav-link {{ request()->is('anggota*') ? 'active' : '' }}">Anggota</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/hafalan/create') }}"
                            class="nav-link {{ request()->is('hafalan*') ? 'active' : '' }}">Input Hafalan</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/dashboard-tahfidz') }}"
                            class="nav-link {{ request()->is('dashboard-tahfidz') ? 'active' : '' }}">Dashboard</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- MAIN CONTENT --}}
    <main class="container mb-5">
        @yield('content')
    </main>

    {{-- FOOTER --}}
    <footer>
        <p class="mb-0">&copy; {{ date('Y') }} TahfidzTracker. All rights reserved.</p>
    </footer>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>

</html>
