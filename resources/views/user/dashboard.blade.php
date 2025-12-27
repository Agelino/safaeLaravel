@extends('layouts.app')

@section('title', 'Dashboard User - Safae')

@section('content')
<style>
    .dashboard-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
        border-radius: 15px;
        overflow: hidden;
    }
    
    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }
    
    .stat-icon {
        font-size: 3rem;
        opacity: 0.2;
        position: absolute;
        right: 20px;
        top: 20px;
    }
    
    .activity-item {
        border-left: 3px solid #0d6efd;
        padding-left: 15px;
        margin-bottom: 15px;
    }
    
    .activity-time {
        font-size: 0.85rem;
        color: #6c757d;
    }
    
    .book-card-mini {
        transition: all 0.3s ease;
    }
    
    .book-card-mini:hover {
        transform: scale(1.05);
    }
    
    .gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .gradient-success {
        background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
    }
    
    .gradient-info {
        background: linear-gradient(135deg, #a1c4fd 0%, #c2e9fb 100%);
    }
    
    .gradient-warning {
        background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
    }
    
    .gradient-danger {
        background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
    }
    
    .progress-bar-custom {
        height: 8px;
        border-radius: 10px;
    }
    
    .section-title {
        font-weight: 600;
        margin-bottom: 20px;
        color: #2c3e50;
        position: relative;
        padding-bottom: 10px;
    }
    
    .section-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, #0d6efd, #667eea);
        border-radius: 2px;
    }
    
    .welcome-banner {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 30px;
        border-radius: 15px;
        margin-bottom: 30px;
    }
</style>

