@extends('layouts.layoutsAdmin')

@section('title', 'Admin Dashboard - Book Management')

@push('styles')
<style>
    .stats-card {
        border: none;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }
    .stats-card:hover { transform: translateY(-5px); }
    .stats-card.primary {
        background: linear-gradient(45deg, #4e73df, #224abe);
        color: white;
    }
    .stats-value {
        font-size: 2rem;
        font-weight: bold;
    }
</style>
@endpush

@section('content')
<main class="col-lg-10 col-md-9 ms-sm-auto px-4 py-4">

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Book Management</h1>
    </div>

    {{-- STAT --}}
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card primary h-100 py-2">
                <div class="card-body">
                    <div class="text-uppercase mb-1 small fw-bold">Total Books</div>
                    <div class="stats-value">{{ $books->count() }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 fw-bold text-primary">Daftar Buku</h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
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

                            {{-- JUDUL + COVER (BALIK LAGI) --}}
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($book->image_path)
                                        <img src="{{ asset($book->image_path) }}"
                                             class="rounded me-2"
                                             style="width:40px;height:60px;object-fit:cover;">
                                    @else
                                        <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center"
                                             style="width:40px;height:60px;">
                                            <i class="fas fa-book text-muted"></i>
                                        </div>
                                    @endif
                                    <span class="fw-bold">{{ $book->title }}</span>
                                </div>
                            </td>

                            <td>{{ $book->author }}</td>

                            <td>
                                <span class="badge bg-secondary">{{ $book->genre }}</span>
                            </td>

                            <td>
                                @if ($book->status === 'approved')
                                    <span class="badge bg-success">Disetujui</span>
                                @elseif ($book->status === 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">

                                    {{-- LIHAT DETAIL (FIX, NO 404) --}}
                                    <a href="{{ route('book.show', $book->id) }}"
                                       class="btn btn-sm btn-info text-white"
                                       title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- JIKA PENDING --}}
                                    @if($book->status === 'pending')

                                        {{-- APPROVE --}}
                                        <form action="{{ url('/admin/validasi/'.$book->id.'/approve') }}"
                                              method="POST">
                                            @csrf
                                            <button type="submit"
                                                    class="btn btn-sm btn-success"
                                                    onclick="return confirm('Setujui buku ini?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>

                                        {{-- REJECT --}}
                                        <form action="{{ url('/admin/validasi/'.$book->id.'/reject') }}"
                                              method="POST">
                                            @csrf
                                            <button type="submit"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Tolak buku ini?')">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>

                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                Belum ada data buku.
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
