@extends('layouts.app')

@section('title', 'Genre Buku')

@section('content')

<link rel="stylesheet" href="{{ asset('css/genre.css') }}">

<!-- ================= FILTER & SEARCH ================= -->
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">

    <div class="filter-bar">
        <a href="{{ route('genre.index') }}"
           class="btn btn-outline-primary {{ empty($current_genre) ? 'active' : '' }}">
            Semua
        </a>

        @foreach($all_genres as $g)
            <a href="{{ route('genre.index', ['genre' => $g]) }}"
               class="btn btn-outline-primary {{ ($current_genre ?? null) == $g ? 'active' : '' }}">
                {{ $g }}
            </a>
        @endforeach
    </div>

    <form method="GET" action="{{ route('genre.index') }}" class="search-bar d-flex">
        <input type="hidden" name="genre" value="{{ $current_genre }}">
        <input type="text"
               name="search"
               class="form-control"
               placeholder="Cari buku..."
               value="{{ $search }}">
        <button class="btn btn-primary ms-1">
            <i class="fa fa-search"></i>
        </button>
    </form>
</div>

<!-- ================= GRID BUKU ================= -->
<div class="row g-2">

    @forelse($books_to_show as $book)
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
            <div class="card h-100">

                {{-- COVER BUKU --}}
                @if($book->image_path)
                    <img src="{{ asset($book->image_path) }}"
                         class="card-img-top"
                         alt="{{ $book->title }}">
                @else
                    <img src="https://via.placeholder.com/300x200?text=No+Image"
                         class="card-img-top">
                @endif

                <div class="card-body">
                    <h6 class="card-title">{{ $book->title }}</h6>
                    <p class="mb-1"><strong>Author:</strong> {{ $book->author }}</p>
                    <p class="mb-1"><strong>Genre:</strong> {{ $book->genre }}</p>
                    <p class="mb-0"><strong>Year:</strong> {{ $book->year }}</p>
                </div>

                {{-- FOOTER BUTTON --}}
                <div class="card-footer bg-white text-center d-flex justify-content-center gap-1">

                    {{-- VIEW (FIXED, NO ERROR) --}}
                    <a href="{{ route('book.show', $book->id) }}"
                       class="btn btn-sm btn-info text-white"
                       title="Lihat Buku">
                        <i class="fa fa-eye"></i>
                    </a>

                    {{-- FAVORITE --}}
                    @auth
                        @if(in_array($book->id, $favorites))
                            <button class="btn btn-sm btn-danger" disabled title="Sudah Favorit">
                                <i class="fa fa-heart"></i>
                            </button>
                        @else
                            <form action="{{ route('favorite.tambah') }}" method="POST">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                <button class="btn btn-sm btn-outline-danger" title="Tambah Favorit">
                                    <i class="fa fa-heart"></i>
                                </button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                           class="btn btn-sm btn-outline-danger"
                           title="Login untuk favorit">
                            <i class="fa fa-heart"></i>
                        </a>
                    @endauth

                </div>

            </div>
        </div>
    @empty
        <p class="text-center text-muted">Tidak ada buku ditemukan.</p>
    @endforelse

</div>

@endsection