<div class="container-fluid px-4 py-5">
    <!-- Welcome Banner -->
    <div class="welcome-banner shadow">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="mb-2"><i class="fas fa-hand-sparkles me-2"></i>Selamat Datang, {{ Auth::user()->name }}!</h2>
                <p class="mb-0 opacity-75">Selamat membaca dan jelajahi koleksi buku kami hari ini</p>
            </div>
            <div class="col-md-4 text-end">
                <div class="d-flex justify-content-end align-items-center">
                    <div class="me-3">
                        <div class="fs-4 fw-bold">{{ $userPoints }}</div>
                        <small>Total Poin</small>
                    </div>
                    <i class="fas fa-trophy fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Buku -->
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card gradient-primary text-white shadow position-relative">
                <div class="card-body">
                    <i class="fas fa-book stat-icon"></i>
                    <h6 class="text-uppercase mb-3">Total Buku</h6>
                    <h2 class="mb-0 fw-bold">{{ number_format($totalBooks) }}</h2>
                    <small class="opacity-75">Buku tersedia</small>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card gradient-success text-dark shadow position-relative">
                <div class="card-body">
                    <i class="fas fa-users stat-icon"></i>
                    <h6 class="text-uppercase mb-3">Total Pengguna</h6>
                    <h2 class="mb-0 fw-bold">{{ number_format($totalUsers) }}</h2>
                    <small>Anggota terdaftar</small>
                </div>
            </div>
        </div>

        <!-- Buku Dibaca User -->
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card gradient-info text-dark shadow position-relative">
                <div class="card-body">
                    <i class="fas fa-book-reader stat-icon"></i>
                    <h6 class="text-uppercase mb-3">Buku Dibaca</h6>
                    <h2 class="mb-0 fw-bold">{{ $userBooksRead }}</h2>
                    <small>Buku yang Anda baca</small>
                </div>
            </div>
        </div>

        <!-- Total Reviews -->
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card gradient-warning text-dark shadow position-relative">
                <div class="card-body">
                    <i class="fas fa-star stat-icon"></i>
                    <h6 class="text-uppercase mb-3">Review Anda</h6>
                    <h2 class="mb-0 fw-bold">{{ $userReviews }}</h2>
                    <small>Review diberikan</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Tambahan -->
    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card shadow border-start border-primary border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Komentar Anda</h6>
                            <h3 class="mb-0 text-primary">{{ $userComments }}</h3>
                        </div>
                        <i class="fas fa-comments fa-2x text-primary opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card shadow border-start border-success border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Komentar</h6>
                            <h3 class="mb-0 text-success">{{ number_format($totalComments) }}</h3>
                        </div>
                        <i class="fas fa-comment-dots fa-2x text-success opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card shadow border-start border-info border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Total Review</h6>
                            <h3 class="mb-0 text-info">{{ number_format($totalReviews) }}</h3>
                        </div>
                        <i class="fas fa-star-half-alt fa-2x text-info opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card dashboard-card shadow border-start border-warning border-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-1">Poin Anda</h6>
                            <h3 class="mb-0 text-warning">{{ number_format($userPoints) }}</h3>
                        </div>
                        <i class="fas fa-gem fa-2x text-warning opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row g-4 mb-4">
        <!-- Buku Sedang Dibaca -->
        <div class="col-xl-6">
            <div class="card shadow-sm dashboard-card">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="section-title mb-0">
                        <i class="fas fa-book-open me-2 text-primary"></i>Buku yang Sedang Dibaca
                    </h5>
                </div>
                <div class="card-body">
                    @if($recentBooks->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentBooks as $history)
                                @if($history->book)
                                <a href="{{ route('book.show', $history->book->id) }}" class="list-group-item list-group-item-action border-0 px-0">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset($history->book->image_path ?? 'images/default-book.jpg') }}" 
                                             alt="{{ $history->book->title }}" 
                                             class="rounded me-3" 
                                             style="width: 50px; height: 70px; object-fit: cover;">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ Str::limit($history->book->title, 40) }}</h6>
                                            <small class="text-muted">
                                                <i class="fas fa-user me-1"></i>{{ $history->book->author }}
                                                <span class="mx-2">•</span>
                                                <i class="fas fa-clock me-1"></i>{{ $history->last_read_at->diffForHumans() }}
                                            </small>
                                        </div>
                                        <i class="fas fa-chevron-right text-muted"></i>
                                    </div>
                                </a>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada buku yang dibaca</p>
                            <a href="{{ route('genre.index') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-search me-2"></i>Jelajahi Buku
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Buku Terpopuler -->
        <div class="col-xl-6">
            <div class="card shadow-sm dashboard-card">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="section-title mb-0">
                        <i class="fas fa-fire me-2 text-danger"></i>Buku Terpopuler
                    </h5>
                </div>
                <div class="card-body">
                    @if($popularBooks->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($popularBooks as $book)
                            <a href="{{ route('book.show', $book->id) }}" class="list-group-item list-group-item-action border-0 px-0">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset($book->image_path ?? 'images/default-book.jpg') }}" 
                                         alt="{{ $book->title }}" 
                                         class="rounded me-3" 
                                         style="width: 50px; height: 70px; object-fit: cover;">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1">{{ Str::limit($book->title, 40) }}</h6>
                                        <small class="text-muted">
                                            <i class="fas fa-user me-1"></i>{{ $book->author }}
                                            <span class="mx-2">•</span>
                                            <i class="fas fa-eye me-1"></i>{{ $book->reading_histories_count }} pembaca
                                        </small>
                                    </div>
                                    <i class="fas fa-chevron-right text-muted"></i>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-fire fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data buku populer</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Another Row -->
    <div class="row g-4 mb-4">
        <!-- Aktivitas Terbaru -->
        <div class="col-xl-8">
            <div class="card shadow-sm dashboard-card">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="section-title mb-0">
                        <i class="fas fa-history me-2 text-info"></i>Aktivitas Terbaru Anda
                    </h5>
                </div>
                <div class="card-body">
                    @if($recentActivities->count() > 0)
                        @foreach($recentActivities as $activity)
                        <div class="activity-item">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <i class="fas {{ $activity['icon'] }} me-2 text-{{ $activity['color'] }}"></i>
                                    <span>{{ $activity['message'] }}</span>
                                </div>
                                <small class="activity-time">
                                    {{ \Carbon\Carbon::parse($activity['time'])->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-history fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada aktivitas</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Genre Populer -->
        <div class="col-xl-4">
            <div class="card shadow-sm dashboard-card">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="section-title mb-0">
                        <i class="fas fa-chart-pie me-2 text-success"></i>Genre Populer
                    </h5>
                </div>
                <div class="card-body">
                    @if($popularGenres->count() > 0)
                        @foreach($popularGenres as $genre)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="fw-medium">{{ $genre->genre }}</span>
                                <span class="text-muted">{{ $genre->total }} buku</span>
                            </div>
                            <div class="progress progress-bar-custom">
                                <div class="progress-bar bg-success" 
                                     role="progressbar" 
                                     style="width: {{ ($genre->total / $totalBooks) * 100 }}%">
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-chart-pie fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada data genre</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Buku Terbaru -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm dashboard-card">
                <div class="card-header bg-white border-0 py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="section-title mb-0">
                            <i class="fas fa-sparkles me-2 text-warning"></i>Buku Terbaru
                        </h5>
                        <a href="{{ route('genre.index') }}" class="btn btn-sm btn-outline-primary">
                            Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($latestBooks->count() > 0)
                        <div class="row g-3">
                            @foreach($latestBooks as $book)
                            <div class="col-md-2-4 col-sm-4 col-6">
                                <a href="{{ route('book.show', $book->id) }}" class="text-decoration-none">
                                    <div class="book-card-mini">
                                        <img src="{{ asset($book->image_path ?? 'images/default-book.jpg') }}" 
                                             alt="{{ $book->title }}" 
                                             class="w-100 rounded shadow-sm" 
                                             style="height: 200px; object-fit: cover;">
                                        <h6 class="mt-2 mb-1 text-dark">{{ Str::limit($book->title, 30) }}</h6>
                                        <small class="text-muted">{{ $book->author }}</small>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-book fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada buku baru</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4">
        <div class="col-md-3 col-sm-6">
            <a href="{{ route('genre.index') }}" class="text-decoration-none">
                <div class="card dashboard-card text-center shadow-sm border-0 h-100">
                    <div class="card-body py-4">
                        <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex p-3 mb-3">
                            <i class="fas fa-search fa-2x text-primary"></i>
                        </div>
                        <h6 class="mb-0">Jelajahi Buku</h6>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-6">
            <a href="{{ url('/tulis-buku') }}" class="text-decoration-none">
                <div class="card dashboard-card text-center shadow-sm border-0 h-100">
                    <div class="card-body py-4">
                        <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex p-3 mb-3">
                            <i class="fas fa-pen-nib fa-2x text-success"></i>
                        </div>
                        <h6 class="mb-0">Tulis Buku</h6>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-6">
            <a href="{{ route('favorite.index') }}" class="text-decoration-none">
                <div class="card dashboard-card text-center shadow-sm border-0 h-100">
                    <div class="card-body py-4">
                        <div class="rounded-circle bg-danger bg-opacity-10 d-inline-flex p-3 mb-3">
                            <i class="fas fa-heart fa-2x text-danger"></i>
                        </div>
                        <h6 class="mb-0">Buku Favorit</h6>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-6">
            <a href="{{ route('reading.history') }}" class="text-decoration-none">
                <div class="card dashboard-card text-center shadow-sm border-0 h-100">
                    <div class="card-body py-4">
                        <div class="rounded-circle bg-info bg-opacity-10 d-inline-flex p-3 mb-3">
                            <i class="fas fa-history fa-2x text-info"></i>
                        </div>
                        <h6 class="mb-0">Riwayat Baca</h6>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
