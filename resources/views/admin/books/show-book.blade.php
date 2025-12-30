@extends('layouts.layoutsAdmin')

@section('title', 'Detail Buku - ' . $book->title)

@push('styles')
    <style>
        .book-cover-detail {
            width: 100%;
            max-width: 280px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            transition: transform 0.3s ease;
        }
        .book-cover-detail:hover {
            transform: scale(1.05);
        }
        .book-content {
            line-height: 1.9;
            font-size: 1.05rem;
            color: #2c3e50;
            text-align: justify;
        }
        .meta-info {
            font-size: 0.95rem;
            color: #6c757d;
        }
        .info-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            padding: 15px;
            color: white;
            margin-bottom: 15px;
        }
        .info-card i {
            font-size: 1.3rem;
            opacity: 0.9;
        }
        .description-box {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }
        .content-box {
            background: white;
            border: 1px solid #e9ecef;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .action-buttons .btn {
            margin: 5px;
        }
        .badge-custom {
            font-size: 0.85rem;
            padding: 8px 15px;
            border-radius: 20px;
        }
        .stats-card {
            background: #fff;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 10px;
        }
        .stats-card h4 {
            margin: 0;
            color: #667eea;
            font-weight: bold;
        }
        .stats-card p {
            margin: 5px 0 0;
            color: #6c757d;
            font-size: 0.85rem;
        }
    </style>
@endpush

