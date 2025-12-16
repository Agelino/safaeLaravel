<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Admin Dashboard')</title>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/admin-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/book-management.css') }}">
    @stack('styles')
</head>
<body>

    <!-- SIDEBAR -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <h3><i class="fas fa-book-open me-2"></i>BookAdmin</h3>
        </div>

        <ul class="sidebar-menu">

            {{-- DASHBOARD --}}
            <li class="{{ request()->is('admin') ? 'active' : '' }}">
                <a href="{{ url('/admin') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i> Dashboard
                </a>
            </li>

            {{-- KELOLA GENRE & BUKU --}}
            <li class="{{ request()->is('admin/genre') || request()->is('admin/books*') ? 'active' : '' }}">
                <a href="{{ url('/admin/genre') }}">
                    <i class="fa-solid fa-book"></i> Kelola Genre & Buku
                </a>
            </li>

            {{-- KELOLA USER --}}
            <li class="{{ request()->is('admin/users') || request()->is('admin/users*') ? 'active' : '' }}">
                <a href="{{ url('/admin/users') }}">
                    <i class="fa-solid fa-circle-user"></i> Kelola User
                </a>
            </li>

            {{-- KELOLA FORUM --}}
            <li class="{{ request()->is('admin/forum') || request()->is('admin/forum*') ? 'active' : '' }}">
                <a href="{{ url('/admin/forum') }}">
                    <i class="fa-solid fa-comment"></i> Kelola Forum
                </a>
            </li>

            {{-- KELOLA RIWAYAT BACA --}}
            <li class="{{ request()->is('kelola-riwayat') || request()->is('kelola-riwayat*') ? 'active' : '' }}">
                <a href="{{ url('/kelola-riwayat') }}">
                    <i class="fa-solid fa-clock-rotate-left"></i> Kelola Riwayat Baca
                </a>
            </li>

            {{-- TULIS BUKU (USER) --}}
            <li class="{{ request()->is('tulis-buku') ? 'active' : '' }}">
                <a href="{{ url('/tulis-buku') }}">
                    <i class="fas fa-fw fa-pen"></i> Tulis Buku
                </a>
            </li>

            <li>
            <a href="{{ route('admin.reviews.index') }}">
                <i class="fa-solid fa-star"></i> Kelola Ulasan
            </a>
          </li>
          
        </ul>
    </nav>

    <!-- HEADER -->
    <header class="admin-header">
        <button class="sidebar-toggle d-md-none"><i class="fas fa-bars"></i></button>

        <div class="search-box">
            <input type="text" placeholder="Search...">
            <i class="fas fa-search"></i>
        </div>

        <div class="user-menu">
            <div class="user-info">
                <p class="user-name mb-0">{{ Auth::user()->username ?? 'Admin' }}</p>
                <small class="user-role">Administrator</small>
            </div>

            <img src="https://via.placeholder.com/40" alt="User" class="user-img ms-3">

            {{-- LOGOUT --}}
            <form action="{{ route('admin.logout') }}" method="POST" class="ms-3">
                @csrf
                <button class="btn logout">Logout</button>
            </form>
        </div>
    </header>

    <!-- CONTENT -->
    <main>
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

</body>
</html>