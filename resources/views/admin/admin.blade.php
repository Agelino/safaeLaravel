@extends('layouts.layoutsAdmin')

@section('title', 'Admin Dashboard - Book Management')

{{-- CSS Tambahan untuk Dashboard --}}
@push('styles')
    <style>
        .stats-card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .stats-card:hover { transform: translateY(-5px); }
        .stats-card.primary { background: linear-gradient(45deg, #4e73df, #224abe); color: white; }
        .stats-value { font-size: 2rem; font-weight: bold; }
        
        .table th { background-color: #f8f9fc; border-bottom: 2px solid #e3e6f0; }
        .table td { vertical-align: middle; }
    </style>
@endpush

@section('content')
{{-- GUNAKAN STRUKTUR INI AGAR RAPI DI SEBELAH SIDEBAR --}}
<main class="col-lg-10 col-md-9 ms-sm-auto px-4 py-4">
    
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Book Management</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Books</li>
                </ol>
            </nav>
        </div>
    </div>

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Stats Cards --}}
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card primary h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-uppercase mb-1 small font-weight-bold">Total Books</div>
                            {{-- HITUNG JUMLAH DATA ASLI --}}
                            <div class="stats-value mb-0">{{ $books->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-book fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Buku --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Buku</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Genre</th>
                            <th>Status</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($books as $book)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    {{-- TAMPILKAN GAMBAR KECIL --}}
                                    @if($book->image_path)
                                        <img src="{{ asset($book->image_path) }}" class="rounded me-2" style="width: 40px; height: 60px; object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center" style="width: 40px; height: 60px;">
                                            <i class="fas fa-book text-muted"></i>
                                        </div>
                                    @endif
                                    <span class="fw-bold">{{ $book->title }}</span>
                                </div>
                            </td>
                            <td>{{ $book->author }}</td>
                            <td><span class="badge bg-secondary">{{ $book->genre }}</span></td>
                            <td>
                                @if ($book->status == 'approved')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif ($book->status == 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    
                                    {{-- 1. Tombol DETAIL (Selalu Muncul) --}}
                                    <a href="{{ route('admin.show-book', $book->id) }}" class="btn btn-sm btn-info text-white" title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- 2. LOGIKA TOMBOL BERDASARKAN STATUS --}}
                                    @if($book->status == 'pending')
                                        {{-- JIKA PENDING: Muncul Terima & Tolak --}}
                                        <form action="{{ url('/admin/validasi/'.$book->id.'/approve') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success" title="Setujui" onclick="return confirm('Setujui buku ini?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>

                                        <form action="{{ url('/admin/validasi/'.$book->id.'/reject') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger" title="Tolak" onclick="return confirm('Tolak buku ini?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>

                                    @else
                              
                                        </form>
                                    @endif

                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fas fa-box-open fa-3x mb-3"></i>
                                <p>Belum ada data buku.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
{{-- Script toggle sidebar sudah ada di layout master --}}
@endpush