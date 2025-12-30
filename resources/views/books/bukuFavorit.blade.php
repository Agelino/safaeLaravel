@extends('layouts.app')

@section('title', 'Buku Favorit')

@section('content')

<link rel="stylesheet" href="{{ asset('css/favorite.css') }}">

<div class="container py-4">

    <h3 class="mb-4 text-center fw-bold">
        ❤️ Buku Favorit Saya
    </h3>

    <div class="row g-4">
        @forelse ($favorites as $fav)
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 shadow-sm border-0 book-card">

                    <a href="{{ route('fullbacaan.show', $fav->book->id) }}"
                       class="text-decoration-none text-dark">

                        <div class="book-cover">
                            @if (!empty($fav->book->image_path))
                                <img src="{{ asset($fav->book->image_path) }}"
                                     alt="{{ $fav->book->title }}">
                            @else
                                <img src="https://via.placeholder.com/300x400?text=No+Cover"
                                     alt="No Image">
                            @endif
                        </div>

                        <div class="card-body text-center">
                            <h6 class="book-title">
                                {{ $fav->book->title }}
                            </h6>
                            <small class="text-muted">
                                {{ $fav->book->author }}
                            </small>
                        </div>
                    </a>

                    <div class="card-footer bg-white border-0 text-center">
                        <form action="{{ route('favorite.hapus') }}" method="POST">
                            @csrf
                            <input type="hidden" name="book_id" value="{{ $fav->book->id }}">
                            <button class="btn btn-outline-danger btn-sm w-100">
                                ❤️ Hapus dari Favorit
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12 empty-favorite">
                <h5>📚 Belum ada buku favorit</h5>
                <p>Tambahkan buku favorit dari halaman baca</p>
            </div>
        @endforelse
    </div>

</div>
@endsection
