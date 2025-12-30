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
    .stats-card:hover {
        transform: translateY(-5px);
    }
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

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
        <h1 class="h3 fw-bold">Book Management</h1>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- STATS --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card stats-card primary p-3">
                <div class="stats-value">{{ $books->count() }}</div>
                <div class="text-uppercase small">Total Buku</div>
            </div>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h6 class="fw-bold text-primary mb-0">Daftar Buku</h6>
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
                            <th width="20%" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse ($books as $book)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            {{-- COVER + JUDUL --}}
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($book->image_path)
                                        <img src="{{ asset($book->image_path) }}"
                                             style="width:40px;height:60px;object-fit:cover"
                                             class="rounded me-2">
                                    @else
                                        <div class="bg-light rounded me-2 d-flex align-items-center justify-content-center"
                                             style="width:40px;height:60px">
                                            <i class="fas fa-book text-muted"></i>
                                        </div>
                                    @endif
                                    <strong>{{ $book->title }}</strong>
                                </div>
                            </td>

                            <td>{{ $book->author }}</td>

                            <td>
                                <span class="badge bg-secondary">{{ $book->genre }}</span>
                            </td>

                            <td>
                                @if($book->status === 'approved')
                                    <span class="badge bg-success">Approved</span>
                                @elseif($book->status === 'rejected')
                                    <span class="badge bg-danger">Rejected</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">

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

                                    @else
                                        <span class="text-muted small">Sudah diproses</span>
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
