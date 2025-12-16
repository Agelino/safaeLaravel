@extends('layouts.layoutsAdmin')
@section('title', 'Kelola Ulasan')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4">Kelola Ulasan</h2>

    <div class="card">
        <div class="card-header">
            <strong>Daftar Ulasan Buku</strong>
        </div>

        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nama Penulis Ulasan</th>
                        <th>Judul Buku</th>
                        <th>Rating</th>
                        <th>Waktu</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($reviews as $review)
                        <tr>
                            <td>{{ $review->id }}</td>
                            <td>{{ $review->user->nama_depan ?? $review->user->name ?? 'Tidak ada' }}</td>
                            <td>{{ $review->book->title ?? 'Tidak ada' }}</td>
                            <td>{{ $review->rating }} / 5</td>
                            <td>{{ $review->created_at->format('d M Y') }}</td>

                            <td class="text-center">
                                <a href="{{ route('admin.reviews.show', $review->id) }}" 
                                   class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> Detail
                                </a>

                               
                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Hapus ulasan ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada ulasan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection
