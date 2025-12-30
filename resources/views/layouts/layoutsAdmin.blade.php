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

{{-- SIDEBAR --}}
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

        {{-- GENRE & BUKU --}}
        <li class="{{ request()->is('admin/genre') || request()->is('admin/books*') ? 'active' : '' }}">
            <a href="{{ url('/admin/genre') }}">
                <i class="fa-solid fa-book"></i> Kelola Genre & Buku
            </a>
        </li>

        {{-- USER --}}
        <li class="{{ request()->is('admin/users*') ? 'active' : '' }}">
            <a href="{{ url('/admin/users') }}">
                <i class="fa-solid fa-circle-user"></i> Kelola User
            </a>
        </li>

        {{-- FORUM --}}
        <li class="{{ request()->is('admin/forum*') ? 'active' : '' }}">
            <a href="{{ url('/admin/forum') }}">
                <i class="fa-solid fa-comment"></i> Kelola Forum
            </a>
        </li>

        
                {{-- KELOLA KOMENTAR --}}
        <li class="{{ request()->is('admin/komentar*') ? 'active' : '' }}">
            <a href="{{ route('admin.komentar.index') }}">
                <i class="fa-solid fa-comments"></i> Kelola Komentar
            </a>
        </li>

        {{-- kelola reward --}}
        <li class="{{ request()->is('admin/reward') ? 'active' : '' }}">
            <a href="{{ route('admin.rewards.index') }}">
                <i class="fa-solid fa-gift"></i> Kelola Reward
            </a>
        </li>


        {{-- kelola buku fav --}}
        <li class="nav-item">
            <a href="{{ route('admin.favorit.index') }}"
        class="nav-link {{ request()->routeIs('admin.favorit.*') ? 'active' : '' }}">
            <i class="fas fa-heart"></i>
            <span>Kelola Buku Favorit</span>
        </a>
        </li>



        {{-- RIWAYAT BACA --}}
        <li class="{{ request()->is('admin/riwayat-baca*') ? 'active' : '' }}">
             <a href="{{ route('admin.kelolariwayat.index') }}">
             <i class="fa-solid fa-clock-rotate-left"></i> Kelola Riwayat Baca
             </a>
        </li>

        {{-- ULASAN (INI YANG BIKIN ERROR SEBELUMNYA) --}}
        <li class="{{ request()->is('admin/reviews*') ? 'active' : '' }}">
            <a href="{{ route('admin.reviews.index') }}">
                <i class="fa-solid fa-star"></i> Kelola Ulasan
            </a>
        </li>

        {{--Kelola pembayaran --}}
        <li class="{{ request()->is('admin/pembayaran*') ? 'active' : '' }}">
            <a href="{{ route('admin.pembayaran.index') }}">
                <i class="fa-solid fa-star"></i> Kelola Pembayaran
            </a>
        </li>


        {{-- TULIS BUKU --}}
        <li class="{{ request()->is('tulis-buku') ? 'active' : '' }}">
            <a href="{{ url('/tulis-buku') }}">
                <i class="fas fa-fw fa-pen"></i> Tulis Buku
            </a>
        </li>

        {{-- kelola notifikasi --}}
        <li class="{{ request()->is('admin/notifications*') ? 'active' : '' }}">
    <a href="{{ route('admin.notifications.index') }}">
    <i class="fa-solid fa-bell"></i> Kelola Notifikasi
</a>

</li>
    </ul>
</nav>

{{-- HEADER --}}
<header class="admin-header">
    <button class="sidebar-toggle d-md-none"><i class="fas fa-bars"></i></button>

    <div class="user-menu ms-auto d-flex align-items-center">
        <div class="user-info text-end me-3">
            <p class="mb-0 fw-bold">{{ Auth::user()->username }}</p>
            <small class="text-muted">Administrator</small>
        </div>
        
        <form action="{{ route('logout') }}" method="POST">
        @csrf
            <button class="btn btn-danger btn-sm">Logout</button>
        </form>
    </div>
</header>

{{-- CONTENT --}}
<main class="pt-3">
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')

</body>
</html>