@section('content')
<main class="col-lg-10 col-md-9 ms-sm-auto px-4 py-4">
    <div class="container-fluid">
        
        {{-- Header dengan Breadcrumb --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold mb-1">
                    <i class="fas fa-book-open text-primary me-2"></i>
                    Detail Buku
                </h2>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.genre.index') }}">Daftar Buku</a></li>
                        <li class="breadcrumb-item active">{{ $book->title }}</li>
                    </ol>
                </nav>
            </div>
            <a href="{{ route('admin.genre.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>
        </div>

        <div class="row">
            {{-- ================= SIDEBAR KIRI: COVER & INFO ================= --}}
            <div class="col-lg-3 col-md-4 mb-4">
                {{-- Cover Buku --}}
                <div class="text-center mb-4">
                    @if ($book->image_path)
                        <img 
                            src="{{ asset($book->image_path) }}" 
                            alt="{{ $book->title }}" 
                            class="book-cover-detail"
                            onerror="this.src='{{ asset('images/default-book.png') }}'"
                        >
                    @else
                        <div 
                            class="bg-light d-flex align-items-center justify-content-center book-cover-detail mx-auto" 
                            style="height: 380px;"
                        >
                            <div class="text-center text-muted">
                                <i class="fas fa-book fa-4x mb-3"></i>
                                <p class="mb-0 small">Tidak Ada Cover</p>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Genre Badge --}}
                <div class="text-center mb-3">
                    <span class="badge bg-primary badge-custom">
                        <i class="fas fa-tag me-1"></i>
                        {{ $book->genre }}
                    </span>
                </div>

                {{-- Status Badge --}}
                <div class="text-center mb-3">
                    @if($book->status === 'approved')
                        <span class="badge bg-success badge-custom">
                            <i class="fas fa-check-circle me-1"></i> Disetujui
                        </span>
                    @elseif($book->status === 'pending')
                        <span class="badge bg-warning text-dark badge-custom">
                            <i class="fas fa-clock me-1"></i> Menunggu Review
                        </span>
                    @else
                        <span class="badge bg-secondary badge-custom">
                            <i class="fas fa-question-circle me-1"></i> {{ ucfirst($book->status) }}
                        </span>
                    @endif
                </div>

                {{-- Stats Cards --}}
                <div class="stats-card">
                    <h4>{{ $book->reviews->count() }}</h4>
                    <p><i class="fas fa-star text-warning me-1"></i>Review</p>
                </div>

                <div class="stats-card">
                    <h4>{{ $book->komentar->count() }}</h4>
                    <p><i class="fas fa-comment text-info me-1"></i>Komentar</p>
                </div>

                <div class="stats-card">
                    <h4>{{ $book->readingHistories->count() }}</h4>
                    <p><i class="fas fa-book-reader text-success me-1"></i>Pembaca</p>
                </div>

                {{-- Action Buttons --}}
                <div class="action-buttons text-center mt-4">
                    <a href="{{ route('admin.buku.edit', $book->id) }}" class="btn btn-primary btn-sm w-100 mb-2">
                        <i class="fas fa-edit me-2"></i>Edit Buku
                    </a>
                    
                    <form method="POST" action="{{ route('admin.buku.hapus') }}" 
                          onsubmit="return confirm('Yakin ingin menghapus buku ini?')" class="d-inline w-100">
                        @csrf
                        <input type="hidden" name="id" value="{{ $book->id }}">
                        <button type="submit" class="btn btn-danger btn-sm w-100">
                            <i class="fas fa-trash me-2"></i>Hapus Buku
                        </button>
                    </form>
                </div>
            </div>

            {{-- ================= KONTEN UTAMA: DETAIL BUKU ================= --}}
            <div class="col-lg-9 col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        
                        {{-- Judul Buku --}}
                        <h1 class="fw-bold mb-3" style="color: #2c3e50; font-size: 2rem;">
                            {{ $book->title }}
                        </h1>

                        {{-- Meta Info --}}
                        <div class="meta-info mb-4 pb-3 border-bottom">
                            <div class="row">
                                <div class="col-md-4 mb-2">
                                    <i class="fas fa-user text-primary me-2"></i>
                                    <strong>Penulis:</strong> {{ $book->author }}
                                </div>
                                <div class="col-md-4 mb-2">
                                    <i class="fas fa-calendar text-success me-2"></i>
                                    <strong>Tahun:</strong> {{ $book->year }}
                                </div>
                                <div class="col-md-4 mb-2">
                                    <i class="fas fa-clock text-info me-2"></i>
                                    <strong>Update:</strong> {{ $book->updated_at->format('d M Y') }}
                                </div>
                            </div>
                        </div>

                        {{-- Deskripsi Buku --}}
                        @if($book->description)
                        <div class="description-box">
                            <h5 class="fw-bold mb-3">
                                <i class="fas fa-align-left me-2 text-primary"></i>
                                Deskripsi Buku
                            </h5>
                            <p class="mb-0" style="line-height: 1.8;">
                                {{ $book->description }}
                            </p>
                        </div>
                        @endif

                        {{-- Konten / Isi Buku --}}
                        <div class="content-box">
                            <h5 class="fw-bold mb-4">
                                <i class="fas fa-book-open me-2 text-primary"></i>
                                Isi Buku Lengkap
                            </h5>

                            <div class="book-content">
                                @if($book->content)
                                    {!! $finalContent !!}
                                @else
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Konten buku belum tersedia.
                                    </div>
                                @endif
                            </div>

                            {{-- Pagination --}}
                            @if($paginatedData->hasPages())
                                <div class="d-flex justify-content-center mt-5 pt-4 border-top">
                                    {{ $paginatedData->links() }}
                                </div>
                                <div class="text-center text-muted small mt-3">
                                    <i class="fas fa-file-alt me-1"></i>
                                    Halaman {{ $paginatedData->currentPage() }} dari {{ $paginatedData->lastPage() }}
                                    (Total {{ $paginatedData->total() }} baris)
                                </div>
                            @endif
                        </div>

                        {{-- Additional Info --}}
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="alert alert-light border">
                                    <div class="row text-center">
                                        <div class="col-md-4">
                                            <strong class="text-primary">ID Buku:</strong> #{{ $book->id }}
                                        </div>
                                        <div class="col-md-4">
                                            <strong class="text-success">Dibuat:</strong> {{ $book->created_at->format('d M Y H:i') }}
                                        </div>
                                        <div class="col-md-4">
                                            <strong class="text-info">Terakhir Update:</strong> {{ $book->updated_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</main>
@endsection
