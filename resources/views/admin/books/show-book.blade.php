@extends('layouts.layoutsAdmin')

@section('title', 'Detail Buku - ' . $book->title)

@push('styles')
    <style>
        .book-cover-detail {
            width: 100%;
            max-width: 300px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .book-content {
            line-height: 1.8;
            font-size: 1.1rem;
            color: #333;
            text-align: justify;
        }
        .meta-info {
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
@endpush

@section('content')
<main class="col-lg-10 col-md-9 ms-sm-auto px-4 py-4">
    <div class="container">
        
        <a href="{{ url('/genre') }}" class="btn btn-outline-secondary mb-4">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Buku
        </a>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <div class="row">

                    {{-- ================= COVER BUKU ================= --}}
                    <div class="col-md-4 text-center mb-4 mb-md-0">
                        @if ($book->image_url)
                            <img 
                                src="{{ $book->image_url }}" 
                                alt="{{ $book->title }}" 
                                class="book-cover-detail"
                            >
                        @else
                            <div 
                                class="bg-light d-flex align-items-center justify-content-center book-cover-detail" 
                                style="height: 400px; margin: 0 auto;"
                            >
                                <div class="text-center text-muted">
                                    <i class="fas fa-book fa-4x mb-3"></i>
                                    <h5>No Image Available</h5>
                                </div>
                            </div>
                        @endif

                        <div class="mt-4">
                            <span class="badge bg-primary fs-6 px-3 py-2">
                                {{ $book->genre }}
                            </span>

                            <div class="mt-3">
                                @if($book->status === 'approved')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i> Verified
                                    </span>
                                @elseif($book->status === 'pending')
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-clock me-1"></i> Pending Review
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- ================= DETAIL BUKU ================= --}}
                    <div class="col-md-8">
                        <h1 class="fw-bold mb-2">{{ $book->title }}</h1>

                        <div class="meta-info mb-4 border-bottom pb-3">
                            <span class="me-3">
                                <i class="fas fa-user me-1"></i>
                                Penulis: <strong>{{ $book->author }}</strong>
                            </span>

                            <span class="me-3">
                                <i class="fas fa-calendar me-1"></i>
                                Tahun: <strong>{{ $book->year }}</strong>
                            </span>

                            <span>
                                <i class="fas fa-clock me-1"></i>
                                Diupdate: {{ $book->updated_at->format('d M Y') }}
                            </span>
                        </div>

                        <div class="book-content">
                            <h5 class="fw-bold mb-3">Sinopsis / Isi Buku:</h5>

                            <div 
                                class="content-text text-justify mb-4" 
                                style="min-height: 200px;"
                            >
                                {!! $finalContent !!}
                            </div>

                            @if($paginatedData->hasPages())
                                <div class="d-flex justify-content-center mt-4 pt-3 border-top">
                                    {{ $paginatedData->links() }}
                                </div>
                                <div class="text-center text-muted small mt-2">
                                    Halaman {{ $paginatedData->currentPage() }} 
                                    dari {{ $paginatedData->lastPage() }}
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</main>
@endsection
