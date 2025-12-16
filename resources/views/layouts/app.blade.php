<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Safae')</title>

    <!-- Bootstrap & Font -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        /* Navbar */
        .navbar-custom {
            background: linear-gradient(90deg, #002147, #0d6efd);
            color: #fff;
            padding: 10px 25px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .navbar-custom span {
            font-weight: 600;
            font-size: 18px;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 56px;
            left: 0;
            width: 220px;
            height: calc(100vh - 56px);
            background-color: #002147;
            color: #fff;
            padding: 20px 10px;
        }

        .sidebar h4 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .sidebar a {
            color: #ddd;
            text-decoration: none;
            display: block;
            padding: 8px 15px;
            border-radius: 6px;
            margin-bottom: 5px;
            transition: 0.3s;
            font-size: 15px;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #0d6efd;
            color: #fff;
        }

        /* Main */
        main {
            margin-left: 240px;
            margin-top: 70px;
            padding: 20px 40px;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        /* Footer */
        .footer {
            background-color: #002147;
            color: #ddd;
            padding: 30px 40px;
            width: calc(100% - 220px); /* SISAIN RUANG SIDEBAR */
            margin-left: 220px;
        }

        .footer h5 {
            color: #fff;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .footer a {
            color: #ddd;
            text-decoration: none;
        }

        .footer a:hover {
            color: #0d6efd;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.2);
            margin-top: 20px;
            padding-top: 10px;
            font-size: 13px;
            text-align: center;
        }

        @media (max-width: 992px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }

            main,
            .footer {
                margin-left: 0;
                padding: 20px;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar-custom">
    <span>Helloo, {{ Auth::user()->username }} !!</span>

    <a href="{{ route('logout') }}"
       class="text-white text-decoration-none"
       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fa fa-user"></i> Logout
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
        @csrf
    </form>
</nav>

<!-- SIDEBAR -->
<aside class="sidebar">
    <h4>Safae</h4>

    <a href="#"><i class="fa fa-home me-2"></i> Home</a>
    <a href="#"><i class="fa fa-pen me-2"></i> Tulis Cerita</a>

    <a href="{{ route('genre.index') }}" class="{{ request()->is('genre*') ? 'active' : '' }}">
        <i class="fa fa-book me-2"></i> Genre Buku
    </a>

    <a href="{{ route('bukufavorit') }}" class="{{ request()->is('bukufavorit') ? 'active' : '' }}">
        <i class="fa fa-heart me-2"></i> Buku Favorit
    </a>

    <a href="{{ route('reading.history') }}" class="{{ request()->is('riwayat-baca*') ? 'active' : '' }}">
        <i class="fa fa-clock me-2"></i> Riwayat Baca
    </a>

    <a href="{{ route('forum.index') }}">
        <i class="fa fa-comments me-2"></i> Forum
    </a>

    <a href="{{ route('reward.index') }}">
        <i class="fa fa-gift me-2"></i> Reward
    </a>
</aside>

<!-- CONTENT -->
<main>
    @yield('content')
</main>

<!-- FOOTER -->
<footer class="footer">
    <div class="row">
        <div class="col-md-6 mb-3">
            <h5>About Us</h5>
            <p>
                Safae adalah platform baca dan tulis cerita digital
                yang mendukung kreativitas dan literasi.
            </p>
            <a href="{{ route('about.index') }}">
                Selengkapnya <i class="fa fa-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="col-md-6 mb-3">
            <h5>Contact Us</h5>
            <p>
                Punya pertanyaan atau saran?
                Jangan ragu menghubungi kami.
            </p>
            <a href="{{ route('contact.index') }}">
                Hubungi Kami <i class="fa fa-envelope ms-1"></i>
            </a>
        </div>
    </div>

    <div class="footer-bottom">
        © {{ date('Y') }} Safae. All rights reserved.
    </div>
</footer>

@stack('scripts')
</body>
</html>
